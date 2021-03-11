<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;


class EmailVerificationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Show the apply page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function apply(){
        return view('apply');
    }

    /**
     * Show the register page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register(){
        return view('register');
    }

    public function register_from_send(Request $request){
        if($request->name && $request->email && $request->password && $request->password_confirm){
            $rand = rand(1000, 9999);
            session()->put('email_code', $rand);

            return response()->json($rand, 200);
        }else{
            throw new Exception("Feild/s Missing!");
        }
    }

    public function submit_email_code(Request $request){
        if($request->email_code){
            if ($request->email_code == session()->get('email_code')){
                return response()->json('Email code matched and received', 200);
            }else{
                throw new Exception("Code does not match!");
            }
        }else{
            throw new Exception("Email verification code empty");
        }
    }
}