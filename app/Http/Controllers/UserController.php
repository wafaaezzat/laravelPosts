<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(){
        return view('users.register');
    }
    public function store (Request $request ){
        $formFields=$request->validate([
           'name'=>['required','min:3'], 
           'email'=>['required','email',Rule::unique('users','email')], 
           'password'=>['required','confirmed','min:6']
        ]); 

        //hash password
        $formFields['password']=bcrypt($formFields['password']);

        $user=User::create($formFields);
        auth()->login($user);
return response('user created and logged in');
           
           
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response('you have been logged out');
    }
      
        
    public function login(Request $request){
        return response($request);
    }

    public function authenticate(Request $request){
        $formFields=$request->validate([
            'email'=>['required','email'], 
            'password'=>'required'
         ]); 

        if(auth()->attempt($formFields)){
        $user = Auth::user();
        auth()->login($user);
            return response('You are now logged in!');
        } 
        return response()->json(['email'=>'invalid credentials'])->onlyInput('email');

    }
  
}
