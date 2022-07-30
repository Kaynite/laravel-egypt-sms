<?php

namespace Kaynite\SMS\Facades;

use Illuminate\Support\Facades\Facade;
use Kaynite\SMS\Interfaces\SMSInterface;

class SMS extends Facade
{
    public static function getFacadeAccessor()
    {
        return SMSInterface::class;
    }
}
