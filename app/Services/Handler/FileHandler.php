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
        if (empty($target)) {
            return $this->convertFileToByteArray($candidate);
        }

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
        $filePath = storage_path('app/' . $candidate->getName());
        $handle = fopen($filePath, 'rb');
        $content = fread($handle, filesize($filePath));
        fclose($handle);

        return unpack('C*', $content);
    }

    /**
     * 將 byte array 轉成檔案
     * @param Candidate $candidate
     * @param array $target
     * @return void
     */
    public function convertByteArrayToFile(Candidate $candidate, array $target): void
    {
        $filePath = storage_path($candidate->getName());
        $content = pack('C*', ...$target);
        $handle = fopen($filePath, 'w');
        fwrite($handle, $content);
        fclose($handle);
    }
}