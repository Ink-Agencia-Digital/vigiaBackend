<?php

namespace App\Http\Controllers\Alert;

use App\Complex;
use App\Device;
use App\Http\Controllers\Api\ApiController;
use App\Traits\AlerNotification;
use App\User;
use Illuminate\Http\Request;

class AlertController extends ApiController
{
    use AlerNotification;

    public function sendAlert(Request $request)
    {
        $complex = Complex::findOrFail($request->complex_id);
        $user = User::findOrFail($request->user_id);
        $devices = Device::whereHas('user.complex_administrator', function ($query) use ($complex, $user) {
            return $query->where([['complexes.id', "=", $complex->id], ['users.id', "!=", $user->id]]);
        })->get();

        $tokens = [];

        $devices->each(function ($device) use (&$tokens) {
            array_push($tokens, $device->code);
        });

        $this->notificateEmployees($complex, $tokens, $request->lat, $request->lng);

        return $this->api_success(["message" => "Notificacion enviada"]);
    }
}
