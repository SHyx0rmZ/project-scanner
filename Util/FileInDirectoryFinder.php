<?php

namespace SHyx0rmZ\ProjectScanner\Util;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FileInDirectoryFinder
{
    /**
     * @param string $name
     * @param string $path
     * @return SplFileInfo[]
     */
    public function findInDirectory($name, $path)
    {
        $directoryFinder = new Finder();
        $directoryFinder->directories()->in($path)->name($name);

        /** @var SplFileInfo $directory */
        foreach ($directoryFinder as $directory) {
            $fileFinder = new Finder();
            $fileFinder->files()->in($directory->getRealPath());

            /** @var SplFileInfo $file */
            foreach ($fileFinder as $file) {
                yield $file;
            }
        }
    }
}
