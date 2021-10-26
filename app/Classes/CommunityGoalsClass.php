<?php

/*
    This plugin shows a graph with a the fund rise amount gloal
    and an istogram bar with the complete percentage.
    Inspired by: https://cdn-images-1.medium.com/max/1200/1*qpXrpIUJy0ryQOht2Al0tA.png

    Example of strings that evoke the plugin:
    {# community_goals backed_amount=[300] goal_amount=[2000] backers_number=[30] days_left=[40] #}
*/

namespace App\Classes;

class CommunityGoalsClass
{
    // **********************************************************************

    /**
     *  Substitute the activation string with the HTML.
     *
     *  @param array $postBody        the post html
     *  @return string $ret             the HTML to print on screen
     **/
    public function getCommunityGoals($postBody)
    {

        // Find plugin occurrences
        $ptn = '/{# +community_goals +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +(backed_amount|goal_amount|backers_number|days_left)=\[(.*)\] +#}/';

        if (preg_match_all($ptn, $postBody, $matches)) {

                // Trasform the matches array in a way that can be used
            $matches = $this->turn_array($matches);

            foreach ($matches as $key => $single_category_column_matches) {

                        // Get plugin parameters array
                $parameters = $this->getParameters($single_category_column_matches);

                // Prepare Stats HTML
                $statsHtml = $this->prepareCommunityGoals($parameters);

                //$statsHtml= "this are the donations stats!!";

                // RENDER
                $postBody = str_replace($parameters['token'], $statsHtml, $postBody);
            }
        }

        return $postBody;
    }

    // **********************************************************************

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

    // **********************************************************************

    /**
     *  Returns the plugin parameters.
     *
     *  @param array $matches       result from the regular expression on the string from the article
     *  @return array $ret          the array containing the parameters
     **/
    public function getParameters($matches)
    {
        $ret = [];

        //dump($matches);

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['backed_amount'] = $matches[2];
        $ret['goal_amount'] = $matches[4];
        $ret['backers_number'] = $matches[6];
        $ret['days_left'] = $matches[8];

        $ret ['progress_bar_value'] = ($ret['backed_amount'] / $ret['goal_amount']) * 100;

        return $ret;
    }

    // **********************************************************************

    /**
     *  Prepare the stats HTML.
     *
     *  @param array $parameters        parameters array [coding_hours, pm_hours, steering_commitee_meetings, languages_number]
     *  @return string $ret             the HTML to print on screen
     **/
    public function prepareCommunityGoals($parameters)
    {
        $ret = "<div class='communityGoals'>";

        $ret .= "<div class='card'>";
        $ret .= "<div class='card-header'>";
        $ret .= 'CI Global Calendar - Fundraising campaign 2019';
        $ret .= '</div>';
        $ret .= "<div class='card-body pb-1'>";

        $ret .= "<div class='row'>";
        $ret .= "<div class='col-6 text-center'>";
        $ret .= "<i class='far fa-coins'></i> Backed ".$parameters['backed_amount'].' €';
        $ret .= '</div>';
        $ret .= "<div class='col-6 text-center'>";
        $ret .= "<i class='far fa-flag-checkered'></i> Goal ".$parameters['goal_amount'].' €';
        $ret .= '</div>';
        $ret .= '</div>';

        $ret .= "<div class='progress mt-2'>";
        $ret .= "<div class='progress-bar bg-success' style='width: ".$parameters['progress_bar_value']."%' aria-valuenow='".$parameters['progress_bar_value']."' aria-valuemin='0' aria-valuemax='100'>";
        $ret .= "<span class='sr-only'>".$parameters['progress_bar_value'].'% Complete (success)</span>';
        $ret .= '</div>';
        $ret .= '</div>';

        /* Time left */
        $ret .= "<div class='row mt-3'>";
        $ret .= "<div class='col-12 text-center'>";
        $ret .= "<i class='far fa-alarm-clock'></i> ";
        $ret .= 'Time left: ';
        $ret .= '<strong>'.$parameters['days_left'].' Days</strong>';
        $ret .= '</div>';
        $ret .= '</div>';

        $ret .= "<div class='row'>";
        $ret .= "<div class='col-12 text-right text-muted'>";
        $ret .= '<small>The datas are not updated in real time.</small>';
        $ret .= '</div>';
        $ret .= '</div>';

        $ret .= '</div>';
        $ret .= '</div>';

        $ret .= '</div>';

        return $ret;
    }
}
