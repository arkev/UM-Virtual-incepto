$(document).on("ready", inicio);

//WOW
new WOW().init();

function inicio() {
	//Cool kitten
	$('.container').stellar();
    
	rh = $('.rh');
	rh.click(function () {
		window.location = "/maestrias/recursos-humanos/";
	});
    
    finanzas = $('.finanzas');
	finanzas.click(function () {
		window.location = "/maestrias/finanzas/";
	});
    
    software = $('.software');
	software.click(function () {
		window.location = "/maestrias/software/";
	});
    
    educacion = $('.educacion');
	educacion.click(function () {
		window.location = "/maestrias/educacion/";
	});
    
    familia = $('.familia');
	familia.click(function () {
		window.location = "/maestrias/relaciones-familiares/";
	});
    
    testimonio = $('.testimonio');
	testimonio.click(function () {
		window.location = "https://www.youtube.com/watch?v=bTNetKYNIa8";
	});
}