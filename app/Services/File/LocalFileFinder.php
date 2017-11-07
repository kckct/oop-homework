<?php

namespace App\Services\File;

use App\Services\Candidate;
use App\Services\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Class LocalFileFinder
 * @package App\Services\File
 */
class LocalFileFinder extends AbstractFileFinder
{
    /**
     * LocalFileFinder constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);

        // 是否處理子目錄
        if ($config->isSubDirectory()) {
            $this->files = $this->getSubDirectoryFiles($config);
        } else {
            $files = File::files($config->getLocation());
            $this->files = $this->filterFileExtension($files, $config);
        }
    }

    /**
     * 取得所有子目錄且副檔名符合的檔名
     * @param Config $config
     * @return array
     */
    private function getSubDirectoryFiles(Config $config): array
    {
        // 取得所有子目錄的檔名
        $files = File::allFiles($config->getLocation());

        // 過濾副檔名
        return $this->filterFileExtension($files, $config);
    }

    /**
     * 過濾副檔名
     * @param array $files
     * @param Config $config
     * @return array
     */
    private function filterFileExtension(array $files, Config $config): array
    {
        return collect($files)->filter(function ($file) use ($config) {
            // 保留副檔名符合的
            return File::extension($file) === $config->getExt();
        })->map(function ($file) {
            // 回傳完整路徑
            return $file->getPathname();
        })->flatten()->toArray();
    }
    
    /**
     * 產生 Candidate object
     * @param string $fileName
     * @return Candidate
     */
    protected function createCandidate(string $fileName): Candidate
    {
        $data['config']       = $this->config;
        $data['fileDateTime'] = Carbon::createFromTimestamp(File::lastModified($fileName))->toDateTimeString();
        $data['name']         = File::basename($fileName);
        $data['processName']  = '';
        $data['size']         = File::size($fileName);

        return new Candidate(collect($data));
    }
}