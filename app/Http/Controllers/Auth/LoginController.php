<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MemberUser;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override the validateLogin method to flash the form type
    protected function validateLogin(Request $request)
    {
        // Flash the form type (membership or mykad) into session
        session()->flash('form', $request->input('form_type'));

        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        // if (auth()->user()->ml_priv == "CompanyAdmin") {
        //     return '/bulletin';
        // } else {
            return '/choose-company';
        // }


        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    protected function username()
    {
        return 'username';
    }

    public function viewLogin()
    {
        if (Auth::check()) {
            return view('backend.home');
        }

        return view('auth.login');
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->ml_status) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive.');
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function attemptLogin(Request $request)
    {
        // $user = User::where($this->username(), $request->input($this->username()))->first();
        $user = MemberUser::where('ml_username', $request->input($this->username()))->first();
        // dd($user);

        if ($user) {
            $request->session()->flush();
            // Check if the user has a salt field (legacy user)
            if ($user->ml_salt) {
                // Old password verification using sha512 + salt
                $hashedPassword = hash('sha512', $request->input('password') . $user->ml_salt);

                if ($hashedPassword === $user->ml_pwd) {

                    // Log the user in manually
                    // Auth::login($user);

                    // dd($user);
                    \Log::info('User logged in manually', ['user_id' => $user->ml_id]);
                    $this->guard()->login($user);
                    // dd($user);

                    // Optionally rehash the password with bcrypt and remove the salt
                    // $this->rehashPassword($user, $request->input('password'));

                    return true;
                }
            } else {
                // Use Laravel's default Hash::check if no salt is present
                if (Hash::check($request->input('password'), $user->ml_pwd)) {
                    return $this->guard()->login($user);
                }
            }
        }

        return false;
    }

    /**
     * Rehash the user's password using Laravel's bcrypt and remove the salt.
     *
     * @param User $user
     * @param string $password
     */
    protected function rehashPassword(MemberUser $user, $password)
    {
        $user->ml_pwd = Hash::make($password); // Rehash the password with bcrypt
        $user->ml_salt = null; // Remove the salt
        $user->save(); // Save the updated user record
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function forgotpwd(Request $request)
    {
        if($request->form_type_reset == "membership") {
            $request->validate(['email' => 'required|email|exists:member_users,ml_emailadd', 'membershipno' => 'required']);
        } else if($request->form_type_reset == "representative"){
            $request->validate(['email' => 'required|email|exists:member_users,ml_emailadd', 'mykadno' => 'required']);
        } else {
            $request->validate(['email' => 'required|email|exists:member_users,ml_emailadd']);
        }

        if($request->form_type_reset == "membership"){
            $ml_username = $request->membershipno;
            $errormsg = "Invalid membership number or email";
        } else {
            $ml_username = $request->mykadno;
            $errormsg = "Invalid mykad number or email";
        }
        $checkUser = MemberUser::where('ml_username', $ml_username)->where('ml_emailadd', $request->email)->first();

        // if(!$checkUser){
        //     return response()->json(['status' => 'error', 'message' => $errormsg], 400);
        // }

        // // Generate the password reset token
        // $token = app('auth.password.broker')->createToken($checkUser);
        // // $token = Password::broker('members')->createToken($checkUser);

        // Mail::to($request->emailadd)->send(new ResetPasswordMail($token, $request->emailadd));
        // dd($checkUser);

        // $sendsPasswordResetEmails = new SendsPasswordResetEmails();
        // $sendsPasswordResetEmails->sendResetLinkEmail($request->email);

        // Send the password reset link

        $request->request->add(['ml_emailadd' => $request->email]);
        // dd($request);

        $status = Password::broker('member_users')->sendResetLink(
            $request->only('ml_emailadd')
            // ['email' => $request->input('ml_emailadd')]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success', 'message' => __($status)]);
        }

        return response()->json(['status' => 'error', 'message' => __($status)], 400);
    }
}