@extends('home')

{{--
@section('content')
<!--
	<div class="container flex-center">
		<div class="content">
			
			<div id="app"></div>
		</div>
	</div>
    <div class="topContainer">
        <div class="top-title">Clientes</div>
        <div class="addUserIcon"><i class="fas fa-plus"></i></div>
    </div>


    <div id="formdiv">
        <form action="/create" method="POST">
            @csrf
            <label for="nombre">Nombre: <input type="text" name="Nombre" id="Nombre"></label>
            <label for="provincia">Provincia: <input type="text" name="Provincia" id="Provincia"></label>
            <label for="CIF/NIF">CIF/NIF: <input type="text" name="CIF/NIF" id="CIF/NIF"></label>
            <br><br>
            <button type="submit">Enviar</button>
        </form>
    </div>

    -->
    <script>var clientes = {!! json_encode($clientes->toArray(), JSON_HEX_TAG) !!} ; console.log(clientes);</script>

    

@stop--}}




