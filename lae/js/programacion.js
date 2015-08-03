$(document).on("ready", inicio);

function inicio() {

    //Habilita animaciones cuando se haga scroll
    new WOW().init();

    $("#cta, #close, #cta2").click(function () {
        $("#form").toggle("slow", function () {
            // Caundo ya se cargó la animación

        });
    });

    //Animar el ir a un punto con el scroll
    function goToByScroll() {
        // Scroll
        $('html,body').animate({
            scrollTop: $("#form").offset().top
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
        $("#form_contacto").html5form({
            allBrowsers: true,
            method: "POST",
            messages: "es",
            responseDiv: "#res_contacto",
        });
        document.getElementsByName("nombre")[0].placeholder = "Nombre";
        document.getElementsByName("email")[0].placeholder = "Email";
    
    
        $("#form").hide(); {

        }
    
}