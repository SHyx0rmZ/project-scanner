<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

class VendorScanResult extends LazyScanResult
{
    public function __construct(SplFileInfo $vendorRoot, SplFileInfo $vendorPath, SplFileInfo $file, $namespace)
    {
        parent::__construct($file, $vendorRoot, $vendorPath, $namespace);
    }
}
