<?php

namespace SHyx0rmZ\ProjectScanner;

use SHyx0rmZ\ProjectScanner\Scanner\SourceScanner;
use SHyx0rmZ\ProjectScanner\Scanner\VendorScanner;

class ProjectScanner
{
    /** @var SourceScanner */
    private $sourceScanner;
    /** @var VendorScanner */
    private $vendorScanner;

    public function __construct(ScannerFactory $scannerFactory)
    {
        $this->sourceScanner = $scannerFactory->create(ScannerFactory::SOURCE_SCANNER);
        $this->vendorScanner = $scannerFactory->create(ScannerFactory::VENDOR_SCANNER);
    }

    public function findInDirectory($name)
    {
        foreach ($this->sourceScanner->findInDirectory($name) as $scanResult) {
            yield $scanResult;
        }

        foreach ($this->vendorScanner->findInDirectory($name) as $scanResult) {
            yield $scanResult;
        }
    }
}
