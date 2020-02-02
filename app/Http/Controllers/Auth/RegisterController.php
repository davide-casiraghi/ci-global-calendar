<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserActivation;
use App\Mail\UserActivationConfirmation;
use App\User;
use DavideCasiraghi\LaravelEventsCalendar\Models\Country;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;

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

    // **********************************************************************

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('activateUserFromBackend');
    }

    // **********************************************************************

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
            'accept_terms' => 'accepted',
        ]);
    }

    // **********************************************************************

    /**
     * Show the application registration form. - OVERRIDE to default function.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $countries = Country::getCountries();

        return view('auth.register', compact('countries'));
    }

    // **********************************************************************

    /**
     * Register new account. - OVERRIDE to default function.
     *
     * @param Request $request
     * @return User
     */
    protected function register(Request $request)
    {        
        /** @var User $user */
            
        // Validate form datas
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'country_id' => 'required|integer',
            'description' => 'required',
            'accept_terms' =>'required',
            //'g-recaptcha-response' => 'required|captcha',
            'recaptcha_sum_1' => [
                'required',
                Rule::in([$request->random_number_1+$request->random_number_2]),
            ],
        ];
        
        $messages = [
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            $validatedData['password'] = bcrypt(Arr::get($validatedData, 'password'));
            $validatedData['activation_code'] = Str::random(30).time();
            $validatedData['country_id'] = $request->country_id;
            $validatedData['description'] = $request->description;
            $validatedData['accept_terms'] = ($request->accept_terms == 'on') ? 1 : 0;

            // Create user
            $user = app(User::class)->create($validatedData);
        } catch (\Exception $exception) {
            logger()->error($exception);

            return redirect()->back()->with('message', 'Unable to create new user.');
        }

        $countries = Country::getCountries();

        $mailDatas = [];
        $mailDatas['subject'] = 'New user registration';
        $mailDatas['name'] = $request->name;
        $mailDatas['email'] = $request->email;
        $mailDatas['country'] = $countries[$request->country_id];
        $mailDatas['description'] = $request->description;
        $mailDatas['activation_code'] = $validatedData['activation_code'];

        Mail::to(env('ADMIN_MAIL'))->send(new UserActivation($mailDatas));

        return redirect()->back()->with('message', __('auth.successfully_registered'));
    }

    // **********************************************************************

    /**
     * Activate the user with given activation code.
     * @param string $activationCode
     * @return string
     */
    public function activateUser(string $activationCode)
    {
        try {
            $user = app(User::class)->where('activation_code', $activationCode)->first();
            if (! $user) {
                return 'The code does not exist for any user in our system.';
            }
            $user->status = 1;
            $user->activation_code = null;
            $user->save();
            //auth()->login($user);

            // Send to the user the confirmation about the activation of the account
            $mailDatas = [];
            $mailDatas['senderEmail'] = 'noreply@globalcicalendar.com';
            $mailDatas['senderName'] = 'Global CI - Administrator';
            $mailDatas['subject'] = 'Activation of your Global CI account';
            $mailDatas['emailTo'] = $user->email;
            $mailDatas['name'] = $user->name;

            Mail::to($user->email)->send(new UserActivationConfirmation($mailDatas));
        } catch (\Exception $exception) {
            logger()->error($exception);

            return 'Whoops! something went wrong.';
        }

        return redirect()->to('/')->with('message', 'User succesfuly activated');
    }

    // **********************************************************************

    /**
     * Activate the user from the backend clicking on the Enable button in the user index view.
     * @param string $userId
     * @return string
     */
    public function activateUserFromBackend(string $userId)
    {
        try {
            $user = app(User::class)->where('id', $userId)->first();
            if (! $user) {
                return 'The code user id not exist for any user in our system.';
            }
            $user->status = 1;
            $user->save();

            // Send to the user the confirmation about the activation of the account
            $mailDatas = [];
            $mailDatas['senderEmail'] = 'noreply@globalcicalendar.com';
            $mailDatas['senderName'] = 'Global CI - Administrator';
            $mailDatas['subject'] = 'Activation of your Global CI account';
            $mailDatas['emailTo'] = $user->email;
            $mailDatas['name'] = $user->name;

            Mail::to($user->email)->send(new UserActivationConfirmation($mailDatas));
        } catch (\Exception $exception) {
            logger()->error($exception);

            return 'Whoops! something went wrong.';
        }

        return redirect()->to('/')->with('message', 'User succesfuly activated');
    }

    // **********************************************************************

    /**
     * Send the User activation mail to the Admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userActivationMailSend(Request $request)
    {
        $report = [];

        $report['senderEmail'] = 'noreply@globalcicalendar.com';
        $report['senderName'] = 'Anonymus User';
        $report['subject'] = 'New user registration';
        $report['emailTo'] = env('ADMIN_MAIL');

        $report['name'] = $request->name;
        $report['email'] = $request->email;
        $report['message'] = $request->message;

        Mail::to($report['emailTo'])->send(new UserActivation($report));

        return redirect()->route('forms.contactform-thankyou');
    }
}
