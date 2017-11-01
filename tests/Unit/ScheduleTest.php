<?php

namespace Tests\Unit;

use App\Services\Schedule;
use Tests\TestCase;

/**
 * Class ScheduleTest
 * @package Tests\Feature
 */
class ScheduleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_傳入空陣列有預設屬性()
    {
        // arrange
        $inputStub = collect([]);

        // act
        $config = new Schedule($inputStub);

        // assert
        // Schedule 有屬性
        $this->assertObjectHasAttribute('ext', $config);
        $this->assertObjectHasAttribute('interval', $config);
        $this->assertObjectHasAttribute('time', $config);
        // 屬性值是否正確
        $this->assertEquals('', $config->getExt());
        $this->assertEquals('', $config->getInterval());
        $this->assertEquals('', $config->getTime());
    }

    public function test_傳入陣列預設屬性值正確()
    {
        // arrange
        $inputStub = collect([
            'ext'      => 'php',
            'interval' => 'Friday',
            'time'     => '12:34',
        ]);

        // act
        $config = new Schedule($inputStub);

        // assert
        // 屬性值是否正確
        $this->assertEquals('php', $config->getExt());
        $this->assertEquals('Friday', $config->getInterval());
        $this->assertEquals('12:34', $config->getTime());
    }
}
