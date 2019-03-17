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
    public function index(){
        //$clientes = Cliente::get('nombre','localidad','nif');

        $clientes = DB::table('clientes')
            ->select('id', 'Nombre', 'Localidad', 'CIF/NIF')
            ->paginate(10);
        
        return view('clients.clientes', compact('clientes'));
    }

    /*public function filterClients(Request $request){
        $clientes = DB::table('clientes')
            ->select('id', 'Nombre', 'Localidad', 'CIF/NIF')
            ->where('Nombre', 'LIKE', '%'.$request->Input('filtro').'%')
            ->orWhere('Localidad','LIKE','%'.$request->Input('filtro').'%')
            ->orWhere('cif/nif','LIKE','%'.$request->Input('filtro').'%')
            ->paginate(10);
    
        return view('clients.clientes', compact('clientes'));
    }*/

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
            $ventas = Venta::where('Id_Cliente',$id)->paginate(10);
            return view('clients.detalle_cli', compact('cliente','ventas'));
            
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    /*public function filterSales(Request $request,$id){
        try{
            $cliente = Cliente::where('id',$id)->get(['id','nombre','direccion','provincia','localidad','cif/nif','email','telefono','cp']);
            
            $ventas = Venta::where(function ($query) use ($request,$id){
                $query->where('Id_Cliente',$id);
            })->where(function ($query) use ($request){
                $query->where('Updated_at', 'LIKE', '%'.$request->Input('filtro').'%')
                    ->orWhere('Created_at','LIKE','%'.$request->Input('filtro').'%')
                    ->orWhere('estado','LIKE','%'.$request->Input('filtro').'%');
            })->paginate(10);
            
            return view('clients.detalle_cli', compact('cliente','ventas'));
        }catch(\Exception $ex){
            
        }
    }*/

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

            $filename = $id . "_" . $type . "_" . date('YmdHis', time()) . "." . $file->getClientOriginalExtension();

            Storage::disk('public')->put($filename,file_get_contents($file),'public');

            $newFile = new Archivo;
            $newFile->Tipo = $type;
            $newFile->Archivo = $filename;
            $newFile->NombreOriginal = $originalFilename;
            $newFile->Id_Venta = $id;
            $newFile->save();
            
            return redirect()->back();
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function download(Request $request,$id){
        $file = Archivo::where('id',$id)->get();
        $originalName = $file[0]->NombreOriginal;
        $NameInDB = $file[0]->Archivo;
        if($originalName != ""){
            //return Storage::disk('public')->download($NameInDB, $originalName);
            return Storage::disk('public')->download($NameInDB, $originalName);
        }else{
            return Storage::disk('public')->download($NameInDB, $NameInDB);
        };
    }
}