<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

class BasicScanResult implements ScanResultInterface
{
    /** @var SplFileInfo */
    private $info;
    /** @var string */
    private $reference;

    /**
     * @param SplFileInfo $info
     * @param string $reference
     */
    public function __construct(SplFileInfo $info, $reference)
    {
        $this->info = $info;
        $this->reference = $reference;
    }

    /**
     * @return SplFileInfo
     */
    public function getFileInfo()
    {
        return $this->info;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
