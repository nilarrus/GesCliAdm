@extends('home')

@section('content')
	<style>
	.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  background: red;
  cursor: inherit;
  display: block;
}
.file-input-label {
	padding: 0px 10px;
	display: table-cell;
	vertical-align: middle;
  border: 1px solid #ddd;
  border-radius: 4px;
}
input[readonly] {
  background-color: white !important;
  cursor: text !important;
}
</style>
	<div class="sale">
		<form id="form2" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="file" name="archivo" id="archivo" tipo="factura" >
			<input type="hidden" name="tipo" value="factura">
			<button id="button-submit">Enviar</button>
		</form>
		<br>
		<span class="file-input btn btn-primary btn-file">
                Browse... <input type="file" multiple>
            </span>
	</div>
	
	<script>

		$('#archivo').change(function(){
			var form = $('<form action="/uploadFile/{{ $venta->id }}" enctype="multipart/form-data" method="POST" id="query"></form>').appendTo(".sale");
			var csrfVar = $('meta[name="csrf-token"]').attr('content');
    		form.append("<input name='_token' value='" + csrfVar + "' type='hidden'>");
			var file = $(this).prop('files')[0];
			var tipo = $(this).attr("tipo");
			CreateElement(form,"input",undefined,{"type":"hidden","name":"tipo","value":tipo});
			var newFile = $(this).clone().appendTo(form);
			form.submit();
		});
		var venta = {!! json_encode($venta->toArray(), JSON_HEX_TAG) !!};
		var ventas = [];
		ventas.push(venta);
		console.log(ventas);
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