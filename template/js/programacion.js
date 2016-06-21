$(document).on("ready", inicio);

function inicio() {

    //Habilita animaciones cuando se haga scroll
    new WOW().init();

    $("#cta, #close, #cta2").click(function () {
        $("#formulario").toggle("slow", function () {
            // Caundo ya se cargó la animación

        });
    });

    //Animar el ir a un punto con el scroll
    function goToByScroll() {
        // Scroll
        $('html,body').animate({
                scrollTop: $("#formulario").offset().top
            },
            'slow');
    }

    //Al hacer click en estos botones corre la animaión del scroll
    $("#cta, #cta2").click(function (e) {
        // Prevenir una recarga de la página cuando se pulsa el enlace
        e.preventDefault();
        // llama a la animación
        goToByScroll();
    });

    // Formulario de contacto
    document.getElementsByName("nombre")[0].placeholder = "Nombre";
    document.getElementsByName("email")[0].placeholder = "Email";
    (function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='NOMBRE';ftypes[1]='text';fnames[2]='FUENTE';ftypes[2]='text';fnames[3]='TELEFONO';ftypes[3]='phone'; /*
     * Translated default messages for the $ validation plugin.
     * Locale: ES
     */
    $.extend($.validator.messages, {
      required: "Este campo es obligatorio.",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "Por favor, escribe un número entero válido.",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      accept: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
      minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
      rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
      range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
      min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });}(jQuery));var $mcj = jQuery.noConflict(true);


    $("#formulario").hide(); {

    }

}