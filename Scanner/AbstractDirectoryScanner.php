<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AbstractDirectoryScanner
 * @package SHyx0rmZ\ProjectScanner\Scanner
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
abstract class AbstractDirectoryScanner implements ScannerInterface
{
    /** @var SplFileInfo */
    protected $baseDir;

    /**
     * @return string
     */
    abstract public function getBaseDirSuffix();

    /**
     * @param string $baseDir
     * @param string $projectDir
     */
    public function __construct($baseDir = '', $projectDir = '')
    {
        $projectDir = $projectDir ?: Util::modifyPath(__DIR__, '../../../..');
        $baseDir = $baseDir ?: Util::modifyPath(__DIR__, '../../../../' . $this->getBaseDirSuffix());

        $this->baseDir = new SplFileInfo(
            $baseDir,
            Util::getRelativePath($baseDir, $projectDir),
            Util::getRelativePathname($baseDir, $projectDir)
        );
    }
}
