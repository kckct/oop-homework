<?php

namespace App\Services\Handler;

use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

/**
 * Class HandlerFactory
 * @package App\Services\Handler
 */
class HandlerFactory
{
    /** @var string 設定檔檔名 */
    const FILE_NAME = 'handler_mapping.json';

    /**
     * 建立對應的 Handler object
     * @param string $key
     * @return Handler
     */
    public static function create(string $key): Handler
    {
        // 讀取 json 設定檔
        $fileContent = Storage::disk('config')->get(self::FILE_NAME);

        // json decode
        $handlerMapping = json_decode($fileContent, true);

        // 找不到對應的 handler throw exception
        if (empty($handlerMapping[$key])) {
            throw new InvalidArgumentException("找不到 {$key} 的 handler");
        }

        // namespace + handler name
        $className = __NAMESPACE__ . DIRECTORY_SEPARATOR . $handlerMapping[$key];

        return new $className;
    }
}