@extends('home')


@section('ownCSS')

    <style>
        #cliente{
            margin: 30px;
        }
        table{
            border-radius: 5px;
        }
        table td,th,tr{
            padding: 10px !important;
        }    
    </style>

@stop

@section('content')
    <div id="cliente">
        <div class="topContainer">
            <div class="top-title">Cliente</div>
        </div>
    </div>

    <div id="ventas">
        <div class="topContainer">
            <div class="top-title">Ventas</div>
        </div>
        
    </div>
    <script>
        var cliente = {!! json_encode($cliente, JSON_HEX_TAG) !!}; 
        var ventas = {!! json_encode($ventas, JSON_HEX_TAG) !!};

        console.log(cliente);
        console.log(ventas);
    
        $(document).ready(function(){
            
            filterData(cliente,'#cliente');
            filterData(ventas,'#ventas');
        });
    </script>
@stop