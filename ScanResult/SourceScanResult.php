<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\SplFileInfo;

class SourceScanResult implements ScanResultInterface
{
    /** @var SplFileInfo */
    protected $sourceDir;
    /** @var SplFileInfo */
    private $info = null;
    /** @var string */
    private $reference = null;

    function __construct(SplFileInfo $sourceDir, SplFileInfo $file)
    {
        $this->sourceDir = $sourceDir;

        $this->info = new SplFileInfo(
            $file->getRealPath(),
            Util::getRelativePath($file->getRealPath(), $this->sourceDir->getPath()),
            Util::getRelativePathname($file->getRealPath(), $this->sourceDir->getPath())
        );
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
        if ($this->reference === null) {
            $this->reference = Util::getRelativePathname($this->info->getRealPath(), $this->sourceDir->getRealPath());
            $this->reference = Util::getReference($this->reference);
        }

        return $this->reference;
    }
}
