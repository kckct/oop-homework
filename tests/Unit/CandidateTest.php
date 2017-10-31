<?php

namespace Tests\Feature;

use App\Services\Candidate;
use Tests\TestCase;

/**
 * Class CandidateTest
 * @package Tests\Feature
 */
class CandidateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_有預設屬性()
    {
        // act
        $candidate = new Candidate();

        // assert
        // Candidate 有屬性
        $this->assertObjectHasAttribute('config', $candidate);
        $this->assertObjectHasAttribute('fileDateTime', $candidate);
        $this->assertObjectHasAttribute('name', $candidate);
        $this->assertObjectHasAttribute('processName', $candidate);
        $this->assertObjectHasAttribute('size', $candidate);
    }
}
