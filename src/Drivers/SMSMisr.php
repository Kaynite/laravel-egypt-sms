<?php

namespace Kaynite\SMS\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Kaynite\SMS\Interfaces\SMSInterface;

class SMSMisr implements SMSInterface
{
    /**
     * The number that will receive the message.
     *
     * @var string
     */
    protected $to;

    /**
     * The message that will be sent.
     *
     * @var [type]
     */
    protected $message;

    /**
     * The date and time the message will be sent at.
     *
     * @var [type]
     */
    protected $until;

    /**
     * The message language.
     *
     * @var int
     */
    protected $language = 1;

    /**
     * SMSMisr Service Configurations.
     * 
     * @var object
     */
    protected $config;

    /**
     * The class constructor.
     * 
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = (object) $config;
    }

    /**
     * Set the number(s) that will receive the message.
     *
     * @param array|string|int $number
     *
     * @return self
     */
    public function to(array|string|int $number): self
    {
        $this->to = $number;

        return $this;
    }

    /**
     * Set the message that will be sent.
     *
     * @param string $message
     *
     * @return self
     */
    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Delay sending the message until a specific datetime.
     *
     * @param Carbon $datetime
     *
     * @return self
     */
    public function delayUntil(Carbon $datetime): self
    {
        $this->until = $datetime;

        return $this;
    }

    /**
     * Set the language of the message.
     *
     * @param mixed $language
     *
     * @return self
     */
    public function language($language): self
    {
        $this->language = $language;

        return $this;
    }

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

        dd($res->body(), $res->status());

        return true;
    }

    /**
     * Queue the message.
     * 
     * @return void
     */
    public function queue(): void
    {
        //
    }

    /**
     * Log the message data.
     * 
     * @return void
     */
    public function log(): void
    {
        Log::info("SMS", $this->query() + ['provider', class_basename($this)]);
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
