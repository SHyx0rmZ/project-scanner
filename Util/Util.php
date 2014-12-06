<?php

namespace SHyx0rmZ\ProjectScanner\Util;

class Util
{
    public static function getInverseRelativePathname($path, $base)
    {
        return preg_replace('/' . $base .  '$/', '', $path);
    }

    public static function getRelativePath($path, $root)
    {
        return dirname(self::getRelativePathname($path, $root));
    }

    public static function getRelativePathname($path, $root)
    {
        $path = realpath($path);
        $root = realpath($root) . DIRECTORY_SEPARATOR;

        if (strpos($path, $root) === 0) {
            $path = str_replace($root, '', $path);
        }

        return $path;
    }

    public static function getReference($path)
    {
        $reference = (dirname($path) != '.' ? dirname($path) . DIRECTORY_SEPARATOR : '') . basename($path, '.php');
        $reference = str_replace(DIRECTORY_SEPARATOR, '\\', $reference);
        $reference = str_replace('\\\\', '\\', $reference);

        return $reference;
    }

    /**
     * @param string $name
     * @param string $path
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    public static function findInDirectory($name, $path)
    {
        $finder = new FileInDirectoryFinder();

        return $finder->findInDirectory($name, $path);
    }

    public static function modifyPath($rootPath, $relativePath)
    {
        $modifiedPath = $rootPath;

        foreach (explode('/', $relativePath) as $pathElement) {
            if ($pathElement == '..') {
                $modifiedPath = dirname($modifiedPath);
            } else {
                $modifiedPath .= DIRECTORY_SEPARATOR . $pathElement;
            }
        }

        return $modifiedPath;
    }
}
