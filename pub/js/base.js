var url_site = window.location.protocol + '//' + window.location.hostname + '//' + window.location.pathname;

var Base = {

    ERROR_GENERAL : 'Error en Sistema. Intente nuevamente o comuníquese con Mesa de Ayuda',

    btnText : '',
    /**
     * Cambia apariencia de btn miestras se realiza una acción o procesamiento
     * @param  {[type]} btn     [description]
     * @param  {[type]} message [description]
     * @return {[type]}         [description]
     */
    buttonProccessStart : function(btn, message){
        var $this = this;
        $this.btnText = $(btn).attr('disabled',true).html();
        $(btn).html(message + '...<i class="fa fa-spin fa-spinner"></i>');
    },

    buttonProccessEnd : function(btn){
        var $this = this;
        $(btn).html($this.btnText).attr('disabled',false);
    },


    loadScript : function(source, callback) {

        if(source.css !== undefined){

            if(typeof source.css === 'string'){
                document.write('<link href="'+ source.css + '?' + Math.random() + '" type="text/css" rel="stylesheet" />');
            }else if(typeof source.css === 'object'){
                var scripts = source.css;
                var totalScripts = scripts.length;
                for(var i = 0; i < totalScripts; i++){
                    document.write('<link href="'+ scripts[i] + '?' + Math.random() + '" type="text/css" rel="stylesheet" />');
                }
            }else{
                console.log('Error con fichero ' . source.css);
            }
        }

        if(source.js !== undefined){

            if(typeof source.js === 'string'){
                document.write('<script src="'+source.js + '?' + Math.random() + '" type="text/javascript"></script>');
            }else if(typeof source.js === 'object'){
                var scripts = source.js;
                var totalScripts = scripts.length;
                for(var i = 0; i < totalScripts; i++){
                    document.write('<script src="'+ scripts[i] + '?' + Math.random() + '" type="text/javascript"></script>');
                }
            }else{
                console.log('Error con fichero ' . source.js);
            }

        }

    },

    /**
     * Obtener directorio base de ejecucoin web
     * @returns {string}
     */
    getBaseDir : function(){
        var host = window.location.host;
        var protocol = window.location.protocol;
        var url = window.location.pathname;
        url = url.split("index.php");
        if(url[0] !== undefined){
            var base_uri = protocol + "//" + host + url[0];
        }else{
            var base_uri = protocol + "//" + host ;
        }
        return base_uri;
    },

    /**
     * Obtener url base de ejecucion
     * @returns {string}
     */
    getBaseUri : function(){
        var host = window.location.host;
        var protocol = window.location.protocol;
        var url = window.location.pathname;
        url = url.split("index.php");
        if(url[0] !== undefined){
            var base_uri = protocol + "//" + host + url[0];
        }else{
            var base_uri = protocol + "//" + host ;
        }
        return base_uri + 'index.php/';
    },

    /**
     * Validar formato de email
     * @param email
     * @returns {boolean}
     */
    validarEmail : function(email){
        if(email === "")
            return false;

        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) ? true : false;
    },


    loadingStart : function(contenedor){
        $("#" + contenedor).append('<div class="col-xs-12 text-center" id="loading"><i class="fa fa-spin fa-spinner fa-5x"></i></div>');
    },

    loadingStop : function(func){
        if(typeof func === 'function'){
            $("#loading").fadeOut(func());
        }else{
            $("#loading").fadeOut();
        }
    }
};