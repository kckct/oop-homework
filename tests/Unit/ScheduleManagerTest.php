<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Schedule;
use App\Services\ScheduleManager;

/**
 * Class ScheduleManagerTest
 * @package Tests\Feature
 */
class ScheduleManagerTest extends TestCase
{
    private $scheduleManger;

    public function setUp()
    {
        parent::setUp();

        $this->scheduleManger = new ScheduleManager();
        $this->scheduleManger->processJsonConfig();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_有schedules屬性()
    {
        // assert
        $this->assertObjectHasAttribute('schedules', $this->scheduleManger);
    }

    public function test_讀取json檔有3筆schedule設定()
    {
        // assert
        $this->assertEquals(3, $this->scheduleManger->count());
    }

    public function test_可取得schedules陣列且為Schedule物件()
    {
        // act
        $schedules = $this->scheduleManger->getSchedules();

        // assert
        // schedules 屬性為 array
        $this->assertTrue(is_array($schedules));
        // schedules array 皆為 Schedule 物件
        $this->assertInstanceOf(Schedule::class, $schedules[0]);
        $this->assertInstanceOf(Schedule::class, $schedules[1]);
        $this->assertInstanceOf(Schedule::class, $schedules[2]);
        // schedules[0] 所有 property 值正確
        $this->assertEquals('txt', $schedules[0]->getExt());
        $this->assertEquals('Everyday', $schedules[0]->getInterval());
        $this->assertEquals('12:00', $schedules[0]->getTime());
    }
}
