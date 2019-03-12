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
                TRbody=CreateElement(Tbody,"tr",undefined,{"class":"clickable","id":item});
                control=true;
            }else{
            CreateElement(TRbody,"td",item,undefined); 
            }
        });
    });


}

function SimpleTable(parent,text,attr,data){
        var Split=SplitData(data,text);
        //var Tab=CreateElement(parent,"Table",undefined,attr);
        var Tr=CreateElement(parent,"tr");
        var Th = CreateElement(Tr,"th",text,{colspan:2});
        var Span = CreateElement(Th,"span","Añadir "+text, {class:"file-input btn btn-primary btn-file"});
        CreateElement(Span,"input",undefined,{"type":"file",class:"fileInput","name":"archivo","tipo":text})
       
        Split.forEach(function(elements){
            var NewTr=CreateElement(parent,"tr");
            CreateElement(NewTr,"td",elements.Archivo);
            CreateElement(NewTr,"td",elements.updated_at);
        });

}

function SplitData(data,type){
    var SplitArray=[];
    data.forEach(function(items){

        if(items.Tipo.toLowerCase()===type.toLowerCase()){
            SplitArray.push(items);
        }

    })
    return SplitArray;
}

/**
 * 
 * @param {*} parent Elemento al que añadiremos el componente que vamos a crear. Se debe pasar una string con un formato parecido a: '#id','.class',etc...
 * @param {*} element String que contiene el tipo de elemento que deseamos crear: 'div','p','button','form',etc...
 * @param {*} text String con un texto que se printará en el elemento creado.
 * @param {*} params Objeto en formato JSON que contendrá los diversos atributos que dseamos que tenga el componente (class:'clase',name:'nombre',etc...)
 */
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

//Función que recibe un array y devuelve uno nuevo con los elementos únicos. Si se repiten elimina los repetidos para dejar uno solo.
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}

//Función que recibe un JSON y lo convierte en dos arrays, uno que contiene las keys y otro que contiene los valores
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
    var form=CreateElement(parent,"form",undefined,{id:"form"});
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