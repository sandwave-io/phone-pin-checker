<?php

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Sandwave\PhonePinChecker\PhonePinChecker;
use Mockery as m;
use Illuminate\Cache\CacheManager;

class PhonePinCheckerTest extends TestCase
{
    public function testCreate()
    {
        $cache = m::mock(CacheManager::class);
        $cache->shouldReceive('put')->once();

        $checker = new PhonePinChecker($cache);

        $code = $checker->create(null, null);

        // Between 1000 and 9999 (four digits)
        $this->assertGreaterThan(
            999,
            $code['pin']
        );

        $this->assertLessThan(
            10000,
            $code['pin']
        );
    }

    public function testCheck()
    {
        $cache = m::mock(CacheManager::class)->shouldAllowMockingProtectedMethods();

        $model = [
            'pin' => 1234,
            'expire' => Carbon::now()->addSeconds(3600)->toIso8601String(),
            'optional_data' => [
                'account_id' => 'account_id_hier'
            ]
        ];

        $cache->shouldReceive('get')->once()->andReturn($model);
        $checker = new PhonePinChecker($cache);

        $result = $checker->check(1234);
        $this->assertSame($result, $model);
    }

    public function testCheckNegative()
    {
        $cache = m::mock(CacheManager::class)->shouldAllowMockingProtectedMethods();
        $cache->shouldReceive('get')->once()->andReturn(null);

        $checker = new PhonePinChecker($cache);

        $result = $checker->check(4321);
        $this->assertNull($result);
    }
}
