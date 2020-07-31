<?php

namespace Sandwave\PhonePinChecker;

use Carbon\Carbon;
use Illuminate\Cache\CacheManager;
use Sandwave\PhonePinChecker\Domain\Authorization;

class PhonePinChecker
{
    /**
     * @var int
     */
    private $expire;

    /**
     * @var CacheManager
     */
    private $cache;

    public function __construct(CacheManager $cacheDriver, int $expire = 3600)
    {
        $this->cache = $cacheDriver;
        $this->expire = $expire;
    }

    public function create(?string $pin = null, ?string $reference = null) : Authorization
    {
        $expiration = Carbon::now()->addSeconds($this->expire);

        $pin = $this->getRandomPin($pin);

        $this->expire = 3600;

        $authorization = new Authorization($pin, $expiration, $reference);

        $this->cache->put($this->getCacheKeyFromPin($pin), $authorization->toArray(), $this->expire);

        return $authorization;
    }

    public function check(string $pin) : ?Authorization
    {
        $data = $this->cache->get($this->getCacheKeyFromPin($pin));
        if (! is_array($data)) {
            return null;
        }
        $authorization = Authorization::fromArray($data);

        if ($authorization->getPin() === $pin) {
            return $authorization;
        }

        return null;
    }

    private function getRandomPin(?string $pin = null): string
    {
        if (! $pin) {
            $pin = rand(1000, 9999);
        }

        // Check if exists
        $exists = $this->cache->get($this->getCacheKeyFromPin($pin));

        if ($exists) {
            // Recursive
            $pin = $this->getRandomPin();
        }

        return (string) $pin;
    }

    private function getCacheKeyFromPin(string $pin): string
    {
        return "phonepinchecker.{$pin}";
    }
}
