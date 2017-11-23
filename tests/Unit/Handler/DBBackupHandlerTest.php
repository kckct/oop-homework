<?php

namespace Tests\Unit\Handler;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\Handler\DBBackupHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class DBBackupHandlerTest
 * @package Tests\Unit\Handler
 */
class DBBackupHandlerTest extends TestCase
{
    use RefreshDatabase;

    private $dbBackupHandler;

    public function setUp()
    {
        parent::setUp();

        $this->dbBackupHandler = new DBBackupHandler();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_傳入candidate及target_應寫入資料庫my_backup()
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
        $this->dbBackupHandler->perform($candidateStub, $targetStub);

        // assert
        $this->assertDatabaseHas('my_backup', [
            'name' => 'D:\\Projects\\oop-homework\\storage\\app\\test.db',
        ]);
    }

    /**
     * 產生假 Candidate 物件
     * @return Candidate
     */
    private function createFakeCandidate()
    {
        $configItem = collect([
            'ext'              => 'db',
            'location'         => 'D:\\Projects\\oop-homework\\storage\\app',
            'subDirectory'     => false,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['zip', 'encode'],
            'destination'      => 'db',
            'dir'              => '',
            'connectionString' => '',
        ]);
        $configStub = new Config($configItem);

        $candidateItem = collect([
            'config'       => $configStub,
            'fileDateTime' => '2017-11-01 12:34:56',
            'name'         => 'D:\\Projects\\oop-homework\\storage\\app\\test.db',
            'processName'  => 'xxx',
            'size'         => '123',
        ]);

        return new Candidate($candidateItem);
    }
}
