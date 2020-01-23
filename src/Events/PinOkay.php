<?php

namespace Sandwave\PhonePinChecker\Events;

use Illuminate\Queue\SerializesModels;

class PinOkay
{
    use SerializesModels;

    public $payload;

    /**
     * Create a new event instance.
     *
     * @param  array  $payload
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
