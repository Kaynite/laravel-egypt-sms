<?php

namespace Kaynite\SMS\Drivers;

use Kaynite\SMS\Interfaces\SMSInterface;

class Log extends SMSService implements SMSInterface
{
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
}
