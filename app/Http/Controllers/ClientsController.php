<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Venta;

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
    }

    public function show($id){
        $cliente = Cliente::where('id',$id)->get(['id','nombre','direccion','provincia','localidad','cif/nif','email','telefono','cp']);
        $ventas = Venta::where('Id_Cliente',$id)->get();


        return view('clients.cliente', compact('cliente','ventas'));
    }
}