<?php

namespace App\Services\Handler;

use App\Services\Candidate;
use InvalidArgumentException;

/**
 * Class DirectoryHandler
 * @package App\Services\Handler
 */
class DirectoryHandler extends AbstractHandler
{
    /*** @var FileHandler */
    private $fileHandler;

    /**
     * DirectoryHandler constructor.
     */
    public function __construct()
    {
        $this->fileHandler = new FileHandler();
    }

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

        // 將 byte[] 還原檔案並複製到其他目錄
        $this->copyToDirectory($candidate, $target);

        return $target;
    }

    /**
     * 還原檔案並複製到其他目錄
     * @param Candidate $candidate
     * @param array $target
     * @return void
     */
    private function copyToDirectory(Candidate $candidate, array $target): void
    {
        // 還原檔案
        $this->fileHandler->perform($candidate, $target);

        // 檔名
        $backupFileName = $candidate->getName() . '.backup';

        // config.json 內所設定的 dir 目錄
        $newDir = $candidate->getConfig()->getDir();

        // 若 dir 目錄不存在丟 exception
        if (!file_exists($newDir)) {
            throw new InvalidArgumentException("$newDir 目錄尚未設定");
        }

        // 原檔案路徑
        $oldFilePath = storage_path('app' . DIRECTORY_SEPARATOR . $backupFileName);

        // 複製後的檔案路徑
        $newFilePath = $newDir . DIRECTORY_SEPARATOR . $backupFileName;

        // 複製檔案
        copy($oldFilePath, $newFilePath);
    }
}