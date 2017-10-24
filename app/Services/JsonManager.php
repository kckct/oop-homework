<?php

namespace App\Services;

use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Class JsonManager
 * @package App\Services
 */
abstract class JsonManager
{
    /**
     * 讀取 json 設定檔轉成 Collection Object
     * @param string $configPath
     * @return Collection
     */
    protected function getJsonObject(string $configPath): Collection
    {
        // 讀取 json 設定檔
        $fileContent = file_get_contents(app_path() . $configPath);

        // json decode
        $configArray = json_decode($fileContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('json file 格式錯誤');
        }

        return collect($configArray);
    }

    /**
     * 將 json 設定檔處理成可讓外部使用的 array
     * @return void
     */
    public abstract function processJsonConfig();

    /**
     * 計算 json 內設定檔 array 數量
     * @param array $configs
     * @return int
     */
    protected function configCount(array $configs): int
    {
        return count($configs);
    }
}