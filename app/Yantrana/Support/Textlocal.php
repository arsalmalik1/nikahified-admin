<?php

namespace Tzsk\Sms\Drivers;

use GuzzleHttp\Client;
use Tzsk\Sms\Contracts\Driver;

class TextlocalDriver extends Driver
{
    protected Client $client;

    protected function boot(): void
    {
        $this->client = new Client();
    }

    public function send()
    {
        /** @var \Illuminate\Support\Collection $response */
        $response = collect();

        foreach ($this->recipients as $recipient) {
            $response->put(
                $recipient,
                $this->client->request('POST', getStoreSettings('sms_textlocal_url'), $this->payload($recipient))
            );
        }

        return (count($this->recipients) == 1) ? $response->first() : $response;
    }

    public function payload($recipient): array
    {
        return [
            'form_params' => [
                'username' => getStoreSettings('sms_textlocal_username'),
                'hash' => getStoreSettings('sms_textlocal_hash'),
                'numbers' => $recipient,
                'sender' => urlencode(getStoreSettings('sms_textlocal_from')),
                'message' => $this->body,
            ],
        ];
    }
}
