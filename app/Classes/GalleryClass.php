<?php

/*
    This plugin show a responsive gallery
    Example of strings that evoke the plugin:
    {# gallery src=[contact_improvisation/gallery_1] width=[400] height=[300] #}
*/

namespace App\Classes;

class GalleryClass {

    /**
      *  Returns the plugin parameters
      *  @param array $matches       result from the regular expression on the string from the article
      *  @return array $ret          the array containing the parameters
     **/
     function getParameters($matches, $storagePath, $publicPath) {

         $ret = array();

         // Get Paths
             $sitePath = '/';
             $siteUrl  = $publicPath;

         // Get activation string parameters (from article)
             $ret['token'] = $matches[0];
             $subDir = $matches[2];
             $ret['photo_width'] = $matches[4];
             $ret['photo_height'] = $matches[6];

         // Directories
             $ret['images_dir'] = $publicPath."/images/".$subDir."/";
             $ret['thumbs_dir'] = $publicPath."/images/".$subDir.'/thumb/';

         // Thumbnails size
             $ret['thumbs_size']['width'] = 300;
             $ret['thumbs_size']['height'] = 300;

         // URL variables
             $ret['gallery_url'] = "/images/".$subDir."/";
             $ret['thumb_url'] = "/images/".$subDir."/thumbs/";

         return $ret;
     }

    // **********************************************************************
    /**
     *  Generate a single thumbnail file from an image
     *  @param array $src               path of the original image
     *  @param array $dest              path of the generated thumbnail
     *  @param array $desired_width     width of the thumbnail
     *  @return create a file
    **/
    function generate_single_thumb_file($src,$dest,$desired_width, $desired_height) {
        // Read the source image
            $source_image = imagecreatefromjpeg($src);

        // Get width and height of the original image
            $width = imagesx($source_image);
            $height = imagesy($source_image);

        // find the "desired height" of this thumbnail, relative to the desired width
            //$desired_height = floor($height*($desired_width/$width));

            // now thumbnails are square so is the same of width
            //$desired_height = $desired_width;



            // Horizontal image
                if ($width > $height){
                    $desired_width = 400;
                    $desired_height = floor($height*($desired_width/$width));
                }
            // Vertical image
                else{
                    $desired_height = 500;
                    $desired_width = floor($width*($desired_height/$height));
                }


        // Create a new, "virtual" image
            $virtual_image = imagecreatetruecolor($desired_width,$desired_height);

        // Copy source image at a resized size
            //imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
            imagecopyresampled($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);


        //Create the physical thumbnail image to its destination
            imagejpeg($virtual_image,$dest);
    }

    // **********************************************************************
    /**
     *  Generate all the thumbnails of the gallery
     *  @param string $images_dir        images dir on the server
     *  @param string $thumbs_dir        thumb dir on the server
     *  @param array $image_files
     *  @return generate thumbnail files
    **/
    function generateThumbs($images_dir, $thumbs_dir, $thumbs_size, $image_files) {

        // Thumbnails size
            $thumbs_width = $thumbs_size['width'];
            $thumbs_height = $thumbs_size['height'];

        //  Create thumbs dir
            if (!is_dir($thumbs_dir)) {
              mkdir($thumbs_dir);
            }

        // Generate missing thumbs
            if(count($image_files)) {
                $index = 0;
                foreach($image_files as $index=>$file) {
                    $index++;
                    $thumbnail_image = $thumbs_dir.$file;
                    if(!file_exists($thumbnail_image)) {
                        $extension = $this->get_file_extension($thumbnail_image);
                        if($extension) {
                            //echo $images_dir." ".$file." ".$thumbnail_image." ".$thumbs_width;
                            $this->generate_single_thumb_file($images_dir.$file,$thumbnail_image,$thumbs_width, $thumbs_height);
                        }
                    }
                }
            }
    }

    // **********************************************************************
    /**
     *  Create images array
     *  @param array $image_files           array with all the image names
     *  @param ***array $dest              path of the generated thumbnail
     *  @param ****array $desired_width     width of the thumbnail
     *  @return $ret    array with the images datas
    **/
    function createImagesArray($image_files, $image_data, $gallery_url) {

        //dump($image_data, "image data");

        // Order by image name
            sort($image_files);

        $ret = array();

        foreach ($image_files as $k => $image_file) {
            $ret[$k]['file_path'] = $gallery_url.$image_file;
            $ret[$k]['thumb_path'] = $gallery_url."thumb/".$image_file;
            $ret[$k]['description'] = $image_data[$image_file]['description'];
            $ret[$k]['video_link'] = $image_data[$image_file]['video'];
        }
        //dump($ret,"images");

        return $ret;
    }

    // **********************************************************************
    /**
     *  Get images files name array
     *  @param $images_dir           the images dir on the server
     *  @return array $ret           array containing all the images file names
    **/
    function getImageFiles($images_dir) {

        $ret = $this->get_files($images_dir);

        return $ret;
    }

    // **********************************************************************
    /**
     *  Prepare the gallery HTML
     *  @param array $images                        Images array [file_path, short_desc, long_desc]
     *  @param array $bootstrapDeviceImageWidth     array that contain the sizes of the images
     *                                              for the four kind of bootrap devices classes ()
     *                                              xs (phones), sm (tablets), md (desktops), and lg (larger desktops)
     *  @param ****array $desired_width     width of the thumbnail
     *  @return string $ret             the HTML to print on screen
    **/
    function prepareGallery($images) {

        // Animate item on hover
            $itemClass = "animated";

        // Create Grid—A—Licious grid (id=devices) and print images
            $ret = "<div class='gallery'>";

                foreach ($images as $k => $image) {

                    // Get item link
                        $imageLink = ($image['video_link'] == null) ? $image['file_path'] : $image['video_link'];
                        $videoPlayIcon = ($image['video_link'] == null) ? "" : "<i class='far fa-play-circle'></i>";


                    $ret .= "<div class='item ".$itemClass."'>";
                        $ret .= "<a href='".$imageLink."' data-fancybox='images' data-caption='".$image['description']."'>";
                            $ret .= "<img src='".asset($image['thumb_path'])."' />";
                            $ret .= $videoPlayIcon;
                        $ret .= "</a>";
                    $ret .= "</div>";
                }

            $ret .= "</div>";

        return $ret;
    }

    // **********************************************************************
    /**
     *  Returns files from dir
     *  @param string $images_dir                 The images directory
     *  @param array $exts     the file types (actually doesn't work the thumb with png, it's to study why)
     *  @return array $files             the files array
    **/

    function get_files($images_dir,$exts = array('jpg')) {
        $files = array();
        
        if($handle = opendir($images_dir)) {
            while(false !== ($file = readdir($handle))) {
            $extension = strtolower($this->get_file_extension($file));
                if($extension && in_array($extension,$exts)) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        
        return $files;
    }

   // **********************************************************************

    /**
     *  Returns a file's extension
     *  @param string $file_name        the file name
     *  @return string                  the extension
    **/

    function get_file_extension($file_name) {
        return substr(strrchr($file_name,'.'),1);
    }

   // **********************************************************************
    /**
     *  Turn array of the metches after preg_match_all function (taken from - https://secure.php.net/manual/en/function.preg-match-all.php)
     *  @param array $file_name        the file name
     *  @return array $ret             the extension
    **/

    function turn_array($m) {
        for ($z = 0;$z < count($m);$z++)
        {
            for ($x = 0;$x < count($m[$z]);$x++)
            {
                $ret[$x][$z] = $m[$z][$x];
            }
        }
        return $ret;
    }


    // **********************************************************************
    /**
     *  Return the post body with the gallery HTML instead of the found snippet
     *  @param array $file_name        the file name
     *  @return array $ret             the extension
    **/
    public function getGallery($postBody, $storagePath, $publicPath) {

        // Find plugin occurrences
            $ptn = '/{# +gallery +(src|width|height)=\[(.*)\] +(src|width|height)=\[(.*)\] +(src|width|height)=\[(.*)\] +#}/';

            if(preg_match_all($ptn,$postBody,$matches)){

                // Trasform the matches array in a way that can be used
                    $matches = $this->turn_array($matches);

                    foreach ($matches as $key => $single_gallery_matches) {

                        // Get plugin parameters array
                            $parameters = $this->getParameters($single_gallery_matches, $storagePath, $publicPath);
                            
                        if(is_dir($parameters['images_dir'])){
                            // Get images file name array
                                $image_files = $this->getImageFiles($parameters['images_dir']);
                                //sort($image_files,SORT_STRING);

                                if (!empty($image_files)){
                                    // Get images data from excel
                                        //$image_data = $this->getImgDataFromExcel($parameters['images_dir']);
                                        $image_data = null;
                                    // Generate thumbnails files
                                        $this->generateThumbs($parameters['images_dir'], $parameters['thumbs_dir'], $parameters['thumbs_size'], $image_files);

                                    // Create Images array [file_path, short_desc, long_desc]
                                        $images = $this->createImagesArray($image_files, $image_data, $parameters['gallery_url']);

                                    // Prepare Gallery HTML
                                        $galleryHtml = $this->prepareGallery($images);
                                }
                                else{
                                    $galleryHtml = "<div class='alert alert-warning' role='alert'>The directory specified exist but it doesn't contain images</div>";
                                }
                        }
                        else{
                            $galleryHtml = "<div class='alert alert-warning' role='alert'>Image directory not found</div>";
                        }

                        // Replace the TOKEN found in the article with the generatd gallery HTML
                            $postBody = str_replace($parameters['token'], $galleryHtml, $postBody);
                    }
            }
            return $postBody;
    }
}
