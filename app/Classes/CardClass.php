<?php

/*
    This plugin show a responsive card made by text on one side and an image on the other.

    Example of strings that evoke the plugin:
    {# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[transparent|#34564] text_color=[#212529] container_wrap=[false] #}

*/

namespace App\Classes;

class CardClass
{
    /**
     *  Returns the plugin parameters.
     *  - Matches: result from the regular expression on the string from the article
     *  - Ret: the array containing the parameters.
     *
     * @param  array  $matches
     * @return array $ret
     **/
    public function getParameters($matches)
    {
        $ret = [];

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];
        //dump($matches);

        $ret['post_id'] = $matches[2];
        $ret['img_col_size_class'] = 'col-md-'.$matches[6];
        $textColSize = 12 - $matches[6];
        $ret['text_col_size_class'] = 'col-md-'.$textColSize;
        $backgroundColor = $matches[8];
        $ret['bkg_color'] = 'background-color: '.$backgroundColor.';';
        $textColor = $matches[10];
        $ret['text_color'] = 'color: '.$textColor.';';
        $containerWrap = $matches[12];
        $ret['container_wrap'] = ($containerWrap == 'true') ? 1 : 0;

        //dd($ret['bkg_color']);
        // Image alignment
        //$ret['img_alignment'] = $matches[4];
        $imageAlignment = $matches[4];

        switch ($imageAlignment) {
            case 'left':
                $ret['img_col_order_class'] = 'order-md-1';
                $ret['text_col_order_class'] = 'order-md-2';
                break;
            case 'right':
                $ret['img_col_order_class'] = 'order-md-2';
                $ret['text_col_order_class'] = 'order-md-1';
                break;
        }

        //dump($ret);

        return $ret;
    }

    // **********************************************************************

    /**
     *  Turn array of the metches after preg_match_all function (taken from - https://secure.php.net/manual/en/function.preg-match-all.php).
     *
     * @param  array  $m
     * @return array $ret
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
     *  Provide the post data array (post_title, post_body, post_image).
     *
     * @param  array  $parameters
     * @return array $ret
     **/
    public function getPostData($parameters)
    {
        $postData = app('App\Http\Controllers\PostController')->postdata($parameters['post_id']);

        $ret = [];
        $ret['post_title'] = (! empty($postData->title)) ? $postData->title : $postData->translate('en')->title;
        $ret['post_body'] = (! empty($postData->body)) ? $postData->body : $postData->translate('en')->body;

        if ($postData->introimage) {
            $ret['post_image_src'] = $postData->introimage;
            $ret['post_image_alt'] = $postData->introimage_alt;
        }

        return $ret;
    }

    // **********************************************************************

    /**
     *  Prepare the card HTML.
     *  Paramteters: parameters array [post_id, img_alignment, img_col_size_class, text_col_size_class].
     *
     * @param  array  $parameters
     * @param  array  $postData
     * @return string $ret             the HTML to print on screen
     **/
    public function prepareCard($parameters, $postData)
    {
        $ret = "<div class='row featurette' style='".$parameters['bkg_color'].$parameters['text_color']."'>";
        if ($parameters['container_wrap']) {
            $ret .= "<div class='container'>";
        }
        $ret .= "<div class='text ".$parameters['text_col_size_class'].' my-auto px-4 '.$parameters['text_col_order_class']."'>";
        $ret .= "<h2 class='featurette-heading mt-5'>".$postData['post_title'].'</h2>';
        $ret .= "<div class='lead mb-4'>".$postData['post_body'].'</div>';
        $ret .= '</div>';
        $ret .= "<div class='image ".$parameters['img_col_size_class'].' '.$parameters['img_col_order_class']."'>";
        if (! empty($postData['post_image_src'])) {
            $ret .= "<img class='featurette-image img-fluid mx-auto' src='".$postData['post_image_src']."' alt='".$postData['post_image_alt']."'>";
        }
        $ret .= '</div>';
        if ($parameters['container_wrap']) {
            $ret .= '</div>';
        }
        $ret .= '</div>';

        return $ret;
    }

    // **********************************************************************

    /**
     *  Prepare the card HTML.
     *  Paramteters: parameters array [post_id, img_alignment, img_col_size_class, text_col_size_class].
     *
     * @param  string  $postBody
     * @return string $postBody
     **/
    public function getCard($postBody)
    {
        // Find plugin occurrences
        $ptn = '/{# +card +(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[(.*)\] +(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[(.*)\] +#}/';

        if (preg_match_all($ptn, $postBody, $matches)) {
            // Trasform the matches array in a way that can be used
            $matches = $this->turn_array($matches);
            //dd($matches);
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
