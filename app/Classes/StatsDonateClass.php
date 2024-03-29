<?php

/*
    This plugin shows some icons and numbers about the CI Calendar development effort.
    The data shown are:
        - Coding hours
        - Project management hours
        - Number of Steering Commitee meetings
        - Number of languages the calendar is translated in

    Example of strings that evoke the plugin:
    {# stats_donate coding_hours=[2400] pm_hours=[40] steering_commitee_meetings=[60] languages_number=[8] #}
*/

namespace App\Classes;

class StatsDonateClass
{
    /* **********************************************************************/

    /**
     *  Substitute in the post HTML, the activation string with the stats HTML.
     *
     *  @param string $postBody
     *  @return string
     **/
    public function getStatsDonate($postBody)
    {
        // Find plugin occurrences
        $ptn = '/{# +stats_donate +(coding_hours|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_hours|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_hours|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +(coding_hours|pm_hours|steering_commitee_meetings|languages_number)=\[(.*)\] +#}/';

        if (preg_match_all($ptn, $postBody, $matches)) {
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

    /* **********************************************************************/

    /**
     *  Turn array of the metches after preg_match_all function (taken from - https://secure.php.net/manual/en/function.preg-match-all.php).
     *
     *  @param array $file_name        the file name
     *  @return array $ret             the extension
     **/
    public function turn_array($m)
    {
        for ($z = 0; $z < count($m); $z++) {
            for ($x = 0; $x < count($m[$z]); $x++) {
                $ret[$x][$z] = $m[$z][$x];
            }
        }

        return $ret;
    }

    /* **********************************************************************/

    /**
     *  Returns the parameters from the activation string
     *  The $matches come from the regular expression on the string from the article.
     *
     *  @param array $matches
     *  @return array
     **/
    public function getParameters($matches)
    {
        $ret = [];

        //dump($matches);

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['coding_hours'] = $matches[2];
        $ret['pm_hours'] = $matches[4];
        $ret['steering_commitee_meetings'] = $matches[6];
        $ret['languages_number'] = $matches[8];

        return $ret;
    }

    /* **********************************************************************/

    /**
     *  Return the stats HTML ready to be rendered.
     *  Parameters array: [coding_hours, pm_hours, steering_commitee_meetings, languages_number].
     *
     *  @param array $parameters
     *  @return string
     **/
    public function prepareStatsDonate($parameters)
    {
        $ret = "<div class='statisticsDonate'>";
        $ret .= "<h3 class='text-center mb-2'>Some numbers about the project</h3>";

        $ret .= "<div class='row text-center'>";
        $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
        $ret .= "<h4 class='mb-2'><i class='far fa-align-left'></i></h4>";
        $ret .= "<h5 class='mt-2 mb-2 counter'><strong>".$parameters['coding_hours'].'</strong></h5>';
        $ret .= 'Hours spent for web design and development';
        $ret .= '</div>';
        $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
        $ret .= "<h4 class='mb-2'><i class='far fa-clock'></i></h4>";
        $ret .= "<h5 class='mt-2 mb-2 counter'><strong>".$parameters['pm_hours'].'</strong></h5>';
        $ret .= 'Hours of project management';
        $ret .= '</div>';
        $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
        $ret .= "<h4 class='mb-2'><i class='far fa-users'></i></h4>";
        $ret .= "<h5 class='mt-2 mb-2 counter'><strong>".$parameters['steering_commitee_meetings'].'</strong></h5>';
        $ret .= 'Hours spent by the Steering Committee since 2008';
        $ret .= '</div>';
        $ret .= "<div class='col-12 col-sm-6 col-md-3'>";
        $ret .= "<h4 class='mb-2'><i class='far fa-globe'></i></h4>";
        $ret .= "<h5 class='mt-2 mb-2 counter'><strong>".$parameters['languages_number'].'</strong></h5>';
        $ret .= 'Languages the website is translated in';
        $ret .= '</div>';

        $ret .= '</div>';
        $ret .= '</div>';

        return $ret;
    }
}
