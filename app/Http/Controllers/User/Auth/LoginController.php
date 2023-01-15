<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    public function showLoginForm(){
       
        
        return view('user.auth.login'); 
    }

    public function login(Request $request){
        $request->validate([
            'email'     => 'required|exists:customers|max:255',
            'password'  => 'required|min:6|max:255',
                
        ]);
        $credentials  = $request->only('email', 'password');
        if (Auth::guard('customer')->attempt($credentials)) {
            $cust = Customer::find(Auth::guard('customer')->id());
            return redirect()->route('client.dashboard');
        }
    }


    public function logout()
    {
        
        request()->session()->flush();
        Auth::guard('customer')->logout();
        
        return redirect()->route('home')->with('error','logout Successfully');
    }

    public function index(){
        dd('monim');
    }
}
