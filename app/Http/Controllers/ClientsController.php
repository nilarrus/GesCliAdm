<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClientsController extends Controller
{
    public function index(){
        $clientes = Cliente::all(['id','nombre','provincia','cif/nif']);

        return view('clients.client', compact('clientes'));
    }

    public function create(Request $request){
        Cliente::create($request->all());
    }
}
