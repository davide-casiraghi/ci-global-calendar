

// Load Jquery UI accordion, the one with (+)
    if (jQuery('.accordion').length){

        jQuery(function () {
            var icons = {
                header: "iconClosed",    // custom icon class
                activeHeader: "iconOpen" // custom icon class
            };
            jQuery(".accordion").accordion({
                icons: icons,
                collapsible: true,
                active: false,
                animate: 400,

                // Triggered when the accordion is created.
                    // If the accordion is collapsed, ui.header and ui.panel will be empty jQuery objects.

                create: function( event, ui ) {

                    // Remove BR in between two accordions
                        // If there is ONE <br>
                            if(jQuery(this).next().is('br')) {
                                if(jQuery(this).nextAll("*:lt(2)").is('.accordion')) {
                                    //console.log("remove");
                                    jQuery(this).next().remove();
                                }
                            }
                        // If there are TWO <br>
                            if(jQuery(this).next().is('br')) {
                                if(jQuery(this).nextAll("*:lt(2)").is('br')) {
                                    if(jQuery(this).nextAll("*:lt(3)").is('.accordion')) {
                                        console.log("remove");
                                        jQuery(this).next().remove();
                                        jQuery(this).next().remove();
                                    }
                                }
                            }

                        // If this is the last element of the group add the border
                            if(!jQuery(this).next().is('.accordion')) {
                                jQuery(this).css({ 'border-bottom': ("1px solid #c5c5c5") });
                            }

                        // If the content of an accordion start with <br> remove it
                            if(jQuery(this).children('.ui-accordion-content').children(':first-child').is('br')) {
                                jQuery(this).children('.ui-accordion-content').children('br:first-child').remove();
                            }
                }
            });

        });
    }
