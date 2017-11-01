<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class ZipHandler
 * @package App\Services\Handler
 */
class ZipHandler extends AbstractHandler
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

        // 將 byte[] 壓縮
        return $this->zipData($candidate, $target);
    }

    /**
     * 壓縮
     * @param Candidate $candidate
     * @param array $target
     * @return array
     */
    private function zipData(Candidate $candidate, array $target): array
    {
        return collect($target)->map(function ($item) {
            return gzcompress((string)$item);
        })->toArray();
    }
}