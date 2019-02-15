<?php

/*
    This plugin shows in a specified number of columns the articles from a specic category. 
    Example of strings that evoke the plugin:
    {# columns category_id=[6] show_images=[1] round_images=[1] show_category_title=[1] #}
*/

namespace App\Classes;

use App\Post;
use App\Category;

class ColumnsClass {

    /**
      *  Returns the plugin parameters
      *  @param array $matches       result from the regular expression on the string from the article
      *  @return array $ret          the array containing the parameters
     **/
     function getParameters($matches) {
         $ret = array();

         //dd($matches);

         // Get activation string parameters (from article)
             $ret['token'] = $matches[0];

             $ret['cat_id'] = $matches[2];
             $ret['show_images'] = $matches[4];
             $ret['round_images'] = $matches[6];
             $ret['show_category_title'] = $matches[8];

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
     *  Prepare the columns HTML
     *  @param array $parameters        parameters array [post_id, img_alignment, img_col_size_class, text_col_size_class]
     *  @param array $columnsData       the posts array
     *
     *  @return string $ret             the HTML to print on screen
    **/
    function prepareColumns($parameters, $postsData, $categoryData) {

          $ret = "<div class='container columns pt-5'>";
          if ($parameters['show_category_title'])
            $ret .= "<h2 class='column-title mb-4' style='text-align: center;'>".$categoryData->name."</h3>";

            $ret .= "<div class='row'>";
            //dump($postsData);
              foreach ($postsData as $key => $postData) {
                  $ret .= "<div class='col'>";
                    //$ret .= "<img class='rounded-circle mb-4' src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' alt='Generic placeholder image' width='140' height='140'>";
                    if ($parameters['show_images']){
                        $ret .= "<img class='rounded-circle mb-4' style='width:100%;' src='".$postData->introimage."' alt='".$postData->introimage_alt."'>";
                    }
                    $ret .= "<h3 class='mb-4'>".$postData->title."</h3>";
                    //$ret .= "<div>".$postData->body."</div>";
                    $ret .= "<div>".str_limit(strip_tags($postData->body, '<br><p><b>'),100)."</div>";
                    $ret .= "<p><a class='btn btn-secondary' href='/post/".$postData->slug."' role='button'>View details »</a></p>";
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
            $ptn = '/{# +columns +(category_id|show_images|round_images|show_category_title)=\[(.*)\] +(category_id|show_images|round_images|show_category_title)=\[(.*)\] +(category_id|show_images|round_images|show_category_title)=\[(.*)\] +(category_id|show_images|round_images|show_category_title)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_category_column_matches);

                        // Get the post and category data
                            $postsData = Post::postsByCategory($parameters['cat_id']);
                            $categoryData = Category::categorydata($parameters['cat_id']);

                        // Prepare Columns HTML
                            $columnsHtml = $this->prepareColumns($parameters, $postsData, $categoryData);

                            //$columnsHtml= "this is the gallery!!";

                        // RENDER
                            $postBody = str_replace($parameters['token'], $columnsHtml, $postBody);
                    }
            }
            return $postBody;
    }

}
