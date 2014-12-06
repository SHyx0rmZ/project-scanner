<?php

namespace SHyx0rmZ\ProjectScanner;

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
//        return array_merge(
//            $this->sourceScanner->findInDirectory($name),
//            $this->vendorScanner->findInDirectory($name)
//        );
        foreach ($this->sourceScanner->findInDirectory($name) as $scanResult) {
            yield $scanResult;
        }

        foreach ($this->vendorScanner->findInDirectory($name) as $scanResult) {
            yield $scanResult;
        }
    }
}
