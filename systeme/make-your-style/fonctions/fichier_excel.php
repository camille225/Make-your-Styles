<?php

class Fichier_Excel
{

    // partie privée
    private $onglets = [];

    private $conversion_name_onglet_vers_num = [];

    private $conversion_pos = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
        'D' => 4,
        'E' => 5,
        'F' => 6,
        'G' => 7,
        'H' => 8,
        'I' => 9,
        'J' => 10,
        'K' => 11,
        'L' => 12,
        'M' => 13,
        'N' => 14,
        'O' => 15,
        'P' => 16,
        'Q' => 17,
        'R' => 18,
        'S' => 19,
        'T' => 20,
        'U' => 21,
        'V' => 22,
        'W' => 23,
        'X' => 24,
        'Y' => 25,
        'Z' => 26
    ];

    /**
     *
     * @param string $str
     * @return string
     */
    private function standardisation(string $str): string
    {
        $v = [];
        for ($i=0; $i<26; $i++) {
            $c = substr("abcdefghijklmnopqrstuvwxyz", $i, 1);
            $v["<$c:"] = "<";
            $v["</$c:"] = "</";
        }
        return strtr($str, $v);
    }

    private $db_table_name = null;

    private $db_column_column_sheet = null;

    private $db_column_column_row = null;

    private $db_column_col = null;

    private $db_column_list_ref = [];

    private $log = [];

    // The number of bytes to return
    private $zip_entry_read_length = 67108864;

    /**
     * Fichier_Excel constructor.
     * @param string $adresse
     */
    function __construct(string $adresse)
    {
        $zip = zip_open($adresse);
        if (is_resource($zip)) {
            $dictionnaire = [];
            while ($file = zip_read($zip)) {
                // liste des onglets
                if (zip_entry_name($file) == 'xl/workbook.xml') {
                    $elem = new SimpleXMLElement($this->standardisation(zip_entry_read($file, $this->zip_entry_read_length)));
                    $i = 1;
                    foreach ($elem->sheets->sheet as $sheet) {
                        $name = (string) $sheet['name'];
                        $this->onglets[$i]['name'] = $name;
                        $this->conversion_name_onglet_vers_num[$name] = $i;
                        $i ++;
                    }
                }
                // dictionnaire
                if (zip_entry_name($file) == 'xl/sharedStrings.xml') {
                    $elem = new SimpleXMLElement($this->standardisation(zip_entry_read($file, $this->zip_entry_read_length)));
                    foreach ($elem->si as $si) {
                        $dictionnaire[] = (string) $si->t;
                    }
                }
                if (substr(zip_entry_name($file), 0, 19) == 'xl/worksheets/sheet') {
                    $i = (int) round(substr(zip_entry_name($file), 19));
                    $elem = new SimpleXMLElement($this->standardisation(zip_entry_read($file, $this->zip_entry_read_length)));
                    $this->onglets[$i]['objet'] = $elem;
                }
            }
            zip_close($zip);
            // Indexation des cellules
            foreach ($this->onglets as &$onglet) {
                $row_min = null;
                $row_max = null;
                $col_min = null;
                $col_max = null;
                foreach ($onglet['objet']->sheetData->row as $row) {
                    $ref_row = '';
                    foreach ($row->attributes() as $a => $b) {
                        if ($a == 'r') {
                            $ref_row = $b;
                        }
                    }
                    foreach ($row->c as $c) {
                        if ((string) $c->v !== '') {
                            $ref_cell = '';
                            $lookup_value = false;
                            foreach ($c->attributes() as $a => $b) {
                                if ($a == 'r') {
                                    $ref_cell = $b;
                                }
                                if ($a == 't') {
                                    $lookup_value = true;
                                }
                            }
                            $ref_col = str_replace($ref_row, '', $ref_cell);
                            $ref_col_ = str_split(strrev($ref_col));
                            $ref_col = 0;
                            foreach ($ref_col_ as $n => $l) {
                                $ref_col += (int) ($this->conversion_pos[$l] * pow(26, $n));
                            }
                            $ref_row = (int) $ref_row;
                            $onglet['data'][$ref_row][$ref_col] = ($lookup_value ? $dictionnaire[(int) $c->v] : $c->v);
                            if ($row_min === null) {
                                $row_min = $ref_row;
                                $row_max = $ref_row;
                                $col_min = $ref_col;
                                $col_max = $ref_col;
                            } else {
                                if ($ref_row < $row_min) {
                                    $row_min = $ref_row;
                                }
                                if ($ref_row > $row_max) {
                                    $row_max = $ref_row;
                                }
                                if ($ref_col < $col_min) {
                                    $col_min = $ref_col;
                                }
                                if ($ref_col > $col_max) {
                                    $col_max = $ref_col;
                                }
                            }
                        }
                    }
                }
                unset($onglet['objet']);
                $onglet['properties'] = [
                    'row_min' => $row_min,
                    'row_max' => $row_max,
                    'col_min' => $col_min,
                    'col_max' => $col_max
                ];
            }
        }
    }

    /**
     * Fichier_Excel destructor.
     */
    function __destruct()
    {
        if ($this->db_table_name !== null && count($this->log) > 0) {
            global $link;
            $db = new DB();
            $cond_sql = [];
            foreach ($this->db_column_list_ref as $key => $value) {
                $cond_sql[] = "$key=$value";
            }
            $liste_log = $db->mf_table($this->db_table_name)->mf_lister_3([
                OPTION_COND_MYSQL => $cond_sql
            ]);
            foreach ($liste_log as $log) {
                $nom_onglet = $log[$this->db_column_column_sheet];
                $row = $log[$this->db_column_column_row];
                $col = $log[$this->db_column_col];
                $ind = "{$nom_onglet}x{$row}x{$col}";
                if (isset($this->log[$ind])) {
                    unset($this->log[$ind]);
                }
            }
            $db->mf_table($this->db_table_name)->mf_ajouter_3($this->log);
            $this->log = [];
            if ($link != null) {
                mysqli_close($link);
                $link = null;
            }
        }
    }

    /**
     * @param string $db_table_name
     * @param string $db_column_column_sheet
     * @param string $db_column_column_row
     * @param string $db_column_col
     * @param array $db_column_list_ref
     */
    function definir_statistiques(string $db_table_name, string $db_column_column_sheet, string $db_column_column_row, string $db_column_col, array $db_column_list_ref = [])
    {
        $this->db_table_name = $db_table_name;
        $this->db_column_column_sheet = $db_column_column_sheet;
        $this->db_column_column_row = $db_column_column_row;
        $this->db_column_col = $db_column_col;
        $this->db_column_list_ref = $db_column_list_ref; // = ['col_1' => val_1, ...]
    }

    /**
     * @return array
     */
    function get_liste_onglets(): array
    {
        $liste = [];
        foreach ($this->conversion_name_onglet_vers_num as $name => $value) {
            $liste[] = $name;
        }
        return $liste;
    }

    /**
     *
     * @param string $nom_onglet
     * @return array [row_min, row_max, col_min, col_max]
     */
    function get_properties(string $nom_onglet): array
    {
        $i = $this->conversion_name_onglet_vers_num[$nom_onglet];
        return $this->onglets[$i]['properties'];
    }

    /**
     * @param string $nom_onglet
     * @param int $row
     * @param int $col
     * @return string|null
     */
    function get_value(string $nom_onglet, int $row, int $col): ?string
    {
        if (! isset($this->conversion_name_onglet_vers_num[$nom_onglet])) {
            return null;
        }
        $i = $this->conversion_name_onglet_vers_num[$nom_onglet];
        if ($this->db_table_name !== null) {
            if (isset($this->onglets[$i]['data'][$row][$col])) {
                $v = [
                    $this->db_column_column_sheet => $nom_onglet,
                    $this->db_column_column_row => $row,
                    $this->db_column_col => $col
                ];
                foreach ($this->db_column_list_ref as $key => $value) {
                    $v[$key] = $value;
                }
                $this->log["{$nom_onglet}x{$row}x{$col}"] = $v;
            }
        }
        return (isset($this->onglets[$i]['data'][$row][$col]) ? (string) $this->onglets[$i]['data'][$row][$col] : null);
    }

    /**
     * @param string $nom_onglet
     * @param int $row
     * @param int $col
     * @return string
     */
    function get_value_format_string(string $nom_onglet, int $row, int $col): string
    {
        $v = $this->get_value($nom_onglet, $row, $col);
        return ($v === null ? '' : $v);
    }

    /**
     * @param string $nom_onglet
     * @param int $row
     * @param int $col
     * @return string
     */
    function get_value_format_date_str(string $nom_onglet, int $row, int $col): string
    {
        $v = $this->get_value($nom_onglet, $row, $col);
        $date_str = format_date(substr($v, 6, 4) . '-' . substr($v, 3, 2) . '-' . substr($v, 0, 2));
        if ($date_str != '') {
            return $date_str;
        }
        $v = intval($v);
        if ($v > 0) {
            return date_ajouter_nb_jours("1900-01-01", ($v - 2));
        }
        return '';
    }

    /**
     * @param string $nom_onglet
     * @param int $row
     * @param int $col
     * @return float
     */
    function get_value_format_float(string $nom_onglet, int $row, int $col): float
    {
        $v = $this->get_value($nom_onglet, $row, $col);
        return ($v === null ? 0 : floatval(str_replace(' ', '', str_replace(',', '.', $v))));
    }

    /**
     * @param string $nom_onglet
     * @param int $row
     * @param int $col
     * @return int
     */
    function get_value_format_int(string $nom_onglet, int $row, int $col): int
    {
        $v = $this->get_value($nom_onglet, $row, $col);
        return ($v === null ? 0 : (int) round(str_replace(' ', '', str_replace(',', '.', $v))));
    }
}
