<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\SourceScanResult;
use SHyx0rmZ\ProjectScanner\Util\Util;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SourceScanner implements ScannerInterface
{
    private $sourceDir;

    public function __construct($sourceDir = null, $projectDir = null)
    {
        $projectDir = $projectDir ?: Util::modifyPath(__DIR__, '../../../..');
        $sourceDir = $sourceDir ?: Util::modifyPath(__DIR__, '../../../../src');

        $this->sourceDir = new SplFileInfo(
            $sourceDir,
            Util::getRelativePath($sourceDir, $projectDir),
            Util::getRelativePathname($sourceDir, $projectDir)
        );
    }

    /**
     * @inheritdoc
     */
    public function findInDirectory($name)
    {
        /** @var SplFileInfo $file */
        foreach (Util::findInDirectory($name, $this->sourceDir->getRealPath()) as $file) {
            yield new SourceScanResult($this->sourceDir, $file);
        }
    }
}
