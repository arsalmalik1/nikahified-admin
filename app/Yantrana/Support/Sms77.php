<?php

namespace Tzsk\Sms\Drivers;

use Sms77\Api\Client;
use Sms77\Api\Params\SmsParams;
use Tzsk\Sms\Contracts\Driver;

class Sms77Driver extends Driver
{
    protected Client $client;

    private string $sourceIdentifier = 'Laravel-SMS-Gateway';

    protected function boot(): void
    {
        $this->client = new Client(getStoreSettings('sms_sms77_apiKey'), $this->sourceIdentifier);
    }

    public function asFlash(bool $flash = true): self
    {
        $this->settings['flash'] = getStoreSettings('sms_sms77_flash');

        return $this;
    }

    public function send()
    {
        /** @var \Illuminate\Support\Collection $response */
        $response = collect();
        $params = (new SmsParams)
            ->setFlash(getStoreSettings('sms_sms77_flash'))
            ->setFrom(getStoreSettings('sms_sms77_from'))
            ->setText($this->body);

        foreach ($this->recipients as $recipient) {
            $result = $this->client->smsJson($params->setTo($recipient));

            $response->put($recipient, $result);
        }

        return (count($this->recipients) == 1) ? $response->first() : $response;
    }
}
