<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\SourceScanResult;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SourceScanner implements ScannerInterface
{
    /**
     * @inheritdoc
     */
    public function findInDirectory($name)
    {
        $directoryFinder = new Finder();
        $directoryFinder->directories()->in(__DIR__ . '/../../../../src')->name($name);

        /** @var SplFileInfo $directory */
        foreach ($directoryFinder as $directory) {
            $fileFinder = new Finder();
            $fileFinder->files()->in($directory->getRealPath());

            /** @var SplFileInfo $file */
            foreach ($fileFinder as $file) {
                $info = new SplFileInfo(
                    $file->getRealPath(),
                    'src/' . $directory->getRelativePathname() . (!empty($file->getRelativePath()) ?  DIRECTORY_SEPARATOR . $file->getRelativePath() : ''),
                    'src/' . $directory->getRelativePathname() . DIRECTORY_SEPARATOR . $file->getRelativePathname()
                );

                yield new SourceScanResult($info);
            }
        }

    }
}
