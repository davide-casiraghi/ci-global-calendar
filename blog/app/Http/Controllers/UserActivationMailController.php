<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserActivation;

use Illuminate\Http\Request;

class UserActivationMailControllerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function contactAdmin()
    {
        return view('administratorMailForms.contactForm');
    }*/

    // **********************************************************************

    /**
     * Send the User activation mail to the Admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to route
     */
    public function userActivationMailSend(Request $request){
        $report = array();

        $report['senderEmail'] = "noreply@globalcicalendar.com";
        $report['senderName'] = "Anonymus User";
        $report['subject'] = "New user registration";
        $report['emailTo'] = env('ADMIN_MAIL');

        $report['name'] = $request->name;
        $report['email'] = $request->email;
        $report['message'] = $request->message;

         //Mail::to($request->user())->send(new ReportMisuse($report));
         //Mail::to($report['emailTo'])->send(new ContactForm($report));
         Mail::to($report['emailTo'])->send(new UserActivation($report));
         
         return redirect()->route('forms.contact-admin-thankyou');

     }

     // **********************************************************************

     /**
      * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route)
      *
      * @param  \App\Event  $event
      * @return view
      */
     public function contactAdminThankyou(){

         return view('emails.contactform-thankyou');
     }



}
