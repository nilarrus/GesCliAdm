/**
 * 
 * @param {*} parent Elemento padre donde se introducirá el form (usualmente debería ser una lista o un div)
 * @param {*} data Array que incluirá un objeto en formato JSON en su interior
 * @param {*} params Objeto con elementos clave valor, por ejemplo: {class:'container',name:'elemento1'}
 */
function CreateTable(parent,data,params){
    var TableReturn = filterData(data);
    var Keys = TableReturn[0];
    var Values = TableReturn[1];
    var Table = CreateElement(parent,"table",undefined,undefined);
    var Thead = CreateElement(Table,"thead",undefined,undefined);
    var Tbody = CreateElement(Table,"tbody",undefined,undefined);
    var TRhead;
    var control=false;
    
    Keys.forEach(function(element){
        if(control===false){
            TRhead=CreateElement(Thead,"tr",undefined,undefined);
            control=true;
        }else{
            CreateElement(TRhead,"th",element,undefined); 
        }
    });

    Values.forEach(function(items){
        var TRbody;
        var control=false;
        items.forEach(function(item){
            if(control===false){
                TRbody=CreateElement(Tbody,"tr",undefined,{"class":"clickable","data-href":'/clients/'+item});
                control=true;
            }else{
            CreateElement(TRbody,"td",item,undefined); 
            }
        });
    });
}

function CreateElement(parent,element,text,params){
    if(params===undefined || params === null){
        params={};
    }
    var element=$('<'+element+'>')
            .attr(params)
            .text(text)
            .appendTo(parent);
    return element;
}

function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}

//Función para convertir un json en dos arrays, uno que contiene las keys y otro que contiene los valores
function filterData(result){
    //var result = result.data;
    var keys = [];
    var values = [];
        result.forEach(function(items){
            var list = [];
            for(item in items){
                keys.push(item);
                list.push(items[item]);
            };
            values.push(list);
            
        });

    keys = keys.filter(onlyUnique); 
    return [keys,values];
}

/**
 * 
 * @param {*} parent Elemento padre donde se introducirá el form (usualmente debería ser una lista o un div)
 * @param {*} data Array que incluirá un objeto en formato JSON en su interior
 * @param {*} params Objeto con elementos clave valor, por ejemplo: {class:'container',name:'elemento1'}
 */
function CreateForm(parent,data,params){
    var form=CreateElement(parent,"form",undefined,undefined);
    var csrfVar = $('meta[name="csrf-token"]').attr('content');
    form.append("<input name='_token' value='" + csrfVar + "' type='hidden'>");
    form.append('<input type="hidden" name="_method" value="PUT">');
    data.forEach(function(elements){
        for(item in elements){
            if(item==="id"){
                form.attr({"method":"post","action":"/clients/"+elements[item]})
            }else{
                var label=CreateElement(form,"label",item,undefined);
                CreateElement(form,"input",undefined,{'value':elements[item],name:item,'required':true});
            }
        }
        CreateElement(form,"button","Modificar Cliente",{class:"btn btn-primary saveClient"});
    })
}