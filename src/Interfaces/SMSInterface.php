<?php

namespace Kaynite\SMS\Interfaces;

use Carbon\Carbon;

interface SMSInterface
{
    public function to(array|string|int $number): self;
    public function message(string $message): self;
    public function delayUntil(Carbon $datetime): self;
    public function language(string $message): self;
    public function send(): bool;
    public function queue(): void;
    public function log(): void;
}
