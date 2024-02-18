<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/';

    protected $mobile;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Logout, Clear Session, and Return.
     *
     * @return void
     */
    public function logout()
    {
        // $user = Auth::user();
        // Log::info('User Logged Out. ', [$user]);
        Auth::logout();
        Session::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'mobile'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('mobile'), FILTER_VALIDATE_EMAIL )
            ? 'email'
            : 'mobile';

        $request->merge([
            $login_type => $request->input('mobile')
        ]);
        
        $mobileNumber = '0' . $request->input('mobile');

        // Check client registration validated or not. Do not allow to login if not validated
        //$userActive = User::where('mobile',$request->input('mobile'))->where('status','1')->first();
        $userActive = User::where('mobile',$request->input('mobile'))->orWhere('mobile',$mobileNumber)->orWhere('mobile',ltrim($request->input('mobile'), '0'))->where('status','1')->first();
        //echo "<pre>";print_r($userActive);echo "</pre>";die();
        if(empty($userActive)){
            return redirect()->back()
            ->withInput()
            ->withErrors([
                'mobile' => 'This account is not verified. Please verify your account.',
            ]);
        }else{
            //if (Auth::attempt($request->only($login_type, 'password'))) {
            if(!empty($userActive) && !empty(Hash::check($request->password, $userActive->password))) {
                Auth::login($userActive);
                //return redirect()->intended($this->redirectPath());
            }

            return redirect()->back()
            ->withInput()
            ->withErrors([
                'mobile' => 'These credentials(Mobile Number/Email or password) do not match our records.',
            ]);
        }        
    }
}