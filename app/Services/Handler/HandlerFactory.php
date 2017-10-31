<?php

namespace App\Services\Handler;
use InvalidArgumentException;

/**
 * Class HandlerFactory
 * @package App\Services\Handler
 */
class HandlerFactory
{
    /** @var string handler_mapping.json 路徑 */
    const CONFIG_PATH = '/../config/handler_mapping.json';

    /** @var array  */
    private static $handlerDictionary;

    /**
     * HandlerFactory constructor.
     */
    public function __construct()
    {
        // 讀取 json 設定檔
        $fileContent = file_get_contents(app_path() . self::CONFIG_PATH);

        // json decode
        static::$handlerDictionary = json_decode($fileContent, true);
    }

    /**
     * 建立對應的 Handler object
     * @param string $key
     * @return array
     */
    public static function create(string $key): array
    {
        $handler = static::$handlerDictionary[$key];

        if (empty($handler)) {
            throw new InvalidArgumentException("找不到 {$key} 的 handler");
        }

        return new($handler);
    }
}