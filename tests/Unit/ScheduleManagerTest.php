<?php

namespace Tests\Feature;

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

    public function test_有schedules屬性()
    {
        $this->assertObjectHasAttribute('schedules', $this->scheduleManger);
    }

    public function test_讀取json檔有3筆schedule設定()
    {
        $this->assertEquals(3, $this->scheduleManger->count());
    }

    public function test_可取得schedules陣列且為Schedule物件()
    {
        $schedules = $this->scheduleManger->getSchedules();

        $this->assertTrue(is_array($schedules));
        $this->assertInstanceOf(Schedule::class, $schedules[0]);
    }
}
