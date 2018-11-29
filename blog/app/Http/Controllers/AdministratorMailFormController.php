<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorMailFormController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactAdmin()
    {
        //dd("ciao");

        return view('administratorMailForms.contactForm');

        /*$backgroundImages = BackgroundImage::latest()->paginate(5);



        return view('backgroundImages.index',compact('backgroundImages'))
            ->with('i', (request()->input('page', 1) - 1) * 5);*/
    }



}
