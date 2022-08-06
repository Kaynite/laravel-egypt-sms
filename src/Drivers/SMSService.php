<?php

namespace Kaynite\SMS\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Kaynite\SMS\Interfaces\SMSInterface;
use Kaynite\SMS\Jobs\SendSMS;

abstract class SMSService implements SMSInterface
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
     * @var string
     */
    protected $message;

    /**
     * The date and time the message will be sent at.
     *
     * @var Carbon
     */
    protected $until;

    /**
     * The message language.
     *
     * @var int
     */
    protected $language;

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
        $number = is_array($number) ? $number : func_get_args();

        $this->to = implode(",", $number);

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
     * Queue the message.
     *
     * @return void
     */
    public function queue(): void
    {
        SendSMS::dispatch($this);
    }

    public function log(): void
    {
        Log::info("SMS", [
            'provider'      => class_basename($this),
            'to'            => $this->to,
            'message'       => $this->message,
            'language'      => $this->language,
            'sent_at'       => now(),
            'delayed_until' => $this->until,
        ]);
    }
}
