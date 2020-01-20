<?php
namespace Sandwave\PhonePinChecker;

class VIPCode
{
    public function check(string $code) : bool
    {
        if ($code === 1234) {
            return true;
        }
    }
}
