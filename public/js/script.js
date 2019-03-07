var global_countTime;

$(document).ready(function(){
    $('.Error').hide();
    $('#GenerarError').click(function(){   
        createError("Esto es un mensaje de error");
    });
});

//Función que crea el error y le pasa un mensaje por parámetro
function createError(Message){
    $('.Error').html("");
    $('.Error').toggle().append($('<img>',{id:'theImg',src:'/img/exclamacion.png',width:'40px'})).append(Message);
    setTimer();
}

//Función que crea un timer que, tras 3 segundos, oculta de nuevo la ventana de error.
function setTimer(){
	clearTimeout(global_countTime);
	global_countTime =	setTimeout(function (){
		$(".Error").toggle();
	}, 3000);
}