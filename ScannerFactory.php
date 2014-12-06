<?php

namespace SHyx0rmZ\ProjectScanner;

use SHyx0rmZ\ProjectScanner\Scanner\SourceScanner;
use SHyx0rmZ\ProjectScanner\Scanner\VendorScanner;

class ScannerFactory
{
    const SOURCE_SCANNER = SourceScanner::class;
    const VENDOR_SCANNER = VendorScanner::class;

    public function create($type)
    {
        return new $type();
    }
}
