$(document).on("ready", inicio);

//WOW
new WOW().init();

function inicio() {
	//Cool kitten
	$('.container').stellar();
	button = $('.curso');
	
	button.click(function () {
		window.location = "http://umvirtual.org/mi-cuenta/e42-lite/";
	});
}