<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

/**
 * Notification Trait
 */
trait AlerNotification
{
    private function notificateEmployees($complex, $tokens, $lat, $lng)
    {
        try {
            $messaging = app('firebase.messaging');
            $title = "Alerta de seguridad " . $complex->name;
            $body = "Se ha enviado una alerta de seguridad en";

            $notification = Notification::fromArray([
                'title' => $title,
                'body' => $body,
            ]);
            $message = new CloudMessage();
            $message = $message->withNotification($notification)
                ->withData([
                    "id" => "alert",
                    "lat" => $lat,
                    "lng" => $lng
                ]);

            $messaging->sendMulticast($message, $tokens);
        } catch (NotFound $th) {
            Log::error($th);
        }
    }
}
