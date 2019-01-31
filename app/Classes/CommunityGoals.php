<?php

/*
    Example of strings that evoke the plugin:
    {# stats_donate coding_hours=[2400] pm_hours=[40] steering_commitee_meetings=[60] languages_number=[8] #}
*/


namespace App\Classes;

class CommunityGoalsClass {

    
    // **********************************************************************
    /**
     *  Substitute the activation string with the HTML
     *  @param array $postBody        the post html
     *
     *  @return string $ret             the HTML to print on screen
    **/
    public function getCommunityGoals($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +community_goals +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_category_column_matches);

                        // Prepare Stats HTML
                            $statsHtml = $this->prepareStatsDonate($parameters);

                            //$statsHtml= "this are the donations stats!!";

                        // RENDER
                            $postBody = str_replace($parameters['token'], $statsHtml, $postBody);
                    }
            }
            return $postBody;
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
     *  Returns the plugin parameters
     *  @param array $matches       result from the regular expression on the string from the article
     *  @return array $ret          the array containing the parameters
    **/
    function getParameters($matches) {
        $ret = array();

        //dump($matches);

        // Get activation string parameters (from article)
            $ret['token'] = $matches[0];

            $ret['backed_amount'] = $matches[2];
            $ret['goal_amount'] = $matches[4];
            $ret['backers_number'] = $matches[6];
            $ret['days_left'] = $matches[8];

        return $ret;
    }
    
    // **********************************************************************
    /**
     *  Prepare the stats HTML
     *  @param array $parameters        parameters array [coding_hours, pm_hours, steering_commitee_meetings, languages_number]
     *  @return string $ret             the HTML to print on screen
    **/
    function prepareCommunityGoals($parameters) {
          
          $ret = "<div class='communityGoals'>";
          
            //$parameters['backed_amount']
            //$parameters['goal_amount']
            //$parameters['backers_number']
            //$parameters['days_left']
          
          $ret .= "ciao";
            $ret .= "<small><i class='far fa-info-circle'></i>The datas are not updated in real time.</small>";
          $ret .= "</div>";

        return $ret;
    }


}
