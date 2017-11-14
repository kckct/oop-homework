<?php

namespace Tests\Unit;

use App\Services\Handler\DirectoryHandler;
use App\Services\Handler\EncodeHandler;
use App\Services\Handler\FileHandler;
use App\Services\Handler\HandlerFactory;
use App\Services\Handler\ZipHandler;
use Tests\TestCase;

/**
 * Class HandlerFactoryTest
 * @package Tests\Feature
 */
class HandlerFactoryTest extends TestCase
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
    public function test_傳入尚未設定的key_丟出exception()
    {
        // act
        HandlerFactory::create('xxx');
    }

    public function test_傳入file_回傳FileHandler物件()
    {
        // act
        $handler = HandlerFactory::create('file');

        // assert
        $this->assertInstanceOf(FileHandler::class, $handler);
    }

    public function test_傳入encode_回傳EncodeHandler物件()
    {
        // act
        $handler = HandlerFactory::create('encode');

        // assert
        $this->assertInstanceOf(EncodeHandler::class, $handler);
    }

    public function test_傳入zip_回傳ZipHandler物件()
    {
        // act
        $handler = HandlerFactory::create('zip');

        // assert
        $this->assertInstanceOf(ZipHandler::class, $handler);
    }

    public function test_傳入directory_回傳DirectoryHandler物件()
    {
        // act
        $handler = HandlerFactory::create('directory');

        // assert
        $this->assertInstanceOf(DirectoryHandler::class, $handler);
    }
}
