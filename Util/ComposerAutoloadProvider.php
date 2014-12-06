<?php

namespace SHyx0rmZ\ProjectScanner\Util;

use SHyx0rmZ\ProjectScanner\ScanResult\BasicScanResult;
use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;
use Symfony\Component\Finder\SplFileInfo;

class ComposerAutoloadProvider
{
    /** @var array */
    private $namespaceFiles = array(
        'autoload_psr4.php',
        'autoload_namespaces.php',
    );

    /** @var array */
    private $classmapFiles = array(
        'autoload_classmap.php',
    );

    /**
     * @param string $vendorDir
     * @return ScanResultInterface[]
     */
    public function findLibraries($vendorDir)
    {
        foreach ($this->findLibrariesNamespace($vendorDir) as $scanResult) {
            yield $scanResult;
        }

        foreach ($this->findLibrariesClassmap($vendorDir) as $scanResult) {
            yield $scanResult;
        }
    }

    /**
     * @param string $namespace
     * @param string $vendorDir
     * @param SplFileInfo $entry
     * @return BasicScanResult
     */
    private function buildScanResult($namespace, $vendorDir, $entry)
    {
        $info = new SplFileInfo(
            $entry,
            Util::getRelativePath($entry, $vendorDir),
            Util::getRelativePathname($entry, $vendorDir)
        );

        return new BasicScanResult($info, $namespace);
    }

    /**
     * @param string $vendorDir
     * @return ScanResultInterface[]
     */
    private function findLibrariesNamespace($vendorDir)
    {
        foreach ($this->namespaceFiles as $namespaceFile) {
            foreach ($this->getVendorMap($vendorDir, $namespaceFile) as $namespace => $directories) {
                if (empty($namespace)) {
                    continue;
                }

                if (!is_array($directories)) {
                    $directories = array($directories);
                }

                foreach ($directories as $directory) {
                    yield $this->buildScanResult($namespace, $vendorDir, $directory);
                }
            }
        }
    }

    /**
     * @param string $vendorDir
     * @return ScanResultInterface[]
     */
    private function findLibrariesClassmap($vendorDir)
    {
        foreach ($this->classmapFiles as $classmapFile) {
            foreach ($this->getVendorMap($vendorDir, $classmapFile) as $namespace => $file) {
                yield $this->buildScanResult($namespace, $vendorDir, $file);
            }
        }
    }

    /**
     * @param string $vendorDir
     * @param string $vendorFile
     * @return array
     */
    private function getVendorMap($vendorDir, $vendorFile)
    {
        $autoloadFile = new SplFileInfo(
            Util::modifyPath($vendorDir, 'composer/' . $vendorFile),
            'composer',
            'composer/' . $vendorFile
        );

        if (!$autoloadFile->isFile()) {
            return array();
        }

        /** @var array $map */
        $map = require($autoloadFile->getRealPath());

        assert(is_array($map));

        return $map;
    }
}
