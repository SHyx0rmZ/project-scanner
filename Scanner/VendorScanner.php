<?php

namespace SHyx0rmZ\ProjectScanner\Scanner;

use SHyx0rmZ\ProjectScanner\ScanResult\VendorScanResult;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class VendorScanner implements ScannerInterface
{

    /**
     * @var array
     */
    private $autoloadDirs = array(
        'include_paths.php',
        'autoload_namespaces.php',
        'autoload_psr4.php',
        'autoload_classmap.php',
        'autoload_files.php'
    );

    /**
     * @return string[]
     */
    public function yieldIncludeDirectories()
    {
        $vendorDir = __DIR__ . '/../../..';

        foreach ($this->autoloadDirs as $autoloadDir) {
            $autoloadFile = $vendorDir . '/composer/' . $autoloadDir;

            if (!is_file($autoloadFile)) {
                continue;
            }

            $autoloadMaps = require($autoloadFile);

            foreach ($autoloadMaps as $namespace => $autoloadMap) {
                $namespace = $this->normalizeNamespace($namespace);
                $autoloadMap = $this->normalizeAutoloadMap($autoloadMap);

                if ($namespace == '') {
                    continue;
                }

                foreach ($autoloadMap as $includeDir) {
                    yield $namespace => $includeDir;
                }
            }
        }
    }

    /**
     * @param $namespace
     * @return string
     */
    private function normalizeNamespace($namespace)
    {
        if (!is_string($namespace)) {
            $namespace = '';
        }

        return $namespace;
    }

    /**
     * @param $autoloadMap
     * @return array
     */
    private function normalizeAutoloadMap($autoloadMap)
    {
        if (!is_array($autoloadMap)) {
            $autoloadMap = array($autoloadMap);
        }

        return $autoloadMap;
    }

    /**
     * @inheritdoc
     */
    public function findInDirectory($name)
    {
        $vendor = new SplFileInfo(
            __DIR__ . '/../../../..',
            '',
            ''
        );

        foreach ($this->yieldIncludeDirectories() as $namespace => $include) {
            if (!is_dir($include)) {
                continue;
            }

            $directoryFinder = new Finder();
            $directoryFinder->directories()->in($include)->name($name);

            /** @var SplFileInfo $directory */
            foreach ($directoryFinder as $directory) {
                $fileFinder = new Finder();
                $fileFinder->files()->in($directory->getRealPath());

                /** @var SplFileInfo $file */
                foreach ($fileFinder as $file) {
                    $relativePathname = substr($file->getRealPath(), strlen($vendor->getRealPath() . DIRECTORY_SEPARATOR));

                    $info = new SplFileInfo(
                        $file->getRealPath(),
                        dirname($relativePathname),
                        $relativePathname
                    );

                    $reference = $namespace;
                    $reference .= !empty($directory->getRelativePathname()) ? $directory->getRelativePathname() . DIRECTORY_SEPARATOR : '';
                    $reference .= $file->getRelativePath() . DIRECTORY_SEPARATOR . $file->getBasename('.php');
                    $reference = str_replace(DIRECTORY_SEPARATOR, '\\', $reference);
                    $reference = str_replace('\\\\', '\\', $reference);

                    yield new VendorScanResult($info, $reference);
                }
            }

        }
    }
}
