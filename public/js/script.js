var global_countTime;

//Función que crea el error y le pasa un mensaje por parámetro
function createError(Message){
    $('<div>')
    .attr({class:'Error'})
    .text(Message)
    .prepend($('<img>',{src:'/img/exclamacion.png',width:'40px'}))
    .appendTo('.ErrorContainer');

    $('.ErrorContainer').show();
    setTimer();
}

//Función que crea un timer que, tras 5 segundos, oculta de nuevo la ventana de error.
function setTimer(){
	clearTimeout(global_countTime);
	global_countTime =	setTimeout(function (){
        var errorContainer = $('.ErrorContainer');
        errorContainer.hide();
        errorContainer.empty();
	}, 5000);
}