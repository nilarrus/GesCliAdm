var AjUrl = "/api/clientes";
function CreateLinks(){
    $('.clickable').each(function(){
        $(this).attr("data-href","/clients/"+$(this).attr("id"));
   })

   $('.clickable').click(function(){
        window.location=$(this).data('href');
   });
}
function ajaxClientes(){

    $.ajax({
        url:AjUrl
        
    })
    .done(function(res){
        
        CreateTable($("#ClientsTable"),res);
        CreateLinks();
        console.log(res);
    })
    .fail(function(jqXHR,textStatus){
        console.log("fail: "+textStatus);
    });

}