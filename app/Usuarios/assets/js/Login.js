
var Login = {

    /**
     * Validar ingreso de usuario
     * @param form formulario de login
     * @param btn boton Ingresar
     */
    loginUsuario : function(form, btn){
        Base.buttonProccessStart(btn,'Validando');

        var error = "";
        if(form.rut.value == ""){
            error += 'Ingrese su rut <br/>';
        }

        if(form.pass.value == ""){
            error += 'Ingrese su contraseña <br/>';
        }

        if(error !== ""){
            Modal.error(error, function(){
                Base.buttonProccessEnd(btn);
            });
        }else{

            $.ajax({
                url : Base.getBaseUri() + 'Usuarios/Login/loginUsuario',
                data : $(form).serializeArray(),
                type : 'post',
                dataType : 'json',
                success : function(response){
                    if(response.estado == true){
                        window.location.href = response.redirect;
                    }else{
                        Modal.error(response.mensaje, function(){
                            Base.buttonProccessEnd(btn);
                        });
                    }
                },
                error : function(){
                    Modal.error("Error interno. Intente nuevamente, o comuníquese con Soporte", function(){
                        Base.buttonProccessEnd(btn);
                    });
                }
            });

        }
    },


    solicitarPassword : function(){
        Modal.open(Base.getBaseUri() + 'Usuarios/Password/solicitar');
    }

}