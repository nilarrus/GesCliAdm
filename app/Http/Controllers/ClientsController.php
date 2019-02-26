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
                'CIF/NIF' => $request->input('CIF/NIF'),
                'email' => $request->input('email'),
                'telefono' => $request->input('telefono'),
                'cp' => $request->input('cp'),
            ]);
    }

    public function show($id){
        $cliente = Cliente::where('id',$id)->get();
        $ventas = Venta::where('Id_Cliente',$id)->get();


        return view('clients.cliente', compact('cliente','ventas'));
    }
}