<?php
namespace Sandwave\PhonePinChecker\Domain;

use Carbon\Carbon;
use DateTime;

class Authorization
{
    /** @var string */
    private $pin;

    /** @var Carbon */
    private $expiration;

    /** @var string|null */
    private $reference;

    public function __construct(string $pin, Carbon $expiration, ?string $reference = null)
    {
        $this->pin = $pin;
        $this->expiration = $expiration;
        $this->reference = $reference;
    }

    public function getPin(): string
    {
        return $this->pin;
    }

    public function getExpiration(): Carbon
    {
        return $this->expiration;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function toArray(): array
    {
        return [
            'pin'               => $this->pin,
            'expire_timestamp'  => $this->expiration->timestamp,
            'reference'         => $this->reference
        ];
    }

    public static function fromArray(array $data): Authorization
    {
        return new Authorization(
            $data['pin'],
            Carbon::createFromTimestamp($data['expire_timestamp']),
            $data['reference']
        );
    }
}