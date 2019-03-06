@extends('home')


@section('ownCSS')

    <style>
        #cliente,#ventas{
            margin: 15px;
        }
        .datosCliente{
            padding: 60px 60px 10px 60px;
            background-color: rgb(241, 241, 187) ;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            position: relative;
        }
        .datosCliente form{
            width: 300px;
            clear: both;
            text-align: left !important;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }
        form input{
            width: 70%;
            clear: both;
            float: right;
            opacity: 0.9;
            padding: 4px;
            border-radius: 2px;
            box-shadow: 0 0 5px rgba(0,0,0,0.6);
            border: 0;
            outline: none;
            transition: border-bottom 0.2s linear;
        }

        form input:focus{
            border-bottom: 2px solid black;
        }

        form input::placeholder{
            opacity: 0.3;
            text-transform: capitalize;
            padding-left: 5px;
        }

        form input:read-only{
            background-color: rgb(200, 200, 200);
        }  

        form input:read-only:focus{
            border-bottom: 0;
        }

        label{
            text-transform: capitalize;
            text-align: left !important;
            margin: 5px 10px 5px 0;
            width: 100%;
            display: inline-block;
            line-height: 20px;
        }
        table{
            border-radius: 5px;
        }
        table td,th,tr{
            padding: 10px !important;
            min-width: 20px !important;
        }   
        .contenido{
            width: 100%;
            display: flex;
            flex-direction: row; 
            justify-content: center;
        }

        .saveClient{
            margin:20px;
        }

        .divtop{
            padding: 10px;
            background-color: rgba(0,0,0,0.8);
            color: white;
            top: 0;
            position: absolute;
            width: 100%;
            left: 0;
            font-size: 15px;
            font-weight: 700;
            text-align: left !important;
        }

        .NoResults{
            width: 100%;
            padding: 100px;
            position: relative;
            background-color: rgb(241, 241, 187) ;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
        }
    </style>

@stop

@section('content')
    <div class="contenido">
        <div id="cliente">
            <div class="datosCliente"></div>
        </div>

        <div id="ventas">
            <div class="datosventas"></div>
            <table id="tablaventas"></table>
        </div>
    </div>
    <script>
        var cliente = {!! json_encode($cliente, JSON_HEX_TAG) !!}; 
        var ventas = {!! json_encode($ventas, JSON_HEX_TAG) !!};
        console.log(cliente)
        $(document).ready(function(){
            var data = filterData(ventas);
            if(data[0].length === 0){
                var div = $('<div class="NoResults"><h3>No hay ventas disponibles</h3></div>')
                    .appendTo('.datosventas');
                createSelectedElement(div,'div','Ventas',{class:'divtop'})
            }else{
                createItem('#tablaventas',["thead",'tr'],undefined,undefined,"th",data[0]);
                createItem('#tablaventas',['tbody'],["tr"],["class=clickable","data-href=/ventas/"],"td",data[1]);

                $(".clickable").click(function() {
                    window.location = $(this).data("href");
                });
            }
        
            createDashboard('.datosCliente',cliente);
            $('input[name="cif/nif"]').prop('readonly', true);
            
        });
    </script>
@stop