<?php

namespace Sandwave\PhonePinChecker;

use Carbon\Carbon;
use Illuminate\Cache\CacheManager;

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

    /**
     * PhonePinChecker constructor.
     *
     * @param CacheManager $cacheDriver
     * @param int $expire
     */
    public function __construct(CacheManager $cacheDriver, int $expire = 3600)
    {
        $this->cache = $cacheDriver;
        $this->expire = $expire;
    }

    /**
     * Create new pincode.
     *
     * @param int|null $pin
     * @param array|null $optionalData
     * @return array
     */
    public function create(?int $pin = null, ?array $optionalData = null) : array
    {
        $expire = Carbon::now()->addSeconds($this->expire);

        if (! $pin) {
            $pin = rand(1000, 9999);
        }

        $this->expire = 3600;

        $model = [
            'pin' => $pin,
            'expire' => $expire->toISO8601String(),
            'optional_data' => $optionalData
        ];

        $this->cache->put("phonepinchecker.{$pin}", $model, $this->expire);

        return $model;
    }

    /**
     * Check pincode.
     *
     * @param int $pin
     * @return array|null
     */
    public function check(int $pin) : ?array
    {
        $check = $this->cache->get("phonepinchecker.{$pin}");

        if ($check && $check['pin'] === $pin) {
            return $check;
        }

        return null;
    }
}
