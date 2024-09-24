<?php
// app/Notifications/Channels/ZiperWhatsAppChannel.php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class ZiperWhatsAppChannel
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toZiperWhatsApp')) {
            throw new \Exception('Notification is missing toZiperWhatsApp method.');
        }

        $message = $notification->toZiperWhatsApp($notifiable);
        $phoneNumber = str_replace('+' , '' , $notifiable->phone_number);

        $url = 'https://ziper.io/api/send.php';
        $queryParams = [
            'number' => $phoneNumber,
            'type' => 'text',
            'message' => $message,
            'instance_id' => config('services.ziper.instance_id'),
            'access_token' => config('services.ziper.api_key'),
        ];

        $response = $this->client->request('POST', $url, [
            'query' => $queryParams,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response;
    }
}
