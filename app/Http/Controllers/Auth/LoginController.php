<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\MemberToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MemberUser;
use Illuminate\Support\Facades\Mail;
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

        return '/choose-company';

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
        if ($user != null && !$user->ml_status) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive.');
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function attemptLogin(Request $request)
    {
        $user = MemberUser::where('ml_username', $request->input($this->username()))->first();
        $ml_priv = ($request->form_type == "representative") ? "OfficeRep" : "CompanyAdmin";

        if ($user && $ml_priv == $user->ml_priv) {
            $request->session()->flush();
            // Check if the user has a salt field (legacy user)
            if ($user->ml_salt) {
                // Old password verification using sha512 + salt
                $hashedPassword = hash('sha512', $request->input('password') . $user->ml_salt);

                if ($hashedPassword === $user->ml_pwd) {
                    $this->guard()->login($user);
                    return true;
                }
            } else {
                // Use Laravel's default Hash::check if no salt is present
                if (Hash::check($request->input('password'), $user->ml_pwd)) {
                    $this->guard()->login($user);
                    return true;
                }
            }

            // If we reach here, the password is incorrect
            throw ValidationException::withMessages([
                'password' => [trans('auth.password')],
            ]);
        }

        // If we reach here, the username is incorrect
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
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
        if ($request->form_type_reset == "membership") {
            $request->validate(['email' => 'required|email|exists:member_users,ml_emailadd', 'membershipno' => 'required']);
        } else if ($request->form_type_reset == "representative") {
            $request->validate(['email' => 'required|email|exists:member_users,ml_emailadd', 'mykadno' => 'required']);
        } else {
            $request->validate(['email' => 'required|email|exists:member_users,ml_emailadd']);
        }

        if ($request->form_type_reset == "membership") {
            $ml_username = $request->membershipno;
            $errormsg = "Invalid membership number or email";
        } else {
            $ml_username = $request->mykadno;
            $errormsg = "Invalid mykad number or email";
        }
        $checkUser = MemberUser::where('ml_username', $ml_username)->where('ml_emailadd', $request->email)->first();

        if(!$checkUser){
            return response()->json(['status' => 'error', 'message' => 'User not found with the provided email and username.'], 400);
        }

        // Generate the password reset token
        $token = app('auth.password.broker')->createToken($checkUser);

        $request->request->add(['ml_emailadd' => $request->email]);

        MemberToken::create([
            'mt_uid' => $checkUser->ml_id,
            'mt_token' => $token,
            'mt_created_at' => date('Y-m-d H:i:s'),
        ]);
        if (Mail::to($request->ml_emailadd)->send(new ResetPasswordMail($token, $request->ml_emailadd))) {
            return response()->json(['status' => 'success', 'message' => 'Reset password link send to your mail']);
        }
        return response()->json(['status' => 'error', 'message' => 'Failed to send reset password link send to your mail'], 400);

    }
}