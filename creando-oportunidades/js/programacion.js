$(document).on("ready", inicio);

function inicio() {
    //Habilita animaciones cuando se haga scroll
    new WOW().init();
    
    //Slider
    $(".Modern-Slider").slick({
    autoplay:true,
    autoplaySpeed:10000,
    speed:600,
    slidesToShow:1,
    slidesToScroll:1,
    pauseOnHover:false,
    dots:true,
    pauseOnDotsHover:true,
    cssEase:'linear',
   // fade:true,
    draggable:false,
    prevArrow:'<button class="PrevArrow"></button>',
    nextArrow:'<button class="NextArrow"></button>', 
  });  
    //Formulario
    $('#myform').html5form({
        messages : 'es',
        responseDiv : '#respuesta' // define un contenedor para mostrar el resultado de la petición Ajax.

    });
    $('#myform_dos').html5form({
        method: 'GET',
        messages : 'es',
        responseDiv : '#respuesta'
    });
}

$("#cta2").click(function(){
   //quitar la clase .active al boton que la tenga:
   $("#myform_dos").show("slow", function () {
            // Caundo ya se cargó la animación
       $("#cta2").hide("slow");
    });
});


// Click function for show the Modal

    $(".show").on("click", function(){
      $(".mask").addClass("active");
    });

    // Function for close the Modal

    function closeModal(){
      $(".mask").removeClass("active");
    }

    // Call the closeModal function on the clicks/keyboard

    $(".close, .mask").on("click", function(){
      closeModal();
    });

    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        closeModal();
      }
    });