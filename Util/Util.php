<?php

namespace SHyx0rmZ\ProjectScanner\Util;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class Util
 * @package SHyx0rmZ\ProjectScanner\Util
 * @author Patrick Pokatilo <mail@shyxormz.net>
 */
class Util
{
    /**
     * @param string $path
     * @param string $base
     * @return string
     */
    public static function getInverseRelativePathname($path, $base)
    {
        return preg_replace('/' . $base .  '$/', '', $path);
    }

    /**
     * @param string $path
     * @param string $root
     * @return string
     */
    public static function getRelativePath($path, $root)
    {
        return dirname(self::getRelativePathname($path, $root));
    }

    /**
     * @param string $path
     * @param string $root
     * @return string
     */
    public static function getRelativePathname($path, $root)
    {
        $path = realpath($path);
        $root = realpath($root) . DIRECTORY_SEPARATOR;

        if (strpos($path, $root) === 0) {
            $path = str_replace($root, '', $path);
        }

        return $path;
    }

    /**
     * @param string $path
     * @return string
     */
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
     * @return SplFileInfo[]
     */
    public static function findInDirectory($name, $path)
    {
        $finder = new FileInDirectoryFinder();

        return $finder->findInDirectory($name, $path);
    }

    /**
     * @param string $rootPath
     * @param string $relativePath
     * @return string
     */
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
