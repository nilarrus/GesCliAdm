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

	
		var archivos = {!! json_encode($archivos->toArray(), JSON_HEX_TAG) !!};
		CreateTable('.sale',archivos)
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

		$(document).ready(function(){
			archivos.forEach(function(elements){
				console.log(elements.Archivo)
				var url = '{{ asset("storage/:url") }}';
				url = url.replace(':url', elements.Archivo);
				$('<button>')
					.attr({'class':'imgbutton'})
					.text('Descargar')
					.click(function(e){
						window.open(url,'_blank');
					})
					.appendTo('.sale');
			})
		})
	</script>
@stop