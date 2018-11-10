<?php

/*
    Example of strings that evoke the plugin:
    {# columns category_id=[6] show_images=[1] round_images=[1] #}
*/

namespace App\Classes;

class ColumnsClass {



    // **********************************************************************

     /**
      *  Turn array of the metches after preg_match_all function (taken from - https://secure.php.net/manual/en/function.preg-match-all.php)
      *  @param array $file_name        the file name
      *  @return array $ret             the extension
     **/

     function turn_array($m) {
         for ($z = 0;$z < count($m);$z++)
         {
             for ($x = 0;$x < count($m[$z]);$x++)
             {
                 $ret[$x][$z] = $m[$z][$x];
             }
         }
         return $ret;
     }

    // **********************************************************************

    /**
     *  Prepare the card HTML
     *  @param array $parameters        parameters array [post_id, img_alignment, img_col_size_class, text_col_size_class]
     *
     *  @return string $ret             the HTML to print on screen
    **/
    function prepareColumns($parameters, $columnsData) {

          $ret = "<div class='row featurette'>";
              $ret .= "columns rendered"
          $ret .= "</div>";

        return $ret;
    }

    // **********************************************************************

    public function getColumns($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +columns +(category_id|show_images|round_images)=\[(.*)\] +(category_id|show_images|round_images)=\[(.*)\] +(post_id|img_alignment|img_col_size)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_category_column_matches);

                        // Get the post data
                            $postData = $this->getPostData($parameters);

                        // Prepare Card HTML
                            $cardHtml = $this->prepareColumns($parameters, $columnsData);

                            //$cardHtml= "this is the gallery!!";

                        // RENDER
                            $postBody = str_replace($parameters['token'], $cardHtml, $postBody);

                    }
            }
            return $postBody;
    }

}
