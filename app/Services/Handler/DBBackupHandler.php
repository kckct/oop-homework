<?php

namespace App\Services\Handler;

use App\Models\MyBackup;
use App\Services\Candidate;
use Illuminate\Support\Facades\File;

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

        MyBackup::create([
            'name'           => File::basename($candidate->getName()),
            'file_date_time' => $candidate->getFileDateTime(),
            'size'           => $candidate->getSize(),
            'target'         => json_encode($target),
        ]);

        return $target;
    }
}