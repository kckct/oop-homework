<?php

namespace Tests\Feature;

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

    public function test_有configs屬性()
    {
        $this->assertObjectHasAttribute('configs', $this->configManager);
    }

    public function test_讀取json檔有3筆config設定()
    {
        $this->assertEquals(3, $this->configManager->count());
    }

    public function test_可取得configs陣列且為Config物件()
    {
        $configs = $this->configManager->getConfigs();

        // configs 屬性為 array
        $this->assertTrue(is_array($configs));
        // configs array 皆為 Config 物件
        $this->assertInstanceOf(Config::class, $configs[0]);
        $this->assertInstanceOf(Config::class, $configs[1]);
        $this->assertInstanceOf(Config::class, $configs[2]);
    }
}
