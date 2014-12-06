<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\LazyScanResult;
use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class SourceScanner
 * @package SHyx0rmZ\ProjectScanner\Scanner
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class SourceScanner extends AbstractDirectoryScanner
{
    /**
     * @inheritdoc
     */
    public function getBaseDirSuffix()
    {
        return 'src';
    }

    /**
     * @inheritdoc
     */
    public function findInDirectory($name)
    {
        /** @var SplFileInfo $file */
        foreach (Util::findInDirectory($name, $this->baseDir->getRealPath()) as $file) {
            yield new LazyScanResult($file, $this->baseDir, $this->baseDir);
        }
    }
}
