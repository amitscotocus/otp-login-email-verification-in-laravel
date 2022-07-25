<?php

namespace App\Http\Controllers;

use App\User;
use App\Verifytoken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function useractivation(Request $request)
    {
        $verifycoursetoken = $request->token;
        $verifycoursetoken = Verifytoken::where('token', $verifycoursetoken)->first();
        if ($verifycoursetoken) {
            $verifycoursetoken->is_activated = 1;
            $verifycoursetoken->save();
            $user = User::where('email', $verifycoursetoken->email)->first();
            $user->is_activated = 1;
            $user->save();
            $getting_token = Verifytoken::where('token', $verifycoursetoken->token)->first();
            Log::info('getting token me kyaaa aa rha hai'.$getting_token);
            $getting_token->delete();

            return redirect('/home')->with('activated', 'Yout Account has been activated successfully');
        } else {
            return redirect('/verify-account')->with('incorrect', 'Your OTP is invalid please check your email OTP first');
        }
    }

    public function verifyAccount(Request $request)
    {
        return view('otp_verification');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $get_user = User::where('email', auth()->user()->email)->first();
        if ($get_user->is_activated == 1) {
            return view('home')->with('error','your account is not activated yet');
        } 
        else {
            return redirect('/verify-account');
        }
    }
}
