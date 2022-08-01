<?php

namespace Kaynite\SMS;

use Illuminate\Support\Manager;
use Kaynite\SMS\Drivers\Log;
use Kaynite\SMS\Drivers\SMSMisr;

class SMSManager extends Manager
{
    public function getDefaultDriver()
    {
        return config('sms.default');
    }

    public function createSmsmisrDriver()
    {
        return new SMSMisr(config('sms.smsmisr'));
    }

    public function createSmsegyptDriver()
    {
        return new SMSMisr(config('sms.smsegypt'));
    }

    public function createLogDriver()
    {
        return new Log(config('sms.log'));
    }
}
