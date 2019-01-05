<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Country;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Notifications\UserRegisteredSuccessfully;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserActivation;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'description' => 'required|string',
            'accept_terms' => 'accepted',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country_id' => $data['country_id'],
            'description' => $data['description'],
            'accept_terms' => 'accepted'
        ]);
    }

    /**
     * Show the application registration form. - OVERRIDE to default function
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $countries = Country::pluck('name', 'id');
        return view('auth.register', compact('countries'));
    }

    /**
     * Register new account. - OVERRIDE to default function
     *
     * @param Request $request
     * @return User
     */
    protected function register(Request $request)
    {
        /** @var User $user */
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        try {
            $validatedData['password'] = bcrypt(array_get($validatedData, 'password'));
            $validatedData['activation_code'] = str_random(30).time();
            $validatedData['country_id'] = $request->country_id;
            $validatedData['description'] = $request->description;
            $validatedData['accept_terms'] = ($request->accept_terms = "on") ? 1 : 0;

            // Create user
                $user = app(User::class)->create($validatedData);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect()->back()->with('message', 'Unable to create new user.');
        }
        // this was the bugged version that send the activation button link to the user
            //$user->notify(new UserRegisteredSuccessfully($user));

            $countries = Country::pluck('name', 'id');

            $mailDatas['subject'] = "New user registration";

            $mailDatas['name'] = $request->name;
            $mailDatas['email'] = $request->email;
            $mailDatas['country'] = $countries[$request->country_id];
            $mailDatas['description'] = $request->description;
            $mailDatas['activation_code'] = $validatedData['activation_code'];


            Mail::to(env('ADMIN_MAIL'))->send(new UserActivation($mailDatas));
            // aaaaaaa - here send the email

        return redirect()->back()->with('message', __('auth.successfully_registered'));
    }


    /**
     * Activate the user with given activation code.
     * @param string $activationCode
     * @return string
     */
    public function activateUser(string $activationCode)
    {
        try {
            $user = app(User::class)->where('activation_code', $activationCode)->first();
            if (!$user) {
                return "The code does not exist for any user in our system.";
            }
            $user->status = 1;
            $user->activation_code = null;
            $user->save();
            auth()->login($user);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return "Whoops! something went wrong.";
        }
        return redirect()->to('/')->with('message', 'User succesfuly activated');
    }

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
         //Mail::to($report['emailTo'])->send(new ContactAdministrator($report));
         Mail::to($report['emailTo'])->send(new UserActivation($report));

         return redirect()->route('forms.contact-admin-thankyou');

     }


}
