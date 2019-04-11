var AjUrl = "/api/clientes";
function CreateClicPag() {
    $("li").attr('onclic')
}
function CreateLinks(){
    $('.clickable').each(function(){
        $(this).attr("data-href","/clients/"+$(this).attr("id"));
   })

   $('.clickable').click(function(){
        window.location=$(this).data('href');
   });
}
function CreateLinkPag(info) {
    var pagLinks = "<ul class='pagination' role =navigation'>";
    //pagia 1 
    if(info.current_page==1){
        pagLinks = pagLinks +"<li class ='page-item disabled' aria-diabled='true' aria-label='« Previous'>"
                   +"<span page-link='true' aria-hidden='true'>‹</span>";
    //pagina diferentea a 1
    }else{
        pagLinks = pagLinks +"<li class ='page-item'>"
        +"<a href ='"+ info.path +"'?page=1 rel='prev' class= 'page-link'>"
        +"<span>‹</span></a></li>";

    }
    //Elementos/numeros



    //pagina final
    if(info.current_page == info.last_page){
        pagLinks = pagLinks +"<li class ='page-item disabled' aria-diabled='true' aria-label='Last &rArr;'>"
                +"<span page-link='true' aria-hidden='true'>›</span>";
    }else{

    }
}
function ajaxClientes(){

    $.ajax({
        url:AjUrl
        
    })
    .done(function(res){
        
        CreateTable($("#ClientsTable"),res.data);
        CreateLinks();
        CreateLinkPag(res);
        CreateClicPag();
        console.log(res);
    })
    .fail(function(jqXHR,textStatus){
        console.log("fail: "+textStatus);
    });

}