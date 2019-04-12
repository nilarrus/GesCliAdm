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
    //$("#ClientsTable").empty();
    $("#link").empty();
    var ul = $("<ul>").attr({'class':'pagination','role':'navigation'}).appendTo("#link");
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
console.log(page);
    $.ajax({
        url:AjUrl,
        data: {page:page}
        
    })
    .done(function(res){
        
        //CreateTable($("#ClientsTable"),res.data);
        CreateLinks();
        CreateLinkPag(res);
        //console.log(res);
    })
    .fail(function(jqXHR,textStatus){
        console.log("fail: "+textStatus);
    });

}