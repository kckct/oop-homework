<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Class JsonManager
 * @package App\Services
 */
abstract class JsonManager
{
    /**
     * 讀取 json 設定檔轉成 Collection Object
     * @param string $fileName
     * @return Collection
     */
    protected function getJsonObject(string $fileName): Collection
    {
        // 讀取 json 設定檔
        $fileContent = file_get_contents(config_path($fileName));

        // json decode
        return collect(json_decode($fileContent, true));
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