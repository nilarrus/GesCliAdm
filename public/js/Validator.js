
$('#form').submit(function(e){
    e.preventDefault();
    console.log("presubmit")
    if(validate()){
        $('#form')[0].submit();
        console.log("submit")
    }
});

//Función que valida si un formulario es correcto o no
function validate(){
    var email = $("input[name='email']");
    if(!validateEmail(email.val())){
        createError("El correo tiene un formato incorrecto.")
        return false;
    }else if(!validateNumber($("input[name='telefono']").val())){
        createError("El teléfono tiene que tener 9 dígitos.")
        return false;
    }

    return true;
}

//Función para validar un email, recibira una string con el email y devolverá un true o un false
function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

//Función para validar un teléfono, recibira una string con el número y devolverá un true o un false
function validateNumber(number){
    var re = /\d{9}/;
    return re.test(number);
}
