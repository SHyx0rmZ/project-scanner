<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;

interface ScannerInterface
{
    /**
     * @param string $name
     * @return ScanResultInterface[]
     */
    public function findInDirectory($name);
}
