@extends('home')

@section('content')

	<div class="sale">
		<form id="form2" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="file" name="archivo">
			<input type="hidden" name="tipo" value="factura">
			<button id="button-submit">Enviar</button>
			

		</form>


		<br>
	</div>
	
	<script>

		var Datos = {!! json_encode($venta->toArray(), JSON_HEX_TAG) !!};
		var Ventas=[];
		Ventas.push(Datos);
		var archivos = {!! json_encode($archivos->toArray(), JSON_HEX_TAG) !!};
		CreateTable(".sale",Ventas,undefined);		
		SimpleTable(".sale", "Factura", {id:"Table_Fac"},archivos);
		SimpleTable(".sale","Albarán",{id:"Table_Alb"},archivos);
		SimpleTable(".sale","Pressupost",{id:"Table_Pre"},archivos);
		SimpleTable(".sale","Comanda Pro.",{id:"Table_Pro"},archivos);
		SimpleTable(".sale","Comanda Cli.",{id:"Table_Cli"},archivos);


		$('#form2').submit(function(e){
			e.preventDefault();
			sendPost();
		});

		function sendPost(){
			$.ajax({
				url: '/uploadFile/{{ $venta->id }}',
				data: new FormData($('#form2')[0]),
				type: 'POST',
				processData: false,
      			contentType: false,
				success: function(response){
					if(response === "Correcto"){
						$('<h1>Todo correcto</h1>').appendTo(".sale");
					}
				},
				error: function(xhr,status,error){
					console.log(error);
				}
			});
		}

		function downloadFile(){
			$.ajax({
				headers: {
        				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    				},
				url: '/downloadFile',
				type: 'POST',
				processData: false,
      			contentType: false,
				success: function(response){
					console.log(response);
				},
				error: function(xhr,status,error){
					console.log(error)
				}
			})
		}


	</script>
@stop