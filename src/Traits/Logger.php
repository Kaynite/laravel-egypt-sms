<?php

namespace Kaynite\SMS\Traits;

use Illuminate\Support\Facades\Log;

trait Logger
{
    public function log(): void
    {
        Log::info("SMS", [
            'provider'      => class_basename(get_called_class()),
            'to'            => $this->to,
            'message'       => $this->message,
            'language'      => $this->language,
            'sent_at'       => now(),
            'delayed_until' => $this->until,
        ]);
    }
}
