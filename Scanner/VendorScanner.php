<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\LazyScanResult;
use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;
use SHyx0rmZ\ProjectScanner\Util\ComposerLibraryFinder;
use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class VendorScanner
 * @package SHyx0rmZ\ProjectScanner\Scanner
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class VendorScanner extends AbstractDirectoryScanner
{
    /** @var ComposerLibraryFinder */
    private $composerLibraryFinder;

    /**
     * @param ComposerLibraryFinder $composerLibraryFinder
     * @param string $baseDir
     * @param string $projectDir
     */
    public function __construct(ComposerLibraryFinder $composerLibraryFinder, $baseDir = '', $projectDir = '')
    {
        parent::__construct($baseDir, $projectDir);

        $this->composerLibraryFinder = $composerLibraryFinder;
    }

    /**
     * @inheritdoc
     */
    public function getBaseDirSuffix()
    {
        return 'vendor';
    }

    /**
     * @inheritdoc
     */
    public function findInDirectory($name)
    {
        /** @var ScanResultInterface $entry */
        foreach ($this->composerLibraryFinder->findLibraries($this->baseDir->getRealPath()) as $entry) {
            if ($entry->getFileInfo()->isDir()) {
                foreach (Util::findInDirectory($name, $entry->getFileInfo()->getRealPath()) as $file) {
                    yield new LazyScanResult($file, $this->baseDir, $entry->getFileInfo(), $entry->getReference());
                }
            } elseif ($entry->getFileInfo()->isFile()) {
                $relativePathname = Util::getRelativePathname($entry->getFileInfo()->getRealPath(), $this->baseDir->getRealPath());

                if (in_array($name, explode(DIRECTORY_SEPARATOR, $relativePathname))) {
                    $parent = new SplFileInfo(
                        $entry->getFileInfo()->getPath(),
                        Util::getRelativePath($entry->getFileInfo()->getPath(), $this->baseDir->getRealPath()),
                        Util::getRelativePathname($entry->getFileInfo()->getPath(), $this->baseDir->getRealPath())
                    );

                    yield new LazyScanResult(
                        $entry->getFileInfo(),
                        $this->baseDir,
                        $parent,
                        Util::getInverseRelativePathname($entry->getReference(), $entry->getFileInfo()->getBasename('.php'))
                    );
                }
            }
        }
    }
}
