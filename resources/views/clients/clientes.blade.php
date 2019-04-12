@extends('home')

@section('breadcrumbs')
    <a href="/">{{ Breadcrumbs::render('clientes') }}</a>
@stop

@section('content')
    <div class="content">
        
        <div class="topContainer">
            <div class="top-title">
                Listado de Clientes:
            </div> 
            <div class="addUserIcon">
                <a href="#costumModal10" data-toggle="modal">
                    <button class="btn btn-primary" type="submit">Añadir Cliente</button>
                </a>
            </div>
            
        </div>
    </div>
    
    <div id="ClientsTable"></div>
    <div id="links">
        {{$clientes->links()}}
    </div>
    <script>
        
        var clientes = {!! json_encode($clientes,JSON_HEX_TAG) !!};

        //console.log(clientes)

        CreateTable("#ClientsTable",clientes.data,undefined);

        createFilter('#ClientsTable table thead',"/","clientes","table");
        
       $('.clickable').each(function(){
            $(this).attr("data-href","/clients/"+$(this).attr("id"));
       })

       $('.clickable').click(function(){
            window.location=$(this).data('href');
       });

        $('input[name="filtro"]').val('');
        ajaxClientes();
        $(document).ready(function(){
            $(".pagination a").on('click',function(e){
                e.preventDefault();
                ajaxClientes($(this).attr('href'));//falta pasar el numero de pagina i token 
            });
        });
        
   </script>
@stop

@section('modal')
    <div id="costumModal10" class="modal" data-easein="bounceIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title">
                            Añadir un nuevo cliente
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-form">
                        <form id="form" action="/clients/create" method="POST">
                            @csrf
                            <label for="nombre">Nombre: <input type="text" name="nombre" class="input"></label>
                            <label for="direccion">Dirección: <input type="text" name="direccion" class="input"></label>
                            <label for="provincia">Provincia: <input type="text" name="provincia" class="input"></label>
                            <label for="localidad">Localidad: <input type="text" name="localidad" class="input"></label>
                            <label for="cif/nif">CIF/NIF: <input type="text" name="cif/nif" class="input"></label>
                            <label for="email">E-Mail: <input type="text" name="email" class="input"></label>
                            <label for="telefono">Teléfono: <input type="text" name="telefono" class="input"></label>
                            <label for="cp">Código Postal: <input type="text" name="cp" class="input"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                            Close
                        </button>
                        <button class="btn btn-primary" type="submit">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   

@stop


