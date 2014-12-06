<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\SplFileInfo;

class VendorScanResult implements ScanResultInterface
{
    /** @var string */
    protected $vendorRoot;
    /** @var string */
    protected $vendorPath;
    /** @var SplFileInfo */
    protected $file;
    /** @var string */
    protected $namespace;
    /** @var SplFileInfo */
    private $info = null;
    /** @var string */
    private $reference = null;

    public function __construct(SplFileInfo $vendorRoot, SplFileInfo $vendorPath, SplFileInfo $file, $namespace)
    {
        $this->vendorRoot = $vendorRoot;
        $this->vendorPath = $vendorPath;
        $this->file = $file;
        $this->namespace = $namespace;
    }

    public function getFileInfo()
    {
        if ($this->info === null) {
            $this->info = new SplFileInfo(
                $this->file->getRealPath(),
                Util::getRelativePath($this->file->getRealPath(), $this->vendorRoot->getRelativePath()),
                Util::getRelativePathname($this->file->getRealPath(), $this->vendorRoot->getRelativePath())
            );
        }

        return $this->info;
    }

    public function getReference()
    {
        if ($this->reference === null) {
            $this->reference = $this->namespace . Util::getRelativePathname($this->file->getRealPath(), $this->vendorPath->getRealPath());
            $this->reference = Util::getReference($this->reference);
        }

        return $this->reference;
    }
}
