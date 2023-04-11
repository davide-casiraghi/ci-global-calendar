<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Validator;

class ContactFormController extends Controller
{
    /**
     * Display the contact form. - Eg. /contactForm/administrator.
     * $recipient can be: "administrator" | "project-manager" | "webmaster" | "test".
     *
     * @param  string  $recipient
     * @return \Illuminate\View\View
     */
    public function contactForm($recipient)
    {
        return view('contactMailForms.contactForm')
            ->with('recipient', $recipient);
    }

    // **********************************************************************

    /**
     * Send the Contact Admin mail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactFormSend(Request $request)
    {
        // Validate form datas
        /*$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
            //'g-recaptcha-response' => 'required|captcha',
            'recaptcha_sum_1' => [
                'required',
                Rule::in([$request->random_number_1 + $request->random_number_2]),
            ],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }*/

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
            //'g-recaptcha-response' => 'required|captcha',
            'recaptcha_sum_1' => [
                'required',
                Rule::in([$request->random_number_1 + $request->random_number_2]),
            ],
        ];

        $messages = [
            'recaptcha_sum_1.required' => 'Please solve the sum',
            'recaptcha_sum_1.in' => 'Your answer is not correct',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
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

        Mail::send(new ContactForm($report));

        return redirect()->route('forms.contactform-thankyou');
    }

    // **********************************************************************

    /**
     * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route).
     *
     * @return \Illuminate\View\View
     */
    public function contactFormThankyou()
    {
        return view('emails.contact.contactform-sent');
    }
}
