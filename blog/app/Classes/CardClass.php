<?php

/*
    Example of strings that evoke the plugin:
    {# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[transparent|#34564] #}
    or
    {# card post_id=[9] img_alignment=[left] img_col_size=[3] #}
*/


namespace App\Classes;

class CardClass {

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

             $ret['post_id'] = $matches[2];
             $ret['img_col_size_class'] = "col-md-".$matches[6];
             $textColSize = 12-$matches[6];
             $ret['text_col_size_class'] = "col-md-".$textColSize;
             $backgroundColor = $matches[8];
             $ret['bkg_color'] = "background-color: ".$backgroundColor;

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

             //dump($ret);

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
        *  Provide the post data array (post_title, post_body, post_image)
        *  @param array $file_name        the file name
        *  @return array $ret             the extension
       **/

       function getPostData($parameters) {

           //$image_dir_url = "/storage/images";

           $postData = app('App\Http\Controllers\PostController')->postdata($parameters['post_id']);

           $ret['post_title'] = $postData->title;
           $ret['post_body'] = $postData->body;
           $ret['post_image_src'] = $postData->introimage_src;
           $ret['post_image_alt'] = $postData->introimage_alt;

           return $ret;
       }

      // **********************************************************************

      /**
       *  Prepare the card HTML
       *  @param array $parameters        parameters array [post_id, img_alignment, img_col_size_class, text_col_size_class]
       *
       *  @return string $ret             the HTML to print on screen
      **/
      function prepareCard($parameters, $postData) {

            $ret = "<div class='row featurette' style='".$parameters['bkg_color']."'>";
                $ret .= "<div class='".$parameters['text_col_size_class']." text my-auto ".$parameters['text_col_order_class']."'>";
                    $ret .= "<h2 class='featurette-heading'>".$postData['post_title']."</h2>";
                    $ret .= "<div class='lead'>".$postData['post_body']."</div>";
                $ret .= "</div>";
                $ret .= "<div class='".$parameters['img_col_size_class']." image ".$parameters['img_col_order_class']."'>";
                    $ret .= "<img class='featurette-image img-fluid mx-auto' src='".$postData['post_image_src']."' alt='".$postData['post_image_alt']."'>";
                $ret .= "</div>";
            $ret .= "</div>";

          return $ret;
      }

    // **********************************************************************

    public function getCard($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +card +(post_id|img_alignment|img_col_size|bkg_color)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_gallery_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_gallery_matches);

                        // Get the post data
                            $postData = $this->getPostData($parameters);

                        // Prepare Card HTML
                            $cardHtml = $this->prepareCard($parameters, $postData);

                            //$cardHtml= "this is the gallery!!";

                        // RENDER
                            $postBody = str_replace($parameters['token'], $cardHtml, $postBody);

                    }
            }
            return $postBody;
    }

}
