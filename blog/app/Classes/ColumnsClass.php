<?php

/*
    Example of strings that evoke the plugin:
    {# columns category_id=[6] show_images=[1] round_images=[1] #}
*/

namespace App\Classes;

class ColumnsClass {

    /**
      *  Returns the plugin parameters
      *  @param array $matches       result from the regular expression on the string from the article
      *  @return array $ret          the array containing the parameters
     **/
     function getParameters($matches) {
         $ret = array();

         // Get activation string parameters (from article)
             $ret['token'] = $matches[0];
             //dump($matches);

             $ret['cat_id'] = $matches[2];

/*
             $ret['img_col_size_class'] = "col-md-".$matches[6];
             $textColSize = 12-$matches[6];
             $ret['text_col_size_class'] = "col-md-".$textColSize;

             // Image alignment
                 //$ret['img_alignment'] = $matches[4];
                 $imageAlignment =  $matches[4];

                 switch ($imageAlignment) {
                     case 'left':
                         $ret['img_col_order_class'] = "order-md-1";
                         $ret['text_col_order_class'] = "order-md-2";
                         break;
                     case 'right':
                         $ret['img_col_order_class'] = "order-md-2";
                         $ret['text_col_order_class'] = "order-md-1";
                         break;
                 }
*/
             //dump($ret);

         return $ret;
     }

    // **********************************************************************

    /**
     *  Provide the post data array (post_title, post_body, post_image)
     *  @param array $file_name        the file name
     *  @return array $ret             the extension
    **/

    function getPostsData($parameters) {
        $postsData = app('App\Http\Controllers\PostController')->postsdata($parameters['cat_id']);
        $ret = $postsData;

        return $ret;
    }

   // **********************************************************************

     /**
      *  Turn array of the metches after preg_match_all function (taken from - https://secure.php.net/manual/en/function.preg-match-all.php)
      *  @param array $file_name        the file name
      *  @return array $ret             the extension
     **/

     function turn_array($m) {
         for ($z = 0;$z < count($m);$z++){
             for ($x = 0;$x < count($m[$z]);$x++){
                 $ret[$x][$z] = $m[$z][$x];
             }
         }
         return $ret;
     }

    // **********************************************************************

    /**
     *  Prepare the columns HTML
     *  @param array $parameters        parameters array [post_id, img_alignment, img_col_size_class, text_col_size_class]
     *  @param array $columnsData       the posts array
     *
     *  @return string $ret             the HTML to print on screen
    **/
    function prepareColumns($parameters, $postsData) {
        dump($postsData);

        $columnWidth = number_format(floor(12/count($postsData)));
        $columnWidthClass = "col-lg-".$columnWidth;

          $ret = "<div class='container marketing'>";
            $ret = "<div class='row'>";
              foreach ($postsData as $key => $postData) {
                  $ret .= "<div class='".$columnWidthClass."'>";
                    $ret .= "<img class='rounded-circle' src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' alt='Generic placeholder image' width='140' height='140'>";
                    $ret .= "<h2>Heading</h2>";
                    $ret .= "<p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>";
                    $ret .= "<p><a class='btn btn-secondary' href='#' role='button'>View details »</a></p>";
                  $ret .= "</div>";
              }
             $ret .= "</div>";
          $ret .= "</div>";

        return $ret;
    }

    // **********************************************************************

    /**
     *  Substitute the activation string with the HTML
     *  @param array $postBody        the post html
     *
     *  @return string $ret             the HTML to print on screen
    **/

    public function getColumns($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +columns +(category_id|show_images|round_images)=\[(.*)\] +(category_id|show_images|round_images)=\[(.*)\] +(category_id|show_images|round_images)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_category_column_matches);

                        // Get the post data
                            $postsData = $this->getPostsData($parameters);

                        // Prepare Columns HTML
                            $columnsHtml = $this->prepareColumns($parameters, $postsData);

                            //$columnsHtml= "this is the gallery!!";

                        // RENDER
                            $postBody = str_replace($parameters['token'], $columnsHtml, $postBody);

                    }
            }
            return $postBody;
    }

}
