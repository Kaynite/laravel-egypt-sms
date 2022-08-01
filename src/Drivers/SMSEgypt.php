<?php

namespace Kaynite\SMS\Drivers;

use Illuminate\Support\Facades\Http;
use Kaynite\SMS\Interfaces\SMSInterface;

class SMSEgypt extends SMSService implements SMSInterface
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
        ])->post("https://smssmartegypt.com/sms/api/");

        if ($res->failed()) {
            return false;
        }

        if ($res->object()->type != 'success') {
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
        return [
            'username'   => $this->config->username,
            'password'   => $this->config->passowrd,
            'sendername' => $this->config->sendername,
            'mobiles'    => $this->to,
            'message'    => $this->message,
        ];
    }
}
