<?php

namespace SHyx0rmZ\ProjectScanner\ScanResult;

use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class LazyScanResult
 * @package SHyx0rmZ\ProjectScanner\ScanResult
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class LazyScanResult implements ScanResultInterface
{
    /** @var SplFileInfo */
    protected $file;
    /** @var SplFileInfo */
    protected $fileInfoRootDir;
    /** @var SplFileInfo */
    protected $referenceRootDir;
    /** @var string */
    protected $referencePrefix;
    /** @var SplFileInfo */
    protected $info = null;
    /** @var string */
    protected $reference = null;

    /**
     * @param SplFileInfo $file
     * @param SplFileInfo $fileInfoRootDir
     * @param SplFileInfo $referenceRootDir
     * @param string $referencePrefix
     */
    public function __construct(SplFileInfo $file, SplFileInfo $fileInfoRootDir, SplFileInfo $referenceRootDir, $referencePrefix = '')
    {
        $this->file = $file;
        $this->fileInfoRootDir = $fileInfoRootDir;
        $this->referenceRootDir = $referenceRootDir;
        $this->referencePrefix = $referencePrefix ? $referencePrefix . DIRECTORY_SEPARATOR : '';
    }

    /**
     * @inheritdoc
     */
    public function getFileInfo()
    {
        if ($this->info === null) {
            $this->info = new SplFileInfo(
                $this->file->getRealPath(),
                Util::getRelativePath($this->file->getRealPath(), $this->fileInfoRootDir->getPath()),
                Util::getRelativePathname($this->file->getRealPath(), $this->fileInfoRootDir->getPath())
            );
        }

        return $this->info;
    }

    /**
     * @inheritdoc
     */
    public function getReference()
    {
        if ($this->reference === null) {
            $this->reference = $this->referencePrefix . Util::getRelativePathname($this->file->getRealPath(), $this->referenceRootDir->getRealPath());
            $this->reference = Util::getReference($this->reference);
        }

        return $this->reference;
    }
}
