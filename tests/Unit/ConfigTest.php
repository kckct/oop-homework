<?php

namespace Tests\Unit;

use App\Services\Config;
use Tests\TestCase;

/**
 * Class ConfigTest
 * @package Tests\Feature
 */
class ConfigTest extends TestCase
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
        $config = new Config($inputStub);

        // assert
        // Config 有屬性
        $this->assertObjectHasAttribute('connectionString', $config);
        $this->assertObjectHasAttribute('destination', $config);
        $this->assertObjectHasAttribute('dir', $config);
        $this->assertObjectHasAttribute('ext', $config);
        $this->assertObjectHasAttribute('handler', $config);
        $this->assertObjectHasAttribute('location', $config);
        $this->assertObjectHasAttribute('remove', $config);
        $this->assertObjectHasAttribute('subDirectory', $config);
        $this->assertObjectHasAttribute('unit', $config);
        // 屬性值是否正確
        $this->assertEquals('', $config->getConnectionString());
        $this->assertEquals('', $config->getDestination());
        $this->assertEquals('', $config->getDir());
        $this->assertEquals('', $config->getExt());
        $this->assertEquals([], $config->getHandler());
        $this->assertEquals('', $config->getLocation());
        $this->assertFalse($config->isRemove());
        $this->assertFalse($config->isSubDirectory());
        $this->assertEquals('', $config->getUnit());
    }

    public function test_傳入陣列預設屬性值正確()
    {
        // arrange
        $inputStub = collect([
            'ext'              => 'php',
            'location'         => 'c:\\xxx',
            'subDirectory'     => true,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['zip', 'encode'],
            'destination'      => 'directory',
            'dir'              => 'd:\\yyy',
            'connectionString' => 'zzz',
        ]);

        // act
        $config = new Config($inputStub);

        // assert
        // 屬性值是否正確
        $this->assertEquals('php', $config->getExt());
        $this->assertEquals('c:\\xxx', $config->getLocation());
        $this->assertTrue($config->isSubDirectory());
        $this->assertEquals('file', $config->getUnit());
        $this->assertFalse($config->isRemove());
        $this->assertEquals(['zip', 'encode'], $config->getHandler());
        $this->assertEquals('directory', $config->getDestination());
        $this->assertEquals('d:\\yyy', $config->getDir());
        $this->assertEquals('zzz', $config->getConnectionString());
    }
}
