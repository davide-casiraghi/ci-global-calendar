<?php

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
             $ret['img_alignment'] = $matches[4];
             $ret['img_col_size_class'] = "col-md-".$matches[6];
             $textColSize = 12-$matches[6];
             $ret['text_col_size_class'] = "col-md-".$textColSize;

             dump($ret);

         return $ret;
     }
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
        *  Provide the post data array (post_title, post_body, post_image)
        *  @param array $file_name        the file name
        *  @return array $ret             the extension
       **/

       function getPostData($parameters) {

           $image_dir_url = "/storage/images";

           $ret['post_title'] = "TiTlE";
           $ret['post_body'] = "postBody postBody postBody postBody postBody ";
           $ret['post_image'] = $image_dir_url."ciao.png";

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

            $ret = "<div class='row featurette'>";
                $ret .= "<div class='col-md-7'>";
                    $ret .= "<h2 class='featurette-heading'>".$postData['post_title']."</h2>";
                    $ret .= "<p class='lead'>".$postData['post_body']."</p>";
                $ret .= "</div>";
                $ret .= "<div class='col-md-5'>";
                    $ret .= "<img class='featurette-image img-fluid mx-auto' data-src='holder.js/500x500/auto' alt='500x500' style='width: 500px; height: 500px;' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22500%22%20height%3D%22500%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20500%20500%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_166e45c36da%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A25pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_166e45c36da%22%3E%3Crect%20width%3D%22500%22%20height%3D%22500%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22185.125%22%20y%3D%22261.1%22%3E500x500%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' data-holder-rendered='true'>";
                $ret .= "</div>";
            $ret .= "</div>";

          return $ret;
      }


    // **********************************************************************



/*
    public function getCard($postBody) {

        // Load the accordion template
            $cardTemplate = "<div class='row featurette'>";
                $cardTemplate .= "<div class='col-md-7'>";
                $cardTemplate .= "<h2 class='featurette-heading'>{CARD_TITLE}</h2>";
                $cardTemplate .= "<p class='lead'>{CARD_CONTENT}</p>";
          $cardTemplate .= "</div>";
          $cardTemplate .= "<div class='col-md-5'>";
            $cardTemplate .= "<img class='featurette-image img-fluid mx-auto' data-src='holder.js/500x500/auto' alt='500x500' style='width: 500px; height: 500px;' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22500%22%20height%3D%22500%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20500%20500%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_166e45c36da%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A25pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_166e45c36da%22%3E%3Crect%20width%3D%22500%22%20height%3D%22500%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22185.125%22%20y%3D%22261.1%22%3E500x500%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' data-holder-rendered='true'>";
            $cardTemplate .= "</div>";
        $cardTemplate .= "</div>";


        // Do the replacement if needed
            if (substr_count($postBody, '{slide') > 0) {
                $regex = "#(?:<p>)?\{slide[r]?=([^}]+)\}(?:</p>)?(.*?)(?:<p>)?\{/slide[r]?\}(?:</p>)?#s";

                $postBody = preg_replace(
                    $regex,
                    str_replace(
                        array("{CARD_TITLE}", "{CARD_CONTENT}"),
                        array("$1", "$2"),
                        $cardTemplate
                    ),
                    $postBody
                );

            }


        return $postBody;
    }
*/

    // **********************************************************************

    public function getCard($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +card +(post_id|img_alignment|img_col_size)=\[(.*)\] +(post_id|img_alignment|img_col_size)=\[(.*)\] +(post_id|img_alignment|img_col_size)=\[(.*)\] +#}/';

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
