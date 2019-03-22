<?php

/*
    This plugin show a Paypal button

    Example of strings that evoke the plugin:
    {# paypal_button button_id=[K2D2D4E376MAN] #}
*/

namespace App\Classes;

class PaypalButtonClass
{
    /* **********************************************************************/

    /**
     *  Substitute the activation string with the HTML.
     *  @param array $postBody        the post html
     *
     *  @return string $ret             the HTML to print on screen
     **/
    public function getPaypalButton($postBody)
    {

        // Find plugin occurrences
        $ptn = '/{# +paypal_button +(button_id)=\[(.*)\] #}/';

        if (preg_match_all($ptn, $postBody, $matches)) {

                // Trasform the matches array in a way that can be used
            $matches = $this->turn_array($matches);

            foreach ($matches as $key => $paypal_button_matches) {

                        // Get plugin parameters array
                $parameters = $this->getParameters($paypal_button_matches);

                // Prepare Stats HTML
                $statsHtml = $this->preparePaypalButton($parameters);

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
     *  Returns the plugin parameters.
     *  @param array $matches       result from the regular expression on the string from the article
     *  @return array $ret          the array containing the parameters
     **/
    public function getParameters($matches)
    {
        $ret = [];

        //dump($matches);

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['button_code'] = $matches[2];

        return $ret;
    }

    /* **********************************************************************/

    /**
     *  Prepare the stats HTML.
     *  @param array $parameters        parameters array [coding_hours, pm_hours, steering_commitee_meetings, languages_number]
     *  @return string $ret             the HTML to print on screen
     **/
    public function preparePaypalButton($parameters)
    {
        $ret = "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>";
        $ret .= "<input type='hidden' name='cmd' value='_s-xclick' />";
        $ret .= "<input type='hidden' name='hosted_button_id' value='".$parameters['button_code']."' />";
        $ret .= "<input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif' border='0' name='submit' title='PayPal - The safer, easier way to pay online!' alt='Donate with PayPal button' />";
        $ret .= "<img alt='' border='0' src='https://www.paypal.com/en_IT/i/scr/pixel.gif' width='1' height='1' />";
        $ret .= '</form>';

        return $ret;
    }
}
