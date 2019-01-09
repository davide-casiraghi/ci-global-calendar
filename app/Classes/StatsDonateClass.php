<?php

/*
    Example of strings that evoke the plugin:
    {# stats_donate coding_lines=[2400] pm_hours=[40] steering_commitee_meetings=[60] languages_number=[8] #}
*/


namespace App\Classes;

class StatsDonateClass {

    
    // **********************************************************************
    /**
     *  Substitute the activation string with the HTML
     *  @param array $postBody        the post html
     *
     *  @return string $ret             the HTML to print on screen
    **/
    public function getStatsDonate($postBody) {

        // Find plugin occurrences
            $ptn = '/{# +stats_donate +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +#}/';

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

            $ret['coding_lines'] = $matches[2];
            $ret['pm_hours'] = $matches[4];
            $ret['steering_commitee_meetings'] = $matches[6];
            $ret['languages_number'] = $matches[8];

        return $ret;
    }
    
    // **********************************************************************
    /**
     *  Prepare the stats HTML
     *  @param array $parameters        parameters array [coding_lines, pm_hours, steering_commitee_meetings, languages_number]
     *  @return string $ret             the HTML to print on screen
    **/
    function prepareStatsDonate($parameters) {
          
          $ret = "<h3 class='text-center mb-5'>Some numbers about the project</h3>";
          
          $ret .= "<div class='row text-center'>";
            $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
                $ret .= "<i class='far fa-align-left'></i>";
                $ret .= "<br />";
                $ret .= $parameters['coding_lines']." coding lines";
            $ret .= "</div>";
            $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
                $ret .= "<i class='far fa-clock'></i>";
                $ret .= "<br />";
                $ret .= $parameters['pm_hours']." hours of project management";
            $ret .= "</div>";
            $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
                $ret .= "<i class='far fa-users'></i>";
                $ret .= "<br />";
                $ret .= $parameters['steering_commitee_meetings']." steering commitee meetings";
            $ret .= "</div>";
            $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
                $ret .= "<i class='far fa-globe'></i>";
                $ret .= "<br />";
                $ret .= $parameters['languages_number']." languages the website is translated in";
            $ret .= "</div>";
          
          $ret .= "</div>";

        return $ret;
    }



}
