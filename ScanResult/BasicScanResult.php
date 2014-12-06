<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use Symfony\Component\Finder\SplFileInfo;

/**
 * Class BasicScanResult
 * @package SHyx0rmZ\ProjectScanner\ScanResult
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class BasicScanResult implements ScanResultInterface
{
    /** @var SplFileInfo */
    private $info;
    /** @var string */
    private $reference;

    /**
     * @param SplFileInfo $info
     * @param string $reference
     */
    public function __construct(SplFileInfo $info, $reference)
    {
        $this->info = $info;
        $this->reference = $reference;
    }

    /**
     * @inheritdoc
     */
    public function getFileInfo()
    {
        return $this->info;
    }

    /**
     * @inheritdoc
     */
    public function getReference()
    {
        return $this->reference;
    }
}
