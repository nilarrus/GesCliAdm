var global_countTime;

function uniqueError(id){
    var control = true;
    $('.Error').each(function(){
        if($(this).attr('id') === id){
            control = false;
        }
    });

    return control;
}
//Función que crea el error y le pasa un mensaje por parámetro
function createError(Message,id){

    if(uniqueError(id)){
        $('<div>')
        .attr({class:'Error',id:id})
        .text(Message)
        .prepend($('<img>',{src:'/img/exclamacion.png',width:'40px'}))
        .appendTo('.ErrorContainer');
        $('.ErrorContainer').show();
        setTimer();
    }
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