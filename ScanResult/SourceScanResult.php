<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

class SourceScanResult implements ScanResultInterface
{
    /** @var SplFileInfo */
    private $info;

    function __construct(SplFileInfo $info)
    {
        $this->info = $info;
    }

    /**
     * @inheritdoc
     */
    public function getFileInfo()
    {
        return $this->info;
    }

    /**
     * @inheritdoc
     */
    public function getReference()
    {
        $reference = $this->info->getRelativePath() . DIRECTORY_SEPARATOR . $this->info->getBasename('.php');
        $reference = substr($reference, strlen('src/'));
        $reference = str_replace(DIRECTORY_SEPARATOR, '\\', $reference);
        $reference = str_replace('\\\\', '\\', $reference);

        return $reference;
    }
}
