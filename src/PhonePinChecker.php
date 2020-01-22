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

    private $cache;

    public function __construct(CacheManager $cacheDriver, int $expire = 3600)
    {
        $this->cache = $cacheDriver;
        $this->expire = $expire;
    }

    public function create(?int $pin = null) : array
    {
        $expire = Carbon::now()->addSeconds($this->expire);

        if (! $pin) {
            $pin = rand(1000, 9999);
        }

        $this->expire = 3600;

        $model = [
            'pin' => $pin,
            'expire' => $expire
        ];

        $this->cache->put("phonepinchecker.{$pin}", $model, $this->expire);

        return $model;
    }

    public function check(int $pin) : bool
    {
        $check = $this->cache->get("phonepinchecker.{$pin}");

        if ($check && $check['pin'] === $pin) {
            return true;
        }

        return false;
    }
}
