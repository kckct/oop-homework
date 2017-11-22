<?php

namespace App\Services\Handler;

use App\Models\MyLog;
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

        MyLog::create([
            'name'             => $candidate->getName(),
            'connectionString' => $candidate->getConfig()->getConnectionString(),
            'destination'      => $candidate->getConfig()->getDestination(),
            'dir'              => $candidate->getConfig()->getDir(),
            'ext'              => $candidate->getConfig()->getExt(),
            'handler'          => json_encode($candidate->getConfig()->getHandler()),
            'location'         => $candidate->getConfig()->getLocation(),
            'remove'           => $candidate->getConfig()->isRemove(),
            'subDirectory'     => $candidate->getConfig()->isSubDirectory(),
            'unit'             => $candidate->getConfig()->getUnit(),
        ]);

        return $target;
    }
}