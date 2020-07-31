<?php declare(strict_types = 1);

use Carbon\Carbon;
use Illuminate\Cache\CacheManager;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Sandwave\PhonePinChecker\Domain\Authorization;
use Sandwave\PhonePinChecker\PhonePinChecker;

class PhonePinCheckerTest extends TestCase
{
    public function testCreate()
    {
        $cache = m::mock(CacheManager::class)->shouldAllowMockingProtectedMethods();
        $cache->shouldReceive('put')->once();
        $cache->shouldReceive('get')->once()->andReturn(false);

        $checker = new PhonePinChecker($cache);

        $authorization = $checker->create(null, null);

        // Between 1000 and 9999 (four digits)
        $this->assertGreaterThan(999, $authorization->getPin());
        $this->assertLessThan(10000, $authorization->getPin());
    }

    public function testCheck()
    {
        $expiration = 1596203613;
        $cache = m::mock(CacheManager::class)->shouldAllowMockingProtectedMethods();

        $authorization = new Authorization('1234', Carbon::createFromTimestamp(1596203613), 'account_id_here');

        $cache->shouldReceive('get')->once()->andReturn([
            'pin'               => '1234',
            'expire_timestamp'  => $expiration,
            'reference'         => 'account_id_here',
        ]);
        $checker = new PhonePinChecker($cache);

        $result = $checker->check('1234');
        $this->assertSame($result->toArray(), $authorization->toArray());
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
