<?php

/*
    This plugin shows in a specified number of cards from the articles from a specic category. 
    Example of strings that evoke the plugin:
    {# cardsCarousel category_id=[6] posts_shown=[3] posts_max_number=[6] show_images=[1] round_images=[1] show_category_title=[1] limit_chars=[100] #}
*/

namespace App\Classes;

use Illuminate\Support\Str;

use App\Post;
use App\Category;

class CardsCarouselClass {

    /**
      *  Returns the plugin parameters
      *  @param array $matches       result from the regular expression on the string from the article
      *  @return array $ret          the array containing the parameters
     **/
     function getParameters($matches) {
         $ret = array();

         // Get activation string parameters (from article)
             $ret['token'] = $matches[0];

             $ret['cat_id'] = $matches[2];
             $ret['posts_shown'] = $matches[4];
             $ret['posts_max_number'] = $matches[6];
             $ret['show_images'] = $matches[8];
             $ret['round_images'] = $matches[10];
             $ret['show_category_title'] = $matches[12];
             $ret['limit_chars'] = $matches[14];
             
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

    /***************************************************************************/
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

            $ret .= "<div class='row card-carousel-wrapper'>";
            //dump($postsData);
              for ($i=1; $i <= $parameters['posts_max_number']; $i++) {
                  $ret .= "<div class='col'>";
                      if ($parameters['show_images']){
                          $ret .= "<img class='rounded-circle mb-4' style='width:100%;' src='".$postsData[$i]->introimage."' alt='".$postData->introimage_alt."'>";
                      }
                      
                      $ret .= "<h3 class='mb-4'>".$postsData[$i]->title."</h3>";
                      $ret .= "<div>".Str::limit(strip_tags($postsData[$i]->body, '<br><p><b>'),$parameters['limit_chars'])."</div>";
                      $ret .= "<p><a class='btn btn-secondary' href='/post/".$postsData[$i]->slug."' role='button'>View details »</a></p>";
                  $ret .= "</div>";
              }
             $ret .= "</div>";
          $ret .= "</div>";

        return $ret;
    }

    /***************************************************************************/
    /**
     *  Substitute the activation string with the HTML
     *  @param array $postBody        the post html
     *
     *  @return string $ret             the HTML to print on screen
    **/

    public function getColumns($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +cardsCarousel +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +(category_id|posts_shown|posts_max_number|show_images|round_images|show_category_title|limit_chars)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){
                
                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_category_column_matches);

                        // Get the post and category data
                            $postsData = Post::postsByCategory($parameters['cat_id']);
                            $categoryData = Category::categorydata($parameters['cat_id']);
                            
                            //dump($postsData);

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
