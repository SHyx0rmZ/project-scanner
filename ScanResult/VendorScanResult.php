<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

class VendorScanResult implements ScanResultInterface
{
    /** @var SplFileInfo */
    private $info;
    /** @var string */
    private $reference;

    public function __construct(SplFileInfo $info, $reference)
    {
        $this->info = $info;
        $this->reference = $reference;
    }

    public function getFileInfo()
    {
        return $this->info;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
