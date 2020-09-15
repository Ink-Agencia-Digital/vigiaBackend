<?php

namespace App\Http\Controllers\Alert;

use App\Complex;
use App\Http\Controllers\Api\ApiController;
use App\Traits\AlerNotification;
use Illuminate\Http\Request;

class AlertController extends ApiController
{
    use AlerNotification;

    public function sendAlert(Request $request)
    {
        $complex = Complex::findOrFail($request->complex_id);
    }
}
