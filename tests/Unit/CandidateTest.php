<?php

namespace Tests\Unit;

use App\Services\Candidate;
use App\Services\Config;
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

    public function test_傳入空陣列有預設屬性()
    {
        // arrange
        $inputStub = collect([]);

        // act
        $candidate = new Candidate($inputStub);

        // assert
        // Candidate 有屬性
        $this->assertObjectHasAttribute('config', $candidate);
        $this->assertObjectHasAttribute('fileDateTime', $candidate);
        $this->assertObjectHasAttribute('name', $candidate);
        $this->assertObjectHasAttribute('processName', $candidate);
        $this->assertObjectHasAttribute('size', $candidate);
        // Candidate 的屬性 config 型別應為 Config
        $this->assertInstanceOf(Config::class, $candidate->getConfig());
    }

    public function test_傳入陣列預設屬性值正確()
    {
        // arrange
        $configStub = new Config(collect([
            'ext'              => 'php',
            'location'         => 'c:\\xxx',
            'subDirectory'     => true,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['zip', 'encode'],
            'destination'      => 'directory',
            'dir'              => 'd:\\yyy',
            'connectionString' => 'zzz',
        ]));

        $inputStub = collect([
            'config'       => $configStub,
            'fileDateTime' => '2017-11-01 12:34:56',
            'name'         => 'test.txt',
            'processName'  => 'xxx',
            'size'         => '123',
        ]);

        // act
        $candidate = new Candidate($inputStub);

        // assert
        // 屬性值是否正確
        $this->assertEquals('php', $candidate->getConfig()->getExt());
        $this->assertEquals('2017-11-01 12:34:56', $candidate->getFileDateTime());
        $this->assertEquals('test.txt', $candidate->getName());
        $this->assertEquals('xxx', $candidate->getProcessName());
        $this->assertEquals('123', $candidate->getSize());
        // Candidate 的屬性 config 型別應為 Config
        $this->assertInstanceOf(Config::class, $candidate->getConfig());
    }
}
