<?php

namespace Tests\Feature;

use App\Services\Config;
use Tests\TestCase;
use App\Services\ConfigManager;

class ConfigManagerTest extends TestCase
{
    private $configManager;

    public function setUp()
    {
        parent::setUp();

        $this->configManager = new ConfigManager();
    }

    public function test_有configs屬性()
    {
        $this->assertObjectHasAttribute('configs', $this->configManager);
    }

    public function test_讀取json檔有3筆config設定()
    {
        $this->assertEquals(3, $this->configManager->count());
    }

    public function test_可取得configs陣列()
    {
        $this->assertTrue(is_array($this->configManager->getConfigs()));
    }
}
