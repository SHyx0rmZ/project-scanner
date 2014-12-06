<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\Builder\VendorScanResultBuilder;
use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;
use SHyx0rmZ\ProjectScanner\ScanResult\VendorScanResult;
use SHyx0rmZ\ProjectScanner\Util\ComposerAutoloadProvider;
use SHyx0rmZ\ProjectScanner\Util\FileInDirectoryFinder;
use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class VendorScanner implements ScannerInterface
{
    /** @var ComposerAutoloadProvider */
    private $composerAutoloadProvider;
    /** @var SplFileInfo */
    private $vendorDir;

    public function __construct(ComposerAutoloadProvider $composerAutoloadProvider, $vendorDir = null, $projectDir = null)
    {
        $this->composerAutoloadProvider = $composerAutoloadProvider;

        $projectDir = $projectDir ?: Util::modifyPath(__DIR__, '../../../..');
        $vendorDir = $vendorDir ?: Util::modifyPath(__DIR__, '../../../../vendor');

        $this->vendorDir = new SplFileInfo(
            $vendorDir,
            Util::getRelativePath($vendorDir, $projectDir),
            Util::getRelativePathname($vendorDir, $projectDir)
        );
    }

    /**
     * @inheritdoc
     */
    public function findInDirectory($name)
    {
        /** @var ScanResultInterface $entry */
        foreach ($this->composerAutoloadProvider->findLibraries($this->vendorDir->getRealPath()) as $entry) {
            if ($entry->getFileInfo()->isDir()) {
                foreach (Util::findInDirectory($name, $entry->getFileInfo()->getRealPath()) as $file) {
                    yield new VendorScanResult($this->vendorDir, $entry->getFileInfo(), $file, $entry->getReference());
                }
            } elseif ($entry->getFileInfo()->isFile()) {
                $relativePathname = Util::getRelativePathname($entry->getFileInfo()->getRealPath(), $this->vendorDir->getRealPath());

                if (in_array($name, explode(DIRECTORY_SEPARATOR, $relativePathname))) {
                    yield $entry;
                }
            }
        }
    }
}
