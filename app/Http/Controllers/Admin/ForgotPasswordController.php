<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    

    use SendsPasswordResetEmails;


    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showAdminLinkRequestForm()
    {
        return view('admin.passwords.email');
    }


    public function sendAdminResetLinkEmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }



    public function broker()
    {
        return Password::broker('admins');
    }

}
