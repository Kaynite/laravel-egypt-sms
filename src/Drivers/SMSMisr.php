<?php

namespace Kaynite\SMS\Drivers;

use Illuminate\Support\Facades\Http;
use Kaynite\SMS\Interfaces\SMSInterface;

class SMSMisr extends SMSService implements SMSInterface
{
    /**
     * Send the message.
     *
     * @return bool
     */
    public function send(): bool
    {
        $res = Http::withOptions([
            'query' => $this->query(),
        ])->post("https://smsmisr.com/api/webapi/");

        if ($res->failed()) {
            return false;
        }

        if ($res->object()->code != 1901) {
            return false;
        }

        return true;
    }

    /**
     * The query string data used in the request.
     *
     * @return array
     */
    public function query(): array
    {
        $data = [
            'Username' => $this->config->username,
            'password' => $this->config->passowrd,
            'sender'   => $this->config->sender,
            'language' => $this->language,
            'Mobile'   => $this->to,
            'message'  => $this->message,
        ];

        if ($this->until) {
            $data['DelayUntil'] = $this->until->format('Y-m-d-H-i');
        }

        return $data;
    }
}
