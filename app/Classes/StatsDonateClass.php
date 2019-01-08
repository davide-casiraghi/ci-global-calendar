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
            $ptn = '/{# +columns +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_lines|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_category_column_matches);

                        // Get the post and category data
                            $postsData = $this->getPostsData($parameters);
                            $categoryData = $this->getCategoryData($parameters);

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
