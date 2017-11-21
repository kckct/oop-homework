<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class DBLogHandler
 * @package App\Services\Handler
 */
class DBLogHandler extends AbstractDBHandler
{
    /**
     * 將處理檔案的 Log 存入 DB
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return array
     */
    public function perform(Candidate $candidate, array $target): array
    {
        parent::perform($candidate, $target);

        return $target;
    }
}