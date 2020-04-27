<?php declare(strict_types=1);

class Cache
{

    private $dossier_cache;
    private $sous_dossier;

    private $microtime_1;
    private $microtime_2;

    private static $nb_lectures_disque;

    private $execution_time = [];

    function __construct(string $dossier_cache = 'default', $sous_dossier = 'default') // Possibilité de catégoriser les pages ...
    {
        // Premier niveau de cache
        $this->dossier_cache = get_dossier_data('cache', 'cache') . "$dossier_cache/";
        if (! file_exists($this->dossier_cache)) {
            @mkdir($this->dossier_cache);
        }
        $this->microtime_1 = $this->dossier_cache . 'microtime';
        $this->sous_dossier = $sous_dossier;
        // Deuxième niveau de cache
        $this->dossier_cache .= $sous_dossier . '/';
        if (! file_exists($this->dossier_cache)) {
            @mkdir($this->dossier_cache);
        }
        $this->microtime_2 = $this->dossier_cache . 'microtime';
    }

    private function initialisation_cache()
    {
        if (! file_exists($this->microtime_1)) {
            $this->clear();
        }
        if (! file_exists($this->microtime_2)) {
            $this->clear_local();
        }
    }

    function read(string $cle, $undifundefined_value = false)
    {
        $cle = md5($cle);
        $this->initialisation_cache();
        $r = @file_get_contents($this->microtime_1);
        if ($r !== false) {
            $microtime_1 = unserialize($r);
            $r = @file_get_contents($this->microtime_2);
            if ($r !== false) {
                $microtime_2 = unserialize($r);
                $microtime = max([
                    $microtime_1,
                    $microtime_2
                ]);
                $filename = $this->dossier_cache . $cle;
                if (file_exists($filename)) {
                    $r = @file_get_contents($filename);
                    if ($r !== false) {
                        $r = unserialize($r);
                        if ($r['u'] > $microtime) {
                            self::$nb_lectures_disque ++;
                            return $r['v'];
                        }
                    }
                }
            }
        }
        $this->execution_time[$cle] = microtime(true);
        return $undifundefined_value;
    }

    /**
     * Retourne la liste des variables locales à jours
     * [name1 => valeur1, ...]
     * @return array
     */
    function read_all(): array
    {
        $liste = [];
        $this->initialisation_cache();
        $r = @file_get_contents($this->microtime_1);
        if ($r !== false) {
            $microtime_1 = unserialize($r);
            $r = @file_get_contents($this->microtime_2);
            if ($r !== false) {
                $microtime_2 = unserialize($r);
                $microtime = max([
                    $microtime_1,
                    $microtime_2
                ]);
                $files = glob("{$this->dossier_cache}*");
                foreach ($files as $filename) {
                    if (file_exists($filename)) {
                        $r = @file_get_contents($filename);
                        if ($r !== false) {
                            $r = unserialize($r);
                            if ($r['u'] > $microtime) {
                                self::$nb_lectures_disque ++;
                                $liste[$r['n']] = $r['v'];
                            }
                        }
                    }
                }
            }
        }
        return $liste;
    }

    function write(string $name, $variable)
    {
        $cle = md5($name);
        if (isset($this->execution_time[$cle])) {
            $start = $this->execution_time[$cle];
            $stop = microtime(true);
            $execution_time = $stop - $start;
        } else {
            $execution_time = 0;
        }
        microtime(true);
        $filename = "$this->dossier_cache$cle";
        file_put_contents($filename, serialize([
            'u' => microtime(true),
            'v' => $variable,
            't' => $execution_time,
            'n' => $name
        ]));
    }

    function clear()
    {
        file_put_contents($this->microtime_1, serialize(microtime(true) + 0.001));
    }

    function clear_local()
    {
        file_put_contents($this->microtime_2, serialize(microtime(true) + 0.001));
    }

    function get_adress(string $cle): string
    {
        return $this->dossier_cache . md5($cle);
    }
}
