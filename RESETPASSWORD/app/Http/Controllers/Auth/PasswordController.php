<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;  
use Carbon\Carbon; 
use Illuminate\Support\Facades\Hash; 
use App\Models\User; 
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;


class PasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view ('auth.forgetPassword'); 
    }    
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|string|exists:users',
        ]);
        $token = Str::random(128); 

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        // send email to user with the token
        Mail::send('emails.forgotPassword', ['token' => $token], function($message) use ($request){
            $message->to($request->email); 
            $message->subject('Reset Password'); 
        });
        return back()->with('message','We have emailed your password reset link!'); 
    }
    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token'=>$token]);  
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([ 
            'email'=> 'required|email|exists:users',
            'password'=> 'required|string|confirmed',
            'password_confirmation' => 'required'
        ]);
        $updatePassword = DB::table('password_resets')
                          ->where([
                            'email'=> $request->email,
                            'token'=> $request->token
                          ])
                          ->first(); 
                          if(!$updatePassword)
                          {
                            return back()->withInput()->withErrors(['error' => 'Invalid Token']);
                          }
                          $user = User::where('email', $request->email)
                          ->update(['password'=> Hash::make($request->password)]);
                            DB::table('password_resets')->where(['email'=>$request->email])->delete();
                            return redirect('/login')->with('message', 'Your password has been changed'); 
    }
}
