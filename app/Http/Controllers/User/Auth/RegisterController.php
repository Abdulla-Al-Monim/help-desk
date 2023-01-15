<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
class RegisterController extends Controller
{
    public function showRegistrationForm(){
        return view('user.auth.register');
    }
    public function register(Request $request){
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        $user =  Customer::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'username' => $request->input('firstname') .' '. $request->input('lastname'),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType' => 'Customer',
            'status' => '1',
            'image' => null,
            
        ]);

        return redirect()->route('auth.login')->with('success', 'Register Successfully');
    }
}
