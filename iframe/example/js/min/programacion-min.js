$(document).ready(function(){$("#username").focus(),$("#submit").click(function(){event.preventDefault();var a="alumno"===$("#username").val(),c="e42lite2015"===$("#password").val();a===!0&&c===!0?($(".valid").css("display","block"),window.location="http://umvirtual.org"):$(".error").css("display","block")}),$("#close").click(function(){$(".alerta").fadeOut("slow")}),$("#calendario").click(function(){$("#fecha").css("display","none")}),$("div#modal").on("click",".cerrar",function(a){a.preventDefault(),$("div#modal").fadeOut("slow")})});