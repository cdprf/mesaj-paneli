<?php

namespace hkntrksy\MesajPaneli\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class SmsChannel
{

    protected $http;
    protected $url;

    public function __construct(Client $http)
    {
        $this->http = $http;
        $this->url  = 'http://api.mesajpaneli.com/json_api/';
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {

        if (!method_exists($notification, 'toSms')) {
            throw new RuntimeException('Notification is missing toSms method.');
        }

        $data = $notification->toSms($notifiable);

        $this->sendSms($notifiable, $notification, $data);
    }

    private function sendSms($notifiable,Notification $notification,$data)
    {

        $smsData['msgData'][] = $this->buildMessage($data);

        $smsData['user'] = [
            'name' => config('mesaj-paneli.username'),
            'pass' => config('mesaj-paneli.password')
        ];

        $smsData['tr']          = true;
        $smsData['start']       = time();
        $smsData['msgBaslik']   = config('mesaj-paneli.title');

        $this->http->request('POST', $this->url, [
            'form_params' => [
                'data'  => base64_encode(json_encode($smsData))
            ]
        ]);

    }

    protected function buildMessage($data)
    {
        return [
            'tel' => $data->to,
            'msg' => $data->message
        ];
    }



}
