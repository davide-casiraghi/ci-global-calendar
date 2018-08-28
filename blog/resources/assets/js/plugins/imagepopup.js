
/************************************/
/* Wrap image with ALT attribute  */
/************************************/

function wrapImageWithAlt(thisObj){

    // Crea un DIV per inserire la descrizione sotto all'immagine sempre nel wrap

    // Incapsula l'immagine con ALT della sezione news in un contenitore
    thisObj.wrap('<div class="imageWrapper" />');

    thisObj.parent(".imageWrapper").append("<div class='imgDesc'></div>");
    var description = thisObj.parent(".imageWrapper").children("div.imgDesc");
    var descriptionText = description.parent(".imageWrapper").children("img").attr('alt');

    //remove # from alt and add <br> to description (#is <br> marker)
    	descriptionTextNoAlt = descriptionText.replace("#", "");
    	description.parent(".imageWrapper").children("img").attr('alt',descriptionTextNoAlt);

    // add br to description
    	descriptionText = descriptionText.replace("#", "<br/>");

    // create description under images
    	description.append(descriptionText);

    description.parent(".imageWrapper").css('float',description.parent(".imageWrapper").children("img").css('float'));
    var wrapperWidth = (description.parent(".imageWrapper").children("img").width());
    //alert(wrapperWidth);

    description.parent(".imageWrapper").css('width',wrapperWidth);
    description.parent(".imageWrapper").children('.imgDesc').css('float',description.parent(".imageWrapper").children("img").css('float'));
    //description.css('width',description.parent(".imageWrapper").children("img").attr('width'));
    description.css('width',wrapperWidth);

    //remove alt text
    	jQuery(this).attr('alt',"");

    // gestione immagine centrata (centratura descrizione)
    	var block_image = thisObj.css('display');
    	var floatAttr = thisObj.css('float');
    	var centerViaWord = thisObj.parent().css('text-align');

    	if (((block_image =="block") && floatAttr=="none") || centerViaWord == "center") {
    		description.css('margin','0');
    		floatAttr ="";
    		block_image = "";
    		thisObj.parent(".imageWrapper").css('margin','auto');
    	}

    // add margin left or right to the wrapper
        switch(floatAttr) {
    	    case "left":
    	        description.parent(".imageWrapper").css('margin-right',20);
    	        break;
    	    case "right":
    	        description.parent(".imageWrapper").css('margin-left',20);
    	        break;
    	}
}

// ***************************************************************************

/***************************************/
/* Wrap image without ALT attribute  */
/***************************************/

function wrapImageWithoutAlt(thisObj){
    var wrapperWidth = (thisObj.width());
    var wrapperFloat = thisObj.css('float');
    var centerViaWord = thisObj.parent().css('text-align');

    // Incapsula l'immagine con ALT della sezione news in un contenitore
        jQuery(this).wrap('<div class="imageWrapper" style="width:'+wrapperWidth+'px; float:'+wrapperFloat+';"/>');

    // gestione immagine centrata (centratura descrizione)
        var block_image = thisObj.css('display');
        var floatAttr = thisObj.css('float');

        if (((block_image =="block") && floatAttr=="none") || centerViaWord == "center") {
            thisObj.parent(".imageWrapper").css('margin','auto');
        }
}


jQuery(document).ready(function(){

	/********************************************/
	/* Assign class zoomable to zoomable images */
	/********************************************/

	jQuery(".postBody img, .zoomImage").not(".no_zoomImage").not(".gallery img").each(function( index ) {

    // Wrap image in a container
    	if (jQuery(this).attr('alt'))
            wrapImageWithAlt(jQuery(this));
    	else
            wrapImageWithoutAlt(jQuery(this));

		/*************************/
		/* IMAGE POPUP           */
		/*************************/

		var current_img = jQuery(this);

		// GET ACTUAL IMG SIZE
			var src = current_img.attr('src');
			var actual_width = current_img.attr('width');
			var actual_height = current_img.attr('height');

		// GET REAL IMG SIZE
		      var url = jQuery(this).attr("src");
              pic_real_width = jQuery(this).width;
              pic_real_height = jQuery(this).height;
              link_width = parseInt(actual_width);
              link_height = parseInt(actual_height);

        // IF ORIGINAL SIZE DIFFER FROM REAL IMG SIZE
            if ((actual_width!=pic_real_width)||(actual_height!=pic_real_height)){

                // Add class zoomable
                    current_img.addClass('zoomable');

                // Assign random ID to the image & append lens
                    var uniqueNum = Math.floor( Math.random()*99999 );

                    var topValue = actual_height-26;
                    var rightValue = 0;
                    if (current_img.hasClass('imgRight')){
                        rightValue -= 9;
                    }

                    current_img
                        .wrap("<a id=ID"+uniqueNum+" href="+src+" style='width:"+link_width+"px;height:"+link_height+"px; display:block;'></a>")
                        .parent()
                        .append( "<div style='clear:both;'></div><div class='lens' style='top:"+topValue+"px;right:"+rightValue+"px;'></div>" );


                // Assign Fancybox action to the element
                    jQuery("a#ID"+uniqueNum).fancybox({
                        toolbar : false,
                        smallBtn:true
                    });

                } //close if
                else{
                    current_img.css({display: 'block'});  // fix to solve description problem alignment for images without popup
                    return;
                }

	});	// close each
});	// close ready
