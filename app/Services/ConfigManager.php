<?php

namespace App\Services;

use InvalidArgumentException;

/**
 * Class ConfigManager
 * @package App\Services
 */
class ConfigManager
{
    /** @var Config[] $configs */
    private $configs = [];

    /**
     * ConfigManager constructor.
     */
    public function __construct()
    {
        $this->processConfigs();
    }

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
        return count($this->configs);
    }

    /**
     * 讀取 config.json
     * @return void
     */
    private function processConfigs()
    {
        // 讀取 config.json
        $fileContent = file_get_contents(app_path() . '/../config/config.json');

        // json decode
        $configArray = json_decode($fileContent, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($configArray['configs'])) {
            throw new InvalidArgumentException('json file 格式錯誤');
        }

        // 將 config.json 內容整理成 Config[] $configs
        $this->configs = collect($configArray['configs'])->map(function($item) {
            // 檢查 config.json 各 config key 是否存在
            if (!$this->isConfigFieldValid($item)) {
                throw new InvalidArgumentException('json file 格式錯誤');
            }

            return new Config($item);
        })->toArray();
    }

    /**
     * 檢查 config.json 各 config key 是否存在
     * @param array $config
     * @return bool
     */
    private function isConfigFieldValid(array $config): bool
    {
        return isset($config['connectionString']) && isset($config['destination']) && isset($config['dir'])
            && isset($config['ext']) && isset($config['handler']) && isset($config['location'])
            && isset($config['remove']) && isset($config['subDirectory']) && isset($config['unit']);
    }
}