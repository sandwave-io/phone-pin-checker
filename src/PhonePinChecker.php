<?php

namespace Sandwave\PhonePinChecker;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PhonePinChecker
{
    public $expire;

    public function __construct($expire = 3600)
    {
        $this->expire = $expire;
    }

    public function create($pin = null)
    {
        $expire = Carbon::now()->addSeconds($this->expire);

        if (! $pin) {
            $pin = (string) rand(1000, 9999);
        }

        $this->expire = 3600;

        $model = [
            'pin' => $pin,
            'expire' => $expire
        ];

        Cache::put("phonepinchecker.{$pin}", $model, $this->expire);

        return $model;
    }

    public function check(string $pin) : bool
    {
        $check = Cache::get("phonepinchecker.{$pin}");

        if ($check['pin'] === $pin) {
            return true;
        }

        return false;
    }
}
