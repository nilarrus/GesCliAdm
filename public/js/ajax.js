var AjUrl = "/api/clientes";
function CreateLinks(){
    $('.clickable').each(function(){
        $(this).attr("data-href","/clients/"+$(this).attr("id"));
   })

   $('.clickable').click(function(){
        window.location=$(this).data('href');
   });
}
function CLiSpan(par,txt,attr){
    //asignar valores pasados por paramentro para crear los elementos
    var li = $('<li>').attr(attr.li).appendTo(par);
    $('<span>').attr(attr.span).text(txt).appendTo(li);
}
function CLiLink(par,txt,attr){
    //asignar valores pasados por paramentro para crear los elementos
    var li = $('<li>').attr(attr.li).appendTo(par);
    var a = $('<a>').attr(attr.a).text(txt).appendTo(li);
}

function CreateLinkPag(data) {
    $("#links").empty();
    var ul = $("<ul>").attr({'class':'pagination','role':'navigation'}).appendTo("#links");
    //pagia 1 
    if(data.current_page==1){
        //primera pagina elemento con span
        CLiSpan(ul,'‹‹',{'li':{'class':'page-item disabled','aria-disabled':'true','aria-label':'« Previous'},
        'span':{'class':'page-link','aria-label':'« Previous'}},data)
    //pagina diferentea a 1 elementos con link
    }else{
        let previousPage = data.current_page - 1;
        CLiLink(ul,'‹‹',{'li':{'class':'page-item'},
        'a':{'href':previousPage,'class':'page-link'}},data)

    }
    //Elementos/numeros
    for (var i = 1; i <= data.last_page; i++) {
        if(data.current_page == i){
            CLiSpan(ul,i,{li:{'class':'page-item active'},
            span:{'class':'page-link'}},data)
        }else{    
            CLiLink(ul,i,{li:{'class':'page-item'},
            a:{'href':i ,'class':'page-link'}},data)
        }
    }
    //pagina final
    if(data.current_page == data.last_page){
        CLiSpan(ul,'››',{li:{'class':'page-item disabled'},span:{'class':'page-link'}},data)
    }else{
        let nextPage = data.current_page + 1;
        CLiLink(ul,'››',{li:{'class':'page-item'},
        a:{'href':nextPage,'class':'page-link'}},data)
    }
}
function ajaxClientes(page){
console.log("Pagina antes del done:"+page);
    $.ajax({
            url:AjUrl,
            data: {
                page:page
            },
            
            
        })
        .done(function(res){

            $('#ClientsTable').empty();
            CreateTable("#ClientsTable",res.data); //crear tabla nuevo contenido
            CreateLinks();// links de los elementos de la tabla
            CreateLinkPag(res);// links paginacion
            createFilter('#ClientsTable table thead',"/","clientes","table");
            console.log(res);
            $(document).ready(function(){
                $(".pagination a").on('click',function(e){
                    e.preventDefault();
                    ajaxClientes($(this).attr('href'));
                });
            });
        })
        .fail(function(jqXHR,textStatus){
            console.log("fail: "+textStatus);
        });
}



$(document).on("click", "#ClientsTable input[value='Filtrar']", function(event){
    event.preventDefault();

    var inputfiltro = $("input[name='filtro']").val();
    var urlvista = window.location.origin+"/api/clientes";

    
    $.ajax({
        url: urlvista,
        data: {filtro: inputfiltro},
        type: 'GET',
        success: function(data){
            console.log(data);
            $('#ClientsTable').empty();
            CreateTable("#ClientsTable",data.data); //crear tabla nuevo contenido
            CreateLinks();// links de los elementos de la tabla
            CreateLinkPag(data);// links paginacion
            createFilter('#ClientsTable table thead',"/","clientes","table");
        },
        error: function(e) {
                console.log("error");
                //console.log($('#form').first().serialize());
                console.log(e.status);
        }
        
    })
    
})