<?php

namespace Sandwave\PhonePinChecker\Events;

use Illuminate\Queue\SerializesModels;
use Sandwave\PhonePinChecker\Domain\Authorization;
use Sandwave\PhonePinChecker\Domain\IncomingCall;

class PinOkay
{
    use SerializesModels;

    /** @var Authorization */
    public $authorization;

    /** @var IncomingCall */
    public $call;

    public function __construct(IncomingCall $call, Authorization $authorization)
    {
        $this->call = $call;
        $this->authorization = $authorization;
    }
}
