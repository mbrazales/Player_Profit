$(document).ready(function() {
    $(".galeria a").on("click", function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado de los enlaces

        var nuevaImagen = $(this).find('img').attr("src");
        $("#portada img").attr("src", nuevaImagen);

        // Hacer scroll hacia el encabezado después de cambiar la imagen
        $('html, body').animate({
            scrollTop: $('h1').offset().top
        }, 'slow');
    });
});

    



