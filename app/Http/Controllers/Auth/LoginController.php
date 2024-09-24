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

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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
        if (!$user->status) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive.');
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where($this->username(), $request->input($this->username()))->first();

        if ($user) {
            // Check if the user has a salt field (legacy user)
            if ($user->salt) {
                // Old password verification using sha512 + salt
                $hashedPassword = hash('sha512', $request->input('password') . $user->salt);

                if ($hashedPassword === $user->password) {
                    // Log the user in manually
                    Auth::login($user);

                    // Optionally rehash the password with bcrypt and remove the salt
                    $this->rehashPassword($user, $request->input('password'));

                    return true;
                }
            } else {
                // Use Laravel's default Hash::check if no salt is present
                if (Hash::check($request->input('password'), $user->password)) {
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
    protected function rehashPassword(User $user, $password)
    {
        $user->password = Hash::make($password); // Rehash the password with bcrypt
        $user->salt = null; // Remove the salt
        $user->save(); // Save the updated user record
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}