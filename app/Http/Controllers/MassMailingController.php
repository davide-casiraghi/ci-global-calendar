<?php

namespace App\Http\Controllers;

use App\Mail\MassMailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MassMailingController extends Controller
{
    /**
     * Display the contact form. - Eg. /MassMailing.
     *
     * @return \Illuminate\Http\Response
     */
    public function massMailing()
    {
        return view('massMailingForms.massMailing');
    }

    // **********************************************************************

    /**
     * Send the Contact Admin mail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function massMailingSend(Request $request)
    {

        // Validate form datas
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'message' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $report = [];

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

        $report['senderEmail'] = 'noreply@globalcicalendar.com';
        $report['senderName'] = 'Anonymus User';
        $report['subject'] = 'Message from the contact form';

        $report['name'] = $request->name;
        $report['email'] = $request->email;
        $report['message'] = $request->message;

        //Mail::to($request->user())->send(new ReportMisuse($report));
        Mail::to('davide.casiraghi@gmail.com')->send(new MassMailing($report));

        return redirect()->route('forms.massmailing-thankyou');
    }

    // **********************************************************************

    /**
     * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route).
     *
     * @return \Illuminate\Http\Response
     */
    public function massMailingThankyou()
    {
        return view('emails.contact.massmailing-sent');
    }
}
