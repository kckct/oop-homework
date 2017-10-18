<?php

namespace Tests\Feature;

use App\Services\Schedule;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_有預設屬性()
    {
        $inputStub = [
            'ext'      => '',
            'interval' => '',
            'time'     => '',
        ];

        $config = new Schedule($inputStub);

        $this->assertObjectHasAttribute('ext', $config);
        $this->assertObjectHasAttribute('interval', $config);
        $this->assertObjectHasAttribute('time', $config);
    }
}
