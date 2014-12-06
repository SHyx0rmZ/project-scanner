<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

class SourceScanResult extends LazyScanResult
{
    function __construct(SplFileInfo $sourceDir, SplFileInfo $file)
    {
        parent::__construct($file, $sourceDir, $sourceDir);
    }
}
