<?php

namespace Tests\Unit\Handler;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\Handler\EncodeHandler;
use Tests\TestCase;

/**
 * Class EncodeHandlerTest
 * @package Tests\Unit\Handler
 */
class EncodeHandlerTest extends TestCase
{
    private $encodeHandler;

    public function setUp()
    {
        parent::setUp();

        $this->encodeHandler = new EncodeHandler();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_將byte陣列進行編碼_傳入target有值_應回傳byte陣列且內容為string()
    {
        // arrange
        // 產生假 Candidate 物件
        $candidateStub = $this->createFakeCandidate();

        $targetStub = [
            '1' => 49,
            '2' => 50,
            '3' => 51,
        ];

        // act
        $byteArray = $this->encodeHandler->perform($candidateStub, $targetStub);

        // assert
        // byte array 筆數應該大於 0
        $this->assertTrue(count($byteArray) > 0);
        // byte array 第一筆型態為 string
        $this->assertTrue(is_string($byteArray[1]));
    }

    public function test_將byte陣列進行編碼_傳入target為空陣列_應回傳空陣列()
    {
        // arrange
        // 產生假 Candidate 物件
        $candidateStub = $this->createFakeCandidate();

        $targetStub = [];

        // act
        $byteArray = $this->encodeHandler->perform($candidateStub, $targetStub);

        // assert
        // byte array 筆數應該等於 0
        $this->assertEquals(0, count($byteArray));
    }

    private function createFakeCandidate()
    {
        $configItem = collect([
            'ext'              => 'txt',
            'location'         => 'c:\\xxx',
            'subDirectory'     => true,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['zip', 'encode'],
            'destination'      => 'directory',
            'dir'              => 'D:\\Projects\\oop-homework\\storage\\backup',
            'connectionString' => '',
        ]);
        $configStub = new Config($configItem);

        $candidateItem = collect([
            'config'       => $configStub,
            'fileDateTime' => '2017-11-01 12:34:56',
            'name'         => 'test.txt',
            'processName'  => 'xxx',
            'size'         => '123',
        ]);

        return new Candidate($candidateItem);
    }
}
