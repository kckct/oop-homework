<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Interface Handler
 * @package App\Services\Handler
 */
interface Handler
{
    /**
     * 處理檔案
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return array
     */
    public function perform(Candidate $candidate, array $target): array;
}