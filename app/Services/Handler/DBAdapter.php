<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class DBAdapter
 * @package App\Services\Handler
 */
class DBAdapter extends AbstractHandler
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

        // 將備份檔存入 DB
        $this->saveBackupToDB($candidate, $target);

        // 將 Log 存入 DB
        $this->saveLogToDB($candidate, $target);

        return $target;
    }

    /**
     * 將備份檔存入 DB
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return void
     */
    private function saveBackupToDB(Candidate $candidate, array $target): void
    {
        $backupHandler = new DBBackupHandler();
        $backupHandler->perform($candidate, $target);
    }

    /**
     * 將 Log 存入 DB
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return void
     */
    private function saveLogToDB(Candidate $candidate, array $target): void
    {
        $logHandler = new DBLogHandler();
        $logHandler->perform($candidate, $target);
    }
}