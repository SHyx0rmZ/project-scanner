<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

/**
 * Interface ScanResultInterface
 * @package SHyx0rmZ\ProjectScanner\ScanResult
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
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
