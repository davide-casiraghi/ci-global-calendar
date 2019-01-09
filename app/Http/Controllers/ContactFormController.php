<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactAdministrator;

use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    
    /**
     * Display the contact form. 
     * eg. /contactForm/administrator
     * @param  string  $recipient can be [administrator, project-manager, webmaster, test]
     * @return \Illuminate\Http\Response
     */
    public function contactForm($recipient)
    {        
        return view('contactMailForms.contactForm')
            ->with('recipient',$recipient);
    }

    // **********************************************************************

    /**
     * Send the Contact Admin mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to route
     */
    public function contactFormSend(Request $request){
        $report = array();

        $report['senderEmail'] = "noreply@globalcicalendar.com";
        $report['senderName'] = "Anonymus User";
        $report['subject'] = "Message from the contact form";
        $report['emailTo'] = env('ADMIN_MAIL');

        $report['name'] = $request->name;
        $report['email'] = $request->email;
        $report['message'] = $request->message;

         //Mail::to($request->user())->send(new ReportMisuse($report));
         Mail::to("davide.casiraghi@gmail.com")->send(new ContactAdministrator($report));

         return redirect()->route('forms.contact-admin-thankyou');

     }

     // **********************************************************************

     /**
      * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route)
      *
      * @param  \App\Event  $event
      * @return view
      */
     public function contactFormThankyou(){

         return view('emails.contact.administrator-sent');
     }



}
