<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class EncodeHandler
 * @package App\Services\Handler
 */
class EncodeHandler extends AbstractHandler
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

        // byte[] 為空時 直接回傳
        if (empty($target)) {
            return [];
        }

        // 將 byte[] 編碼
        return $this->encodeData($candidate, $target);
    }

    /**
     * 編碼
     * @param Candidate $candidate
     * @param array $target
     * @return array
     */
    private function encodeData(Candidate $candidate, array $target): array
    {
        return collect($target)->map(function ($item) {
            return base64_encode((string)$item);
        })->toArray();
    }
}