<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;

/**
 * Interface ScannerInterface
 * @package SHyx0rmZ\ProjectScanner\Scanner
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
interface ScannerInterface
{
    /**
     * Finds files residing in a sub directory called $name
     * @param string $name
     * @return ScanResultInterface[]
     */
    public function findInDirectory($name);
}
