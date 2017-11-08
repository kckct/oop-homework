<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Config;
use App\Services\ConfigManager;

/**
 * Class ConfigManagerTest
 * @package Tests\Feature
 */
class ConfigManagerTest extends TestCase
{
    private $configManager;

    public function setUp()
    {
        parent::setUp();

        $this->configManager = new ConfigManager();
        $this->configManager->processJsonConfig();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_有configs屬性()
    {
        // assert
        $this->assertObjectHasAttribute('configs', $this->configManager);
    }

    public function test_讀取json檔有3筆config設定()
    {
        // assert
        $this->assertEquals(3, $this->configManager->count());
    }

    public function test_可取得configs陣列且為Config物件且值正確()
    {
        // act
        $configs = $this->configManager->getConfigs();

        // assert
        // configs 屬性為 array
        $this->assertTrue(is_array($configs));
        // configs array 皆為 Config 物件
        $this->assertInstanceOf(Config::class, $configs[0]);
        $this->assertInstanceOf(Config::class, $configs[1]);
        $this->assertInstanceOf(Config::class, $configs[2]);
        // configs[0] 所有 property 值正確
        $this->assertEquals('txt', $configs[0]->getExt());
        $this->assertEquals('D:\\Projects\\oop-homework\\storage\\app', $configs[0]->getLocation());
        $this->assertFalse($configs[0]->isSubDirectory());
        $this->assertEquals('file', $configs[0]->getUnit());
        $this->assertFalse($configs[0]->isRemove());
        $this->assertEquals(['zip', 'encode'], $configs[0]->getHandler());
        $this->assertEquals('directory', $configs[0]->getDestination());
        $this->assertEquals('D:\\Projects\\oop-homework\\storage\\app\\backup', $configs[0]->getDir());
        $this->assertEquals('', $configs[0]->getConnectionString());
    }
}
