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
     *  Substitute in the post HTML, the activation string with the Paypal HTML.
     *
     * @param  array  $postBody
     * @return string
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
     *
     * @param  array  $file_name  the file name
     * @return array $ret             the extension
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
     * @param  array  $matches
     * @return array
     **/
    public function getParameters($matches)
    {
        $ret = [];

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['button_code'] = $matches[2];

        return $ret;
    }

    /* **********************************************************************/

    /**
     *  Return the Paypal HTML ready to be rendered.
     *
     * @param  array  $parameters
     * @return string
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
