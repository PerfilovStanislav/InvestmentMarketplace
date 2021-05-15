<?php

namespace Jcupitt\Vips\Test;

use Jcupitt\Vips;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testVipsCacheSetMax()
    {
        /* Not easy to test ... just make sure it can execute.
         */
        Vips\Config::cacheSetMax(12);
    }

    public function testVipsCacheSetMaxMem()
    {
        Vips\Config::cacheSetMaxMem(12);
    }

    public function testVipsCacheSetMaxFiles()
    {
        Vips\Config::cacheSetMaxFiles(12);
    }

    public function testVipsConcurrencySet()
    {
        Vips\Config::concurrencySet(12);
    }

    public function testVipsVersion()
    {
        $version = Vips\Config::version();
        $this->assertEquals(preg_match("/\d+\.\d+\.\d+/", $version), 1);
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: expandtab sw=4 ts=4 fdm=marker
 * vim<600: expandtab sw=4 ts=4
 */
