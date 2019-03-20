<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Venta;
use App\Archivo;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ClientsController extends Controller
{
    public function index(Request $request){
        //$clientes = Cliente::get('nombre','localidad','nif');
        if($request->has('filtro')){
            $filtro = $request->Input('filtro');
            $clientes = DB::table('clientes')
            ->select('id', 'Nombre', 'Localidad', 'CIF/NIF')
            ->where('Nombre', 'LIKE', '%'.$request->Input('filtro').'%')
            ->orWhere('Localidad','LIKE','%'.$request->Input('filtro').'%')
            ->orWhere('cif/nif','LIKE','%'.$request->Input('filtro').'%')
            ->paginate(10)
            ->appends('filtro',$request->Input('filtro'));

            
        }else{
            $filtro = null;
            $clientes = DB::table('clientes')
                ->select('id', 'Nombre', 'Localidad', 'CIF/NIF')
                ->paginate(10);
        }    
        return view('clients.clientes', compact('clientes','filtro'));
    }

    public function create(Request $request){
        Cliente::create($request->all());
        return redirect('/');
    }

    public function edit(Request $request, $id){
        try{
            Cliente::findOrFail($id)
                ->update([
                    'nombre' => $request->input('nombre'),
                    'direccion' => $request->input('direccion'),
                    'provincia' => $request->input('provincia'),
                    'localidad' => $request->input('localidad'),
                    'CIF/NIF' => $request->input('cif/nif'),
                    'email' => $request->input('email'),
                    'telefono' => $request->input('telefono'),
                    'cp' => $request->input('cp'),
                ]);

            return redirect()->back();
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function showClient($id){
        try{
            $cliente = Cliente::where('id',$id)->get(['id','nombre','direccion','provincia','localidad','cif/nif','email','telefono','cp']);
            $ventas = Venta::where('Id_Cliente',$id)->get(['id','Descripcion','Estado','Id_Cliente','Updated_at']);
            
            return view('clients.detalle_cli', compact('cliente','ventas'));
            
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function showSale($id){
        try{
            $venta = Venta::where('id',$id)->first();
            $archivos = Archivo::where('Id_Venta',$id)->get(["id","Tipo","Archivo","NombreOriginal","updated_at"]);
            return view('clients.detalle_ven',compact('venta','archivos'));
        }catch(Exception $ex){
			return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function upload(Request $request,$id){
            $file = $request->file('archivo');
            $originalFilename = $file->getClientOriginalName();
            $type = $request->Input("tipo");

            $filename = $id . "_" . $type . "_" . date('YmdHis', time()) . ".pdf";

            Storage::disk('public')->put($filename,file_get_contents($file),'public');

            $newFile = new Archivo;
            $newFile->Tipo = $type;
            $newFile->Archivo = $filename;
            $newFile->NombreOriginal = $originalFilename;
            $newFile->Id_Venta = $id;
            $newFile->save();
            
            return redirect()->back();
       
    }

    public function download(Request $request,$id){
        try{
            $file = Archivo::where('id',$id)->get();
            $originalName = $file[0]->NombreOriginal;
            $NameInDB = $file[0]->Archivo;
            if($originalName != ""){
                return Storage::disk('public')->download($NameInDB, $originalName);
            }else{
                return Storage::disk('public')->download($NameInDB, $NameInDB);
            };
        }catch(Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function modify(Request $request,$id){
        $file = $request->file('archivo'); //Archivo recibido por parámetro
        $DBInfo = Archivo::where('id',$id)->get(); //Info de archivo en BDD
        
        $NameInDB = $DBInfo[0]->Archivo; //Nombre de archivo en BDD
        $originalFilename = $file->getClientOriginalName(); //Nombre original del archivo subido por cliente
        $nameParts = explode('_',$NameInDB); //Troceamos el nombre que tenía en la base de datos
        $filename = $nameParts[0] . "_" . $nameParts[1] . "_" . date('YmdHis', time()) . ".pdf"; //Creamos un nuevo nombre en base a lo anterior
        
        Storage::delete($NameInDB);
        
        Storage::disk('public')->put($filename,file_get_contents($file),'public'); //Subimos el archivo físico a la carpeta correspondiente
        //Metemos los datos en la base de datos y guardamos
        $DBInfo[0]->Archivo = $filename;
        $DBInfo[0]->NombreOriginal = $originalFilename;
        $DBInfo[0]->save();

        return back();
    }

    public function createSale(Request $request){
        $venta = new Venta;
        $venta->Descripcion = $request->Input('descripcion');
        $venta->Estado = $request->Input('estado');
        $venta->Id_Cliente = $request->Input('id_cliente');
        $venta->save();
        return back();
    }
}