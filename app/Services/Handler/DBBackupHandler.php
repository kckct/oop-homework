<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class DBBackupHandler
 * @package App\Services\Handler
 */
class DBBackupHandler extends AbstractDBHandler
{
    /**
     * 將檔案存入 DB
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