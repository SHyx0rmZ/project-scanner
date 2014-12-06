<?php

namespace SHyx0rmZ\ProjectScanner\Util;

use SHyx0rmZ\ProjectScanner\ScanResult\BasicScanResult;
use Symfony\Component\Finder\SplFileInfo;

class ComposerAutoloadProvider
{
    /**
     * @var array
     */
    private $autoloadDirs = array(
        'autoload_psr4.php',
//        'autoload_classmap.php',
        'autoload_namespaces.php',
    );

    /**
     * @return \Generator
     */
    public function findLibraries($vendorDir)
    {
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
                    $info = new SplFileInfo(
                        $includeDir,
                        Util::getRelativePath($includeDir, $vendorDir),
                        Util::getRelativePathname($includeDir, $vendorDir)
                    );

                    yield new BasicScanResult($info, $namespace);
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
}
