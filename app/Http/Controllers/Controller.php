<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // **********************************************************************

    /**
     * Get the current logged user ID.
     * If user is admin or super admin return 0.
     *
     * @return int $ret
     */
    public function getLoggedUser()
    {
        $user = Auth::user();

        // This is needed to not get error in the queries with: ->when($loggedUser->id, function ($query, $loggedUserId) {
        if (! $user) {
            $user = new User();
            $user->name = null;
            $user->group = null;
        }

        $ret = $user;

        return $ret;
    }

    // **********************************************************************

    /**
     * Get the current logged user id.
     *
     * @return bool $ret - the current logged user id, if admin or super admin 0
     */
    public function getLoggedAuthorId()
    {
        $user = Auth::user();

        $ret = null;
        if ($user) {
            $ret = (! $user->isSuperAdmin() && ! $user->isAdmin()) ? $user->id : 0;
        }

        return $ret;
    }

    // **********************************************************************

    /**
     * Upload image on server.
     *
     * @param  $imageFile - the file to upload
     * @param  $imageName - the file name
     * @param  $imageSubdir - the subdir in /storage/app/public/images/..
     * @return void
     */
    public function uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth)
    {

        // Create dir if not exist (in /storage/app/public/images/..)
        if (! \Storage::disk('public')->has('images/'.$imageSubdir.'/')) {
            \Storage::disk('public')->makeDirectory('images/'.$imageSubdir.'/');
        }

        $destinationPath = 'app/public/images/'.$imageSubdir.'/';

        // Resize the image with Intervention - http://image.intervention.io/api/resize
        // -  resize and store the image to a width of 300 and constrain aspect ratio (auto height)
        // - save file as jpg with medium quality
        $image = \Image::make($imageFile->getRealPath())
                                ->resize($imageWidth, null,
                                    function ($constraint) {
                                        $constraint->aspectRatio();
                                    })
                                ->save(storage_path($destinationPath.$imageName), 75);

        // Create the thumb
        $image->resize($thumbWidth, null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    })
                ->save(storage_path($destinationPath.'thumb_'.$imageName), 75);
    }

    // **********************************************************************

    /**
     * Get the language name from language code.
     *
     * @param  string $languageCode
     * @return string
     */
    public function getSelectedLocaleName($languageCode)
    {
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        $ret = $countriesAvailableForTranslations[$languageCode]['name'];

        return $ret;
    }
}
