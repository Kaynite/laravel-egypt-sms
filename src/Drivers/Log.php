<?php

namespace Kaynite\SMS\Drivers;

use Carbon\Carbon;
use Kaynite\SMS\Interfaces\SMSInterface;
use Kaynite\SMS\Traits\Logger;

class Log implements SMSInterface
{
    use Logger;

/**
 * The number that will receive the message.
 *
 * @var string
 */
    protected $to;

    protected $message;
    protected $until;
    protected $language = 1;

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
     * @return boolean
     */
    public function send(): bool
    {
        $this->log();

        return true;
    }

    public function queue(): void
    {
        //
    }
}
