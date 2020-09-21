<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;

/**
 * Notification Trait
 */
trait AlerNotification
{
    protected function notificateEmployees($complex, $tokens, $lat, $lng)
    {
        try {
            $messaging = app('firebase.messaging');
            $title = "Alerta de seguridad " . $complex->name;
            $body = "Se ha enviado una alerta de seguridad en";

            $config = AndroidConfig::fromArray([
                'ttl' => '3600s',
                'priority' => 'high',
            ]);
            $notification = Notification::fromArray([
                'title' => $title,
                'body' => $body,
                "click_action" => "FCM_PLUGIN_ACTIVITY",
                "icon" => "myicon",
                "sound" => "default",
            ]);
            $message = CloudMessage::new();
            $message = $message->withNotification($notification)
                ->withData([
                    "id" => "alert",
                    "lat" => $lat,
                    "lng" => $lng
                ])
                ->withAndroidConfig($config);;

            $messaging->sendMulticast($message, $tokens);
        } catch (NotFound $th) {
            Log::error($th);
        }
    }
}
