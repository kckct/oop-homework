<?php

namespace App\Services;

/**
 * Class ConfigManager
 * @package App\Services
 */
class ConfigManager extends JsonManager
{
    /** @var string 設定檔檔名 */
    const FILE_NAME = 'config.json';

    /** @var Config[] $configs */
    private $configs = [];

    /**
     * @return Config[]
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

    /**
     * 計算 configs 數量
     * @return int
     */
    public function count(): int
    {
        return $this->configCount($this->configs);
    }

    /**
     * 將 json 設定檔處理成可讓外部使用的 array
     * @return void
     */
    public function processJsonConfig()
    {
        // 讀取 json 轉成 Collection Object
        $configObject = $this->getJsonObject(self::FILE_NAME);

        // 將 config.json 內容整理成 Config[] $configs
        $this->configs = collect($configObject->get('configs', []))->map(function($item) {
            return new Config(collect($item));
        })->toArray();
    }
}