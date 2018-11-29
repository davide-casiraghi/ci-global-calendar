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
        return view('administratorMailForms.contactForm');
    }

    // **********************************************************************

    /**
     * Send the Contact Admin mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to route
     */
    public function contactAdminSend(Request $request){
        $report = array();

        $report['senderEmail'] = "noreply@globalcicalendar.com";
        $report['senderName'] = "Anonymus User";
        $report['subject'] = "Report misuse form";
        $report['emailTo'] = "davide.casiraghi@gmail.com";

        $report['name'] = $request->name;
        $report['email'] = $request->email;
        $report['message'] = $request->message;

         //Mail::to($request->user())->send(new ReportMisuse($report));
         Mail::to("davide.casiraghi@gmail.com")->send(new ContactForm($report));

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

         return view('emails.report-thankyou');
     }



}
