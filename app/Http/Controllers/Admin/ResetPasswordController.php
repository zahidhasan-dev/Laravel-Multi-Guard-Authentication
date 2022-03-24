<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;


    public function showAdminResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return view('admin.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    public function adminReset(Request $request)
    {

        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(

            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }

        );

        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);

    }


    public function broker()
    {
        return Password::broker('admins');
    }


    public function guard()
    {
        return Auth::guard('admin');
    }

}
