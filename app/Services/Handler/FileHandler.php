<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class FileHandler
 * @package App\Services\Handler
 */
class FileHandler extends AbstractHandler
{
    /**
     * 處理檔案
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return array
     */
    public function perform(Candidate $candidate, array $target): array
    {
        parent::perform($candidate, $target);

        // byte[] 為空時 將檔案轉成 byte[] 並回傳
        if (empty($target)) {
            return $this->convertFileToByteArray($candidate);
        }

        // 將 byte[] 轉成檔案
        $this->convertByteArrayToFile($candidate, $target);
        return [];
    }

    /**
     * 將檔案轉成 byte array
     * @param Candidate $candidate
     * @return array
     */
    private function convertFileToByteArray(Candidate $candidate): array
    {
        // 檔案路徑
        $filePath = storage_path($candidate->getName());

        // 讀取檔案成 string
        $handle = fopen($filePath, 'rb');
        $content = fread($handle, filesize($filePath));
        fclose($handle);

        // 以 char 為單位轉成 array
        return unpack('C*', $content);
    }

    /**
     * 將 byte array 轉成檔案
     * @param Candidate $candidate
     * @param array $target
     * @return void
     */
    private function convertByteArrayToFile(Candidate $candidate, array $target): void
    {
        // 檔案路徑，跟原檔名相同，但副檔加上.backup
        // example: text.txt => text.txt.backup
        $filePath = storage_path($candidate->getName() . '.backup');

        // 以 char 為單位將 array 轉回 string
        $content = pack('C*', ...$target);

        // 寫入檔案
        $handle = fopen($filePath, 'w');
        fwrite($handle, $content);
        fclose($handle);
    }
}