<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MemberToken;
use App\Models\MemberUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $membertoken = MemberToken::where('mt_token', $request->input('token'))->first();
        if($membertoken) {
            $user = MemberUser::find($membertoken->mt_uid);
            if($user) {
                $newSalt = Hash::make(uniqid(openssl_random_pseudo_bytes(16), TRUE));

                $newPasswordHash = hash('sha512', $request->input('password') . $newSalt);

                $user->ml_pwd = $newPasswordHash;
                $user->ml_salt = $newSalt;
                $user->save();

                return redirect(route('login'));
            }
        }
        $response = '';

        $this->sendResetFailedResponse($request, $response);
    }
}
