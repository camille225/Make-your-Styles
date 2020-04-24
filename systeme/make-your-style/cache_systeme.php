<?php declare(strict_types=1);

class Mf_Cache_systeme
{

    private $dossier_cache;

    function __construct()
    {
        $this->dossier_cache = get_dossier_data('systeme', 'cache');
    }

    function read(string $cle)
    {
        $filename = $this->dossier_cache . md5($cle);
        if (file_exists($filename)) {
            return unserialize(file_get_contents($filename));
        }
        return false;
    }

    function write(string $cle, $variable)
    {
        $filename = $this->dossier_cache . md5($cle);
        file_put_contents($filename, serialize($variable));
    }

    function clear()
    {
        $files = glob("{$this->dossier_cache}*");
        foreach ($files as $file) {
            unlink($file);
        }
    }
}
