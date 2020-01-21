<?php

use Sandwave\PhonePinChecker\PhonePinChecker;

class OriginMatcherTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $checker = new PhonePinChecker;

        $code = $checker->create();

        // Between 1000 and 9999 (four digits)
        $this->assertGreaterThan(
            $code['code'],
            999
        );

        $this->assertLessThan(
            $code['code'],
            10000
        );
    }

    public function testCheck()
    {
        $checker = new PhonePinChecker;

        $code = $checker->create("1234");

        $result = $checker->check("1234");
        $this->assertTrue($result);

        $result = $checker->check("4321");
        $this->assertFalse($result);
    }
}
