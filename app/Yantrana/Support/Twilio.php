<?php

namespace Tzsk\Sms\Drivers;

use Twilio\Rest\Client;
use Tzsk\Sms\Contracts\Driver;

class TwilioDriver extends Driver
{
    protected Client $client;

    protected function boot(): void
    {
        $this->client = new Client(getStoreSettings('sms_twilio_sid'), getStoreSettings('sms_twilio_token'));
    }

    public function send()
    {
        $response = collect();
        foreach ($this->recipients as $recipient) {
            /**
             * @psalm-suppress UndefinedMagicPropertyFetch
             */
            $result = $this->client->account->messages->create(
                $recipient,
                ['from' => getStoreSettings('sms_twilio_from'), 'body' => $this->body]
            );

            $response->put($recipient, $result);
        }

        return (count($this->recipients) == 1) ? $response->first() : $response;
    }
}
