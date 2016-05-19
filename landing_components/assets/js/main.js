$(document).on("ready", inicio);
function inicio(){
    //Validación del formulario
    (function(a){var b=a.onload,p=false;if(p){a.onload="function"!=typeof b?function(){try{_agile_load_form_fields()}catch(a){}}:function(){b();try{_agile_load_form_fields()}catch(a){}}};a.document.forms["agile-form"].onsubmit=function(a){a.preventDefault();try{_agile_synch_form_v4()}catch(b){this.submit()}}})(window);
}
//Gracias
entrar = $('.entrar');
        entrar.click(function () {
        window.location = "http://umvirtual.org/portfolio/activacion-fisica-para-el-bienestar-personal/";
});