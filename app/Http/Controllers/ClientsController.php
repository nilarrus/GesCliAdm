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
    public function ApiClientes(Request $request){
        
        if($request->has('filtro')){
            $filtro=$request->input('filtro');
            $clientes=DB::table('clientes')
                            ->select('id', 'Nombre','Direccion', 'Localidad', 'cif/nif')
                            ->where('nombre','LIKE',"%".$request->input('filtro')."%")
                            ->orwhere('localidad','LIKE',"%".$request->input('filtro')."%")
                            ->orwhere('cif/nif','LIKE',"%".$request->input('filtro')."%")
                            ->paginate(5)
                            ->appends('filtro',$filtro);
            return $clientes;
            
        }else{
        $filtro=null;
        $clientes = DB::table('clientes')
                ->select('id', 'Nombre','Direccion', 'Localidad', 'cif/nif')
                ->paginate(5);            
                return $clientes;


        }
    }
    /**
     * return de la view 
     * */
    public function getIndex(){

        return view('clients.clientes');
    }
    public function index(Request $request){
        if($request->has('filtro')){
            $filtro=$request->input('filtro');
            $clientes=DB::table('clientes')
                            ->select('id', 'Nombre','Direccion', 'Localidad', 'cif/nif')
                            ->where('nombre','LIKE',"%".$request->input('filtro')."%")
                            ->orwhere('localidad','LIKE',"%".$request->input('filtro')."%")
                            ->orwhere('cif/nif','LIKE',"%".$request->input('filtro')."%")
                            ->paginate(5)
                            ->appends('filtro',$filtro);
            return view('clients.clientes', compact('clientes','filtro'));
            
        }else{
        $filtro=null;
        $clientes = DB::table('clientes')
                ->select('id', 'Nombre','Direccion', 'Localidad', 'cif/nif')
                ->paginate(5);            
                return view('clients.clientes', compact('clientes','filtro'));


        }if($request->ajax()){
            return Response::json($clientes);
        }
        return view('clients.clientes', compact('clientes','filtro'));
    }

    public function create(Request $request){
        //echo $request->input('cif/nif');
        //Cliente::create($request->all());
        Cliente::create(
            [
                'nombre' => $request->input('nombre'),
                'direccion' => $request->input('direccion'),
                'provincia' => $request->input('provincia'),
                'localidad' => $request->input('localidad'),
                'CIF/NIF' => $request->input('cif/nif'),
                'email' => $request->input('email'),
                'telefono' => $request->input('telefono'),
                'cp' => $request->input('cp'),
            ]
        );
        //return redirect('/');
    }

    public function edit(Request $request, $id){
        try{
            Cliente::findOrFail($id)
                ->update([
                    'nombre' => $request->input('nombre'),
                    'direccion' => $request->input('direccion'),
                    'provincia' => $request->input('provincia'),
                    'localidad' => $request->input('localidad'),
                    'cif/nif' => $request->input('cif/nif'),
                    'email' => $request->input('email'),
                    'telefono' => $request->input('telefono'),
                    'cp' => $request->input('cp'),
                ]);

            return redirect()->back();
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function showClient(Request $request, $id){
        try{
            if($request->has('filtro')){
                $filtro=$request->input('filtro');
                $ventas=DB::table('ventas')
                            ->select('id', 'Descripcion','Estado','Id_Cliente','Updated_at')
                            ->where('id_cliente',$id)
                            ->where('estado','LIKE',"%".$request->input('filtro')."%")
                            ->orwhere('id_cliente',$id)
                            ->where('updated_at','LIKE',"%".$request->input('filtro')."%")
                            ->paginate(2)
                            ->appends('filtro',$filtro);

            }else{
                $filtro=null;       
                $ventas = DB::table('ventas')
                    ->select('id', 'Descripcion', 'Estado', 'Id_Cliente', 'Updated_at')
                    ->where('Id_Cliente',$id)
                    ->paginate(2);
            }

            $cliente = Cliente::where('id',$id)->get(['id','nombre','direccion','provincia','localidad','cif/nif','email','telefono','cp']);
            return view('clients.detalle_cli', compact('cliente','ventas','filtro'));
            
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
        try{

        
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
        }catch(Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
       
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
        try{
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
        }catch(Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function createSale(Request $request){
        try{
            $venta = new Venta;
            $venta->Descripcion = $request->Input('descripcion');
            $venta->Estado = $request->Input('estado');
            $venta->Id_Cliente = $request->Input('id_cliente');
            $venta->save();
            return back();
        }catch(Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }
}