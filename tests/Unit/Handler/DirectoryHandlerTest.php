<?php

namespace Tests\Unit\Handler;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\Handler\DirectoryHandler;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class DirectoryHandlerTest
 * @package Tests\Unit\Handler
 */
class DirectoryHandlerTest extends TestCase
{
    private $directoryHandler;

    public function setUp()
    {
        parent::setUp();

        $this->directoryHandler = new DirectoryHandler();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_將byte陣列還原成檔案並複製到其他目錄_傳入target有值_應回傳byte陣列且內容為string()
    {
        // arrange
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'test.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/test.txt.backup';

        // 產生假 Candidate 物件
        $candidateStub = $this->createFakeCandidate();

        $targetStub = [
            '1' => 49,
            '2' => 50,
            '3' => 51,
        ];

        // act
        $this->directoryHandler->perform($candidateStub, $targetStub);

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(Storage::exists($byteArrayToFile));
        $this->assertTrue(Storage::exists($copyToNewFile));

        // 測試結束刪除檔案
        Storage::delete($copyToNewFile);
        $this->assertFalse(Storage::exists($copyToNewFile));
        Storage::delete($byteArrayToFile);
        $this->assertFalse(Storage::exists($byteArrayToFile));
    }

    public function test_將byte陣列還原成檔案並複製到其他目錄_傳入target為空陣列_應回傳空陣列()
    {
        // arrange
        // 產生假 Candidate 物件
        $candidateStub = $this->createFakeCandidate();

        $targetStub = [];

        // act
        $byteArray = $this->directoryHandler->perform($candidateStub, $targetStub);

        // assert
        // byte array 筆數應該等於 0
        $this->assertEquals(0, count($byteArray));
    }

    private function createFakeCandidate()
    {
        $configItem = collect([
            'ext'              => 'txt',
            'location'         => 'D:\\Projects\\oop-homework\\storage\\app',
            'subDirectory'     => true,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['zip', 'encode'],
            'destination'      => 'directory',
            'dir'              => 'D:\\Projects\\oop-homework\\storage\\app\\backup',
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
