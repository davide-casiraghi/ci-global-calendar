
jQuery(document).ready(function () {

    //alert("aa");

    if( jQuery(".gallery").length ){
        // Render gridalicious gallery
            jQuery(".gallery").gridalicious({
                            width: 250,
                            gutter: 10,
                            animate: true,
                            animationOptions: {
                                speed: 150,
                                duration: 500
                            }
            });
    }
});
