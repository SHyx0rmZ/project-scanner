<?php

namespace SHyx0rmZ\ProjectScanner\Util;

use SHyx0rmZ\ProjectScanner\ScanResult\ScanResultInterface;

class ComposerAutoloadEntry implements ScanResultInterface
{
    private $info;
    private $reference;

    public function __construct($info, $reference)
    {
        $this->info = $info;
        $this->reference = $reference;
    }

    public function getFileInfo()
    {
        return $this->info;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
