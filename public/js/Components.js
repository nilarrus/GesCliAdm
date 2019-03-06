 function CreateTable(parent,data,params){

            var TableReturn=filterData(data);
            var Keys=TableReturn[0];
            var Values=TableReturn[1];
            var Table=CreateElement(parent,"table",undefined,undefined);
            var Tbody= CreateElement(Table,"tbody",undefined,undefined);
            var Thead= CreateElement(Table,"thead",undefined,undefined);
            var TRhead;
            var control=false;
            Keys.forEach(function(element){
                   
                if(control===false){
                    TRhead=CreateElement(Thead,"tr",undefined,undefined);
                        
                    control=true;
                    }else{
                    CreateElement(TRhead,"th",element,undefined); 
                    }
            })    
        
            Values.forEach(function(items){
            var TRbody;
                var control=false;
                items.forEach(function(item){
                    if(control===false){
                        TRbody=CreateElement(Tbody,"tr",undefined,{"class":"clickable","data-href":'/clients/'+item});
                        
                        control=true;
                    }else{
                    CreateElement(TRbody,"td",item,undefined); 
                    console.log(TRbody);
                }
                

                })
            })
            
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
