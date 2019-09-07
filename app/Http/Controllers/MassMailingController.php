<?php

namespace App\Http\Controllers;

use App\Mail\MassMailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;

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
                'message' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $report = [];

        $report['senderEmail'] = 'admin@globalcicalendar.com';
        $report['senderName'] = 'CI Global Calendar - Administrator';
        $report['subject'] = 'Message from the contact form';

        $report['name'] = 'CI Global Calendar - Administrator';
        $report['email'] = env('ADMIN_MAIL');
        $report['message'] = $request->message;
        
        $users = User::select('id', 'name', 'email')
                        ->get();
        
        foreach ($users as $key => $user) {
            $report['emailTo'] = $user->email;
            Mail::to('davide.casiraghi@gmail.com')->send(new MassMailing($report));
        }

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
        return view('emails.massMailing.mass-mailing-sent');
    }
}
