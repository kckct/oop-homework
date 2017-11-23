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
            // 取得所有子目錄所有的檔名
            $files = File::allFiles($config->getLocation());
        } else {
            // 取得此目錄所有的檔名
            $files = File::files($config->getLocation());
        }

        // 過濾副檔名
        $this->files = $this->filterFileExtension($files, $config);
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
        $data['name']         = $fileName;
        $data['processName']  = '';
        $data['size']         = File::size($fileName);

        return new Candidate(collect($data));
    }
}