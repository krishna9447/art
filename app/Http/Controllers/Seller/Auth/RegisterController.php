<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

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
            'password' => bcrypt($data['password']),
            'email_token' => bin2hex(openssl_random_pseudo_bytes(30)),
        ]);
    }

    public function signup()
    {
        return View::make('auth/register');

    }
    
    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

       // event(new Registered($user = $this->create($request->all())));
       $user = $this->create($request->all());

        $email = new EmailVerification($user);

        Mail::to($user->email)->send($email);

        return view('auth.verification');

    }
     /**
    * Handle a email verification request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */

    public function verify($token)
    {
        if ( ! $token)
        {
            return  redirect('login')->with('flash-error','Email Verification Token not provided!');
        }


        $user = User::where('email_token',$token)->first();


        if ( ! $user)
        {
            return  redirect('login')->with('flash-error','Invalid Email Verification Token!');
        }

        $user->verified = 1;

        if ($user->save()) {

            return view('auth.emailconfirm',['user'=>$user]);

        }

    }


}
 