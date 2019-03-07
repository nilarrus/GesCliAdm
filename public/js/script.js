var global_countTime;

$(document).ready(function(){
    $('.Error').hide();
    $('#GenerarError').click(function(){   
        createError("Esto es un mensaje de error");
    });
});

function createError(Message){
    $('.Error').html("");
    $('.Error').toggle().append($('<img>',{id:'theImg',src:'/img/exclamacion.png',width:'40px'})).append(Message);
    setTimer();
}

//Función que crea un timer que, tras 10 segundos, oculta de nuevo la ventana de error y elimina los errores creados.
//Se eliminan para que la próxima vez que se genere un error sin recargar la página no aparezcan.
function setTimer(){
	clearTimeout(global_countTime);
	global_countTime =	setTimeout(function (){
		$(".Error").toggle();
	}, 2000);
}