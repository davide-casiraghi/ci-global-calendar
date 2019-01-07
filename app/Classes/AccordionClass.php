<?php

/*
    This plugin show a responsive accordion with a title that open when [+] button is clicked
    Example of strings that evoke the plugin:
    {slider=HOW to add contents to this website? - Create account} lorem ipsum {/slider}
*/

namespace App\Classes;

class AccordionClass {

    public function getAccordion($postBody) {
        
        // Load the accordion template
            $sliderTemplate = "<div class='accordion'>";
                $sliderTemplate .= "<h3>{SLIDER_TITLE}</h3>";
                $sliderTemplate .= "<div>{SLIDER_CONTENT}</div>";
            $sliderTemplate .= "</div>";

        // Do the replacement if needed
            if (substr_count($postBody, '{slide') > 0) {
                
                $regex = "#(?:<p>)?\{slide[r]?=([^}]+)\}(?:</p>)?(.*?)(?:<p>)?\{/slide[r]?\}(?:</p>)?#s";

                $postBody = preg_replace(
                    $regex,
                    str_replace(
                        array("{SLIDER_TITLE}", "{SLIDER_CONTENT}"),
                        array("$1", "$2"),
                        $sliderTemplate
                    ),
                    $postBody
                );

            }


        return $postBody;
    }

}
