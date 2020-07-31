<?php
namespace Sandwave\PhonePinChecker\Domain;

class IncomingCall
{
    /** @var string */
    private $code;

    /** @var string */
    private $callerId;

    /** @var string */
    private $callerName;

    /** @var string */
    private $dialedId;

    public function __construct(string $code, string $callerId, string $callerName, string $dialedId)
    {
        $this->code = $code;
        $this->callerId = $callerId;
        $this->callerName = $callerName;
        $this->dialedId = $dialedId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCallerId(): string
    {
        return $this->callerId;
    }

    public function getCallerName(): string
    {
        return $this->callerName;
    }

    public function getDialedId(): string
    {
        return $this->dialedId;
    }
}