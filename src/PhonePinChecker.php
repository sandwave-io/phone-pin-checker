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

    public function create()
    {
        $expire = Carbon::now()->addSeconds($this->expire);

        $code = 'test';

        $model = [
            'code' => $code,
            'expire' => $expire
        ];

        Cache::put("phonepinchecker.{$code}", $model, $expire);

        return $model;
    }

    public function check(string $code) : bool
    {
        $check = Cache::get("phonepinchecker.{$code}");

        if ($check['code'] === $code) {
            return true;
        }

        return false;
    }
}
