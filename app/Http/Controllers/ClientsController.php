<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Venta;
use App\Archivo;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ClientsController extends Controller
{
    public function index(){
        $clientes = Cliente::all(['id','nombre','provincia','cif/nif','cp']);
        return view('clients.clientes', compact('clientes'));
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
            $ventas = Venta::where('Id_Cliente',$id)->get();
            return view('clients.detalle_cli', compact('cliente','ventas'));
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function showSale($id){
        try{
            $venta = Venta::where('id',$id)->first();
            $archivos = Archivo::where('Id_Venta',$id)->get(["id","Tipo","Archivo","Id_Venta","updated_at"]);
            return view('clients.detalle_ven',compact('venta','archivos'));
        }catch(Exception $ex){
			return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }

    public function upload(Request $request,$id){
        
        try{
            /*if($file->getClientOriginalExtension() == "pdf"){
                return back()->withErrors(['Error'=>'Error del servidor']);
            }*/
            $file = $request->file('archivo');
            
            
            $type = $request->Input("tipo");

            $filename = $id . "_" . $type . "_" . date('YmdHis', time()) . "." . $file->getClientOriginalExtension();

            Storage::disk('public')->put($filename,file_get_contents($file),'public');

            $newFile = new Archivo;
            $newFile->Tipo = $type;
            $newFile->Archivo = $filename;
            $newFile->Id_Venta = $id;
            $newFile->save();

            return redirect()->back();
        }catch(\Exception $ex){
            return back()->withErrors(['Error'=>'Error del servidor']);
        }
    }
}