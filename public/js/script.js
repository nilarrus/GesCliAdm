function createStructure(keys,values,parent){
    var table = $('<table>').appendTo(parent);
    createItem(table,["thead",'tr'],undefined,undefined,"th",keys);
    createItem(table,['tbody'],["tr"],["class=clickable","data-href=clients/"],"td",values);
    //createItem("#app",['div','ul'],undefined,["class=title"],"li",keys);
    //createItem("#app",['div'],["ul"],["class=clickable","data-href=clientes/"],"li",values);

    //Función que convierte los elementos con la clase pasada por parámetro en clickable y el link será el data-href
    jQuery(document).ready(function($) {
        $(".clickable").click(function() {
            window.location = $(this).data("href");
        });
    });
}

/**
 * 
 * @param {*} parent Elemento existente en el HTML bajo el que se creará la estructura
 * @param {*} middleparent Posibles elementos intermedios entre el parent y los elementos más bajos del árbol. Ideal para un solo elemento de cada (thead,tbody,titulo...).
 * @param {*} middlechild Posibles elementos intermedios entre el parent o el middleparent y los elementos más bajos del árbol (por ejemplo td's).
 * Si se quiere tener muchos elementos de un tipo lo ideal es usarlo aquí.
 * @param {*} Params Array de elementos que contienen diferentes atributos. Se añadirán en formato clave valor separados por un igual (=).
 * @param {*} child El elemento más bajo de la estructura. Contendrá el texto.
 * @param {*} values Array de elementos que contendrán el texto que se pondrá en child.
 */
function createItem(parent,middleparent,middlechild,Params,child,values){
    if(middleparent != undefined){
        parent = createParent(parent,middleparent);
    }
    var e=0;
    values.forEach(function(element){
        if(middlechild != undefined){
            intermediate = createParent(parent,middlechild);
        }else{
            intermediate = parent;
        }

        if(typeof element === "object"){
            iterateObject(intermediate,child,element)
        }else{
            if(e == 0){
                //Evitamos que cree la columna de ID (siempre suele ser la primera)
                e++;
            }else{
                createElement(intermediate,child,element);
            }
        }

        if(Params != undefined && typeof Params == "object"){
            setParams(intermediate,getParams(Params,intermediate.data()));
        }
    })
}

function iterateObject(intermediate,child,value){
    var i=0;
    value.forEach(function(textValue){
        if(i == 0){
            intermediate.data("id",textValue);
            i++;
        }else{
            createElement(intermediate,child,textValue);
        }
    })
}

//Función para crear los elementos sobre los que se creará la estructura
function createParent(parent,middle){
    middle.forEach(function(element){
        parent = createElement(parent,element,undefined);
    })

    return parent;
}

//Función que crea elementos y los añade a un parent pasado por parámetro
function createElement(parent,child,value){
    child = $('<' + child + '>')
        .text(value)
        .appendTo(parent);

    return child;
}

function getParams(childParams,intData){
    var data = []
    childParams.forEach(function(element){
        params = {};
        if(element.includes("href")){
            element+=intData.id
        }
        var splitedParam = element.split("=");
    
        params[splitedParam[0]] = splitedParam[1];
        
        data.push(params);
    })
    return data;
}

//Función que añade atributos al elemento que se le pasa por parámetro
//La primera opción será la key (ej: class) y la segunda el value (ej: classname)
function setParams(element,params){
    params.forEach(function(param){
        element.attr(Object.keys(param)[0],param[Object.keys(param)]);
    });
}

//-------//

//Función que sirve para filtrar valores duplicados en un array, devolviendo un array con valores únicos
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}

//Función para convertir un json en dos arrays, uno que contiene las keys y otro que contiene los valores
function filterData(result,parent){
    var listado = result;
    /*
    if(result.data.childs){
        var listado = result.data.childs;
    }else{
        var listado = result.data;
    }*/
    var keys = [];
    var values = [];
        listado.forEach(function(items){
            var list = [];
            for(item in items){
                keys.push(item);
                list.push(items[item]);
            };
            values.push(list);
            
        });

    keys = keys.filter(onlyUnique);

    createStructure(keys,values,parent);
}