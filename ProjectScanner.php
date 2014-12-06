<?php

namespace SHyx0rmZ\ProjectScanner;

use SHyx0rmZ\ProjectScanner\Scanner\SourceScanner;
use SHyx0rmZ\ProjectScanner\Scanner\VendorScanner;
use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;

/**
 * Class ProjectScanner
 * @package SHyx0rmZ\ProjectScanner
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class ProjectScanner
{
    /** @var SourceScanner */
    private $sourceScanner;
    /** @var VendorScanner */
    private $vendorScanner;

    /**
     * @param ScannerFactory $scannerFactory
     */
    public function __construct(ScannerFactory $scannerFactory = null)
    {
        if ($scannerFactory == null) {
            $scannerFactory = new ScannerFactory();
        }

        $this->sourceScanner = $scannerFactory->create(ScannerFactory::SOURCE_SCANNER);
        $this->vendorScanner = $scannerFactory->create(ScannerFactory::VENDOR_SCANNER);

        assert($this->sourceScanner instanceof SourceScanner);
        assert($this->vendorScanner instanceof VendorScanner);
    }

    /**
     * @param string $name
     * @return ScanResultInterface[]
     */
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
