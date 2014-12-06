<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

interface ScanResultInterface
{
    /**
     * @return SplFileInfo
     */
    public function getFileInfo();

    /**
     * @return string
     */
    public function getReference();
}
