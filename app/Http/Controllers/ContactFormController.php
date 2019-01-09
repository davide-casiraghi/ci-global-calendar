<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

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
        
        switch ($request->recipient) {
            case 'administrator':
                $report['emailTo'] = env('ADMIN_MAIL');
                break;
            case 'project-manager':
                $report['emailTo'] = env('PROJECTMANAGER_MAIL');
                break;
            case 'webmaster':
                $report['emailTo'] = env('WEBMASTER_MAIL');
                break;
            case 'test':
                $report['emailTo'] = env('TEST_MAIL');
                break;
        }
        
        $report['senderEmail'] = "noreply@globalcicalendar.com";
        $report['senderName'] = "Anonymus User";
        $report['subject'] = "Message from the contact form";
        
        $report['name'] = $request->name;
        $report['email'] = $request->email;
        $report['message'] = $request->message;

         //Mail::to($request->user())->send(new ReportMisuse($report));
         Mail::to("davide.casiraghi@gmail.com")->send(new ContactForm($report));
        
         return redirect()->route('forms.contactform-thankyou');

     }

     // **********************************************************************
     /**
      * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route)
      *
      * @param  \App\Event  $event
      * @return view
      */
     public function contactFormThankyou(){
         return view('emails.contact.contactform-sent');
     }



}
