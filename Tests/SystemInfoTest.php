<?php

namespace Modules\System\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemInfoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFormatBytes()
    {
        $this->assertTrue(function_exists('formatBytes'));

        formatBytes(rand(1024, 800000000));
    }

    public function testSystemLoad()
    {
        $this->assertTrue(function_exists('systemCoreCount'));

        systemLoad(systemCoreCount());
    }

    public function testServerMemoryUsage()
    {
        $this->assertTrue(function_exists('serverMemoryUsage'));

        serverMemoryUsage();
    }
}
