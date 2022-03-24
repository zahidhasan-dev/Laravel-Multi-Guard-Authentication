<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }



    public function showAdminLoginForm()
    {
        return view('admin.login');
    }


    public function adminLogin()
    {

        validator(request()->all(), [
            'email'=> ['required','email'],
            'password' => ['required'],
        ])->validate();

        
        if(Auth::guard('admin')->attempt(request()->only(['email','password']),request()->filled('remember')))
        {
            return redirect()->route('admin.home');
        }

        return redirect()->back()->withErrors(['email'=>'Invalid Credentials!']);
    }



    public function logout()
    {
        $this->guard('admin')->logout();

        return redirect()->route('admin.login');
    }


    public function guard()
    {
        return Auth::guard('admin');
    }



}
