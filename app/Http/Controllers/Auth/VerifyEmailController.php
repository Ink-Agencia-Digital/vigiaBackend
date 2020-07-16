<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Mail\VerifyMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends ApiController
{
    public static function sendEmail(User $user)
    {
        Mail::to($user)->send(new VerifyMail($user));
    }

    public function verifyMail(Request $request)
    {
        $user =  User::where('email', Crypt::decryptString($request->token))->firstOrFail();
        $user->email_verified_at = Carbon::now();
        $user->saveOrFail();
        return $this->api_success(["message" => "Correo verificado"]);
    }
}
