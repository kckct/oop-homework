<?php

namespace Tests\Unit;

use App\Services\Task\ScheduledTask;
use App\Services\Task\SimpleTask;
use App\Services\Task\TaskFactory;
use InvalidArgumentException;
use Tests\TestCase;

/**
 * Class TaskFactoryTest
 * @package Tests\Unit
 */
class TaskFactoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_傳入錯誤的task名稱_丟出exception()
    {
        $this->expectException(InvalidArgumentException::class);

        // act
        TaskFactory::create('xxx');
    }

    public function test_傳入simple_回傳simpleTask物件()
    {
        // act
        $task = TaskFactory::create('simple');

        // assert
        $this->assertInstanceOf(SimpleTask::class, $task);
    }

    public function test_傳入scheduled_回傳simpleTask物件()
    {
        // act
        $task = TaskFactory::create('scheduled');

        // assert
        $this->assertInstanceOf(ScheduledTask::class, $task);
    }
}
