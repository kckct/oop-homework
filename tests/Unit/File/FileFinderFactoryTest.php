<?php

namespace Tests\Unit\File;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\File\FileFinder;
use App\Services\FileFinderFactory;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class FileFinderFactoryTest
 * @package Tests\Unit\File
 */
class FileFinderFactoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_傳入尚未設定的finder_丟出exception()
    {
        // act
        FileFinderFactory::create('xxx', new Config(collect([])));
    }

    public function test_傳入file_回傳LocalFileFinder物件且可使用array及foreach方式存取()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'test.txt';
        Storage::put($testFileName, '123');

        $configItem = collect([
            'ext'              => 'txt',
            'location'         => 'D:\\Projects\\oop-homework\\storage\\app',
            'subDirectory'     => false,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['zip', 'encode'],
            'destination'      => 'directory',
            'dir'              => 'D:\\Projects\\oop-homework\\storage\\backup',
            'connectionString' => '',
        ]);

        // act
        $fileFinder = FileFinderFactory::create('file', new Config($configItem));

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(Storage::exists($testFileName));
        // 型別應為 FileFinder
        $this->assertInstanceOf(FileFinder::class, $fileFinder);
        // 以 array 方式存取時 型別應為 Candidate
        $this->assertInstanceOf(Candidate::class, $fileFinder[0]);
        foreach ($fileFinder as $item) {
            // 以 foreach 方式存取時 型別應為 Candidate
            $this->assertInstanceOf(Candidate::class, $item);
        }

        // 測試結束刪除檔案
        Storage::delete($testFileName);
        $this->assertFalse(Storage::exists($testFileName));
    }
}
