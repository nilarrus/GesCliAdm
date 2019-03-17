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

/**
 * 
 * @param {*} parent "String con el elemento padre al que añadiremos el filtro"
 * @param {*} url "Ruta a la que irá el formulario"
 * @param {*} vista "Indica la view de la que viene el filtro"
 * @param {*} tipo "Indica el tipo de elemento al que se quiere añadir. Si es una tabla creará filas y columnas, y si es un div, añadirá un div."
 */
/*function createFilter(parent,url,vista,tipo){
    if(tipo === "table"){
        var tr = $('<tr>')
        .prependTo(parent);

        $('<th>')
            .attr({"colspan":"5",class:'filterInputs'})
            .appendTo(tr);
    }else if(tipo === "div"){
        $('<div>')
            .attr({class:'filterInputs'})
            .appendTo(parent);
    }

    var form = $('<form>')
        .attr({'method':'POST',"action":url})
        .appendTo(".filterInputs");
    var csrfVar = $('meta[name="csrf-token"]').attr('content');
            form.append("<input name='_token' value='" + csrfVar + "' type='hidden'>");
    $('<input>')
            .attr({'type':'text','name':'filtro','tipo':vista})
            .appendTo(form)
    $('<input>')
        .attr({'type':'submit','value':'Filtrar',class:"btn"})
        .appendTo(form);
    var reset = $('<input>')
        .attr({'type':'button','value':'Resetear',class:"btn"})
        .appendTo(form);

    $(reset).click(function(){window.location.assign(url)});

    $('<input>')
        .attr({'type':'hidden',"name":"tipo", "value":vista})
        .appendTo(form);
}*/

function downloadFile(idArchivo){
    var form = CreateElement("body","form",undefined,{"method":"POST","action":"/download/"+idArchivo});
    var csrfVar = $('meta[name="csrf-token"]').attr('content');
            form.append("<input name='_token' value='" + csrfVar + "' type='hidden'>");
    form.submit();
}