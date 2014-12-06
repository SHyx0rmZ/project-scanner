<?php

namespace SHyx0rmZ\ProjectScanner;

use SHyx0rmZ\ProjectScanner\Scanner\ScannerInterface;
use SHyx0rmZ\ProjectScanner\Scanner\SourceScanner;
use SHyx0rmZ\ProjectScanner\Scanner\VendorScanner;
use SHyx0rmZ\ProjectScanner\Util\ComposerLibraryFinder;

/**
 * Class ScannerFactory
 * @package SHyx0rmZ\ProjectScanner
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class ScannerFactory
{
    const SOURCE_SCANNER = SourceScanner::class;
    const VENDOR_SCANNER = VendorScanner::class;

    /**
     * @param string $type
     * @return ScannerInterface
     * @throws \UnexpectedValueException
     */
    public function create($type)
    {
        switch ($type) {
            case static::SOURCE_SCANNER:
                return new SourceScanner();
            case static::VENDOR_SCANNER:
                return new VendorScanner(new ComposerLibraryFinder());
        }

        throw new \UnexpectedValueException('Factory does not know how to create type: ' . $type);
    }
}
