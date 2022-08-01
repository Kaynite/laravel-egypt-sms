<?php

namespace Kaynite\SMS\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Kaynite\SMS\Interfaces\SMSInterface;
use Kaynite\SMS\Traits\Logger;

class SMSMisr implements SMSInterface
{
    use Logger;

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
    public function to(array | string | int $number): self
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

        if ($res->failed()) {
            return false;
        }

        if($res->object()->code != 1901) {
            return false;
        }

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

    protected function codes($value)
    {
        return match($value) {
            1901 => "Success, Message Submitted Successfully",
            1902 => "Invalid URL, This means that one of the parameters was not provided",
            9999 => "Please Wait For A While, This means You Sent Alot Of API Request At The Same Time",
            1903 => "Invalid value in username or password field",
            1904 => "Invalid value in 'sender' field",
            1905 => "Invalid value in 'mobile' field",
            1906 => "Insufficient Credit selected.",
            1907 => "Server under updating",
            1908 => "Invalid Date & Time format in 'DelayUntil=' parameter",
            1909 => "Error In Message",
            8001 => "Mobile is null",
            8002 => "Message is null",
            8003 => "Language is null",
            8004 => "Sender is null",
            8005 => "Username is null",
            8006 => "Password is null",
            default => "Unknown error"
        };
    }
}
