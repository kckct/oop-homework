<?php

namespace Tests\Unit\Handler;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\Handler\FileHandler;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class FileHandlerTest
 * @package Tests\Unit\Handler
 */
class FileHandlerTest extends TestCase
{
    private $fileHandler;

    public function setUp()
    {
        parent::setUp();

        $this->fileHandler = new FileHandler();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @expectedException Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function test_將檔案轉成byte陣列_檔案不存在丟exception()
    {
        // arrange
        $inputStub = collect([]);
        $candidateStub = new Candidate($inputStub);
        $targetStub = [];

        // act
        $this->fileHandler->perform($candidateStub, $targetStub);
    }

    public function test_將檔案轉成byte陣列_byte陣列筆數應大於0()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'test.txt';
        Storage::put($testFileName, '123');

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
        $candidateStub = new Candidate($candidateItem);

        $targetStub = [];

        // act
        $byteArray = $this->fileHandler->perform($candidateStub, $targetStub);

        // assert
        // byte array 筆數應該大於 0
        $this->assertTrue(count($byteArray) > 0);

        // 測試結束刪除檔案
        Storage::delete($testFileName);

        return $byteArray;
    }

    /**
     * @depends test_將檔案轉成byte陣列_byte陣列筆數應大於0
     */
    public function test_將byte陣列轉成檔案(array $byteArray)
    {
        // arrange
        // 測試完預期產生的檔案
        $testFileName = 'test.txt.backup';

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
        $candidateStub = new Candidate($candidateItem);

        // act
        $this->fileHandler->perform($candidateStub, $byteArray);

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(Storage::exists($testFileName));

        // 測試結束刪除檔案
        Storage::delete($testFileName);
    }
}
