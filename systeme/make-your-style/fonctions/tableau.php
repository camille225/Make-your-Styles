<?php

class Tableau
{

    // partie privee
    private $donnees;

    private $colonnes;

    private $colonne_act_mod_code;

    // ancien systeme
    private $liste_Codes_ref;

    //
    private $liste_initiale;

    private $activer_checkbox;

    private $colonne_checkbox_code;

    private $act;

    private $autre_page;

    private $autre_page_nouvel_onglet;

    private $header;

    private $footer;

    private $class_tableau;

    private $colonne_discriminante;

    private $colonne_class;

    private $action_js;

    private $class;

    private static $num_tableau = 0;

    private $activer_pagination;

    private $colonnes_bouton;

    private $indice_bouton;

    private $colonne_selection;

    private $valeur_selection;

    // partie publique
    function __construct($donnees, $colonne_act_mod_code, $class = '')
    {
        $this->donnees = $donnees;
        $this->colonnes = array();

        if ($colonne_act_mod_code != '')
            $this->colonne_act_mod_code[] = $colonne_act_mod_code;
        else
            $this->colonne_act_mod_code = array();

        $this->liste_initiale = array();
        $this->activer_checkbox = false;

        $this->act = '';

        $this->autre_page = '';
        $this->autre_page_nouvel_onglet = false;

        $this->header = '';

        $this->colonne_discriminante = '';
        $this->colonne_class = '';

        $this->action_js = '';

        $this->class = $class;

        $this->liste_Codes_ref = array();

        $this->activer_pagination = true;

        $this->colonnes_bouton = array();
        $this->indice_bouton = 0;

        $this->colonne_selection = '';
        $this->valeur_selection = 0;
    }

    function ecraser_donnees($donnees)
    {
        $this->donnees = $donnees;
    }

    function desactiver_pagination()
    {
        $this->activer_pagination = false;
    }

    function ajouter_ref_Colonne_Code($libelle_Code_colonne)
    {
        $this->liste_Codes_ref[] = $libelle_Code_colonne;
    }

    function definir_colonne_discriminante($colonne_discriminante)
    {
        $this->colonne_discriminante = $colonne_discriminante;
    }

    function definir_colonne_class($colonne_class)
    {
        $this->colonne_class = $colonne_class;
    }

    function ajouter_colonne($DB_name, $liste, $class, $libelle_entete = '')
    {
        /*
         * $DB_name : le nom de la colonne identique a la base de donnees
         * $liste : vrai ou faux
         *
         */
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'liste' => $liste,
            'class' => $class,
            'special' => '',
            'libelle_entete' => $libelle_entete
        );
    }

    function ajouter_colonne_maj_auto(string $DB_name, bool $liste, string $class, ?string $libelle_entete = null, ?string $DB_table_name = null)
    {
        /*
         * $DB_name : le nom de la colonne identique a la base de donnees
         * $liste : vrai ou faux
         *
         */
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'liste' => $liste,
            'class' => $class,
            'special' => 'maj_auto',
            'libelle_entete' => ($libelle_entete === null ? '' : $libelle_entete),
            'DB_table_name' => ($DB_table_name === null ? '' : $DB_table_name)
        );
    }

    function ajouter_colonne_modifiable(string $DB_name, bool $liste, string $class, ?bool $rafraichissement_page = null, ?string $libelle_entete = null, ?string $DB_table_name = null)
    {
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'liste' => $liste,
            'class' => $class,
            'special' => 'modifiable',
            'rafraichissement_page' => ($rafraichissement_page === null ? false : $rafraichissement_page),
            'libelle_entete' => ($libelle_entete === null ? '' : $libelle_entete),
            'DB_table_name' => ($DB_table_name === null ? '' : $DB_table_name)
        );
    }

    function ajouter_colonne_modifiable_sans_maj_auto(string $DB_name, bool $liste, string $class, ?bool $rafraichissement_page = null, ?string $libelle_entete = null, ?string $DB_table_name = null)
    {
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => ($DB_table_name === null ? '' : $DB_table_name),
            'liste' => $liste,
            'class' => $class,
            'special' => 'modifiable_sans_maj_anto',
            'rafraichissement_page' => ($rafraichissement_page === null ? false : $rafraichissement_page),
            'libelle_entete' => ($libelle_entete === null ? '' : $libelle_entete)
        );
    }

    function ajouter_colonne_Case_temoin_vert($DB_name, $class, $libelle_entete = '')
    {
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'class' => $class,
            'special' => 'case_temoin_vert',
            'libelle_entete' => $libelle_entete
        );
    }

    function ajouter_colonne_Google_Maps($DB_name, $class, $libelle_entete = '')
    {
        /*
         * $DB_name : le nom de la colonne identique a la base de donnees
         * $liste : vrai ou faux
         * $Optional : vrai ou faux
         */
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'class' => $class,
            'special' => 'googlemaps',
            'libelle_entete' => $libelle_entete
        );
    }

    function ajouter_colonne_image($DB_name, $class, $libelle_entete = '')
    {
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'class' => $class,
            'special' => 'image',
            'libelle_entete' => $libelle_entete
        );
    }

    function ajouter_colonne_fichier($DB_name, $class, $libelle_entete = '')
    {
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'class' => $class,
            'special' => 'fichier',
            'libelle_entete' => $libelle_entete
        );
    }

    function ajouter_colonne_code_html($DB_name, $class, $libelle_entete = '')
    {
        $this->colonnes[] = array(
            'DB_name' => $DB_name,
            'DB_table_name' => '',
            'class' => $class,
            'special' => 'code_html',
            'libelle_entete' => $libelle_entete
        );
    }

    function ajouter_colonne_bouton($action_bouton, $libelle_bouton, $class = '', $libelle_entete = '')
    {
        $this->indice_bouton ++;
        $this->colonnes_bouton[] = array(
            'action_bouton' => $action_bouton,
            'libelle_bouton' => $libelle_bouton,
            'indice_bouton' => $this->indice_bouton
        );
        global $lang_standard;
        $lang_standard['bouton_' . $this->indice_bouton] = $libelle_bouton;
        $this->ajouter_colonne_code_html('bouton_' . $this->indice_bouton, $class, $libelle_entete);
    }

    /*
     * function ajouter_colonne_Cliquable( $DB_name, $liste, $class, $action ) {
     * $this->colonnes[] = array( 'DB_name' => $DB_name, 'liste' => $liste, 'class' => $class, 'special' => 'colonne_cliquable', 'act' => $action );
     * }
     */
    function activer_colonne_Checkbox($colonne_checkbox_code, $liste_initiale)
    {
        $this->colonne_checkbox_code = $colonne_checkbox_code;
        $this->activer_checkbox = true;
        $this->liste_initiale = $liste_initiale;
    }

    function modifier_page_destination($autre_page, $nouvel_onglet = false)
    {
        $this->autre_page = $autre_page;
        $this->autre_page_nouvel_onglet = $nouvel_onglet;
    }

    function modifier_code_action($act)
    {
        $this->act = $act;
    }

    function ajouter_code_act($colonne_act_mod_code)
    {
        $this->colonne_act_mod_code[] = $colonne_act_mod_code;
    }

    function new_header($header)
    {
        $this->header = $header;
    }

    function set_footer($footer)
    {
        $this->footer = $footer;
    }

    function ajouter_class_tableau($class)
    {
        $this->class_tableau = $class;
    }

    function action_js($action_js)
    {
        $this->action_js = $action_js;
    }

    function set_ligne_selectionnee($colonne_selection, $valeur_selection)
    {
        $this->colonne_selection = $colonne_selection;
        $this->valeur_selection = $valeur_selection;
    }

    function generer_code($export = false, $tri = false, $append = false)
    {
        if (USE_BOOTSTRAP)
            return $this->generer_bootstrap_code($export, $tri, $append);

        global $menu_a_droite, $lang_standard, $num_champs_auto;

        $indice_bouton = 0;
        foreach ($this->colonnes_bouton as $bouton) {
            $indice_bouton ++;
            $lang_standard['bouton_' . $indice_bouton] = $bouton['libelle_entete'];
            $this->ajouter_colonne_code_html('bouton_' . $indice_bouton, '');
            foreach ($this->donnees as $key => $ligne) {
                $lien_bouton = '?act=' . $bouton['action_bouton'];
                foreach ($this->liste_Codes_ref as $value) {
                    if (isset($ligne[$value]))
                        $lien_bouton .= '&' . $value . '=' . $ligne[$value];
                }
                if (! isset($menu_a_droite)) {
                    $menu_a_droite = new Menu_a_droite();
                }
                $menu_a_droite->ajouter_bouton($bouton['libelle_bouton'], $lien_bouton, 'lien', 'bouton_temp');
                $ligne['bouton_' . $indice_bouton] = $menu_a_droite->generer_code_bouton('bouton_temp', '', true);
                $this->donnees[$key] = $ligne;
            }
        }

        self::$num_tableau ++;
        $tableau_id = 'tab_' . self::$num_tableau;

        $code = "<table class='tableau_std {$this->class_tableau}' id=\"$tableau_id\">";
        if ($export) {
            $code_3 = ""; // tableau CSV
        }

        $code .= '<thead>';

        if ($this->header == '') {
            $code .= '<tr>';
            $i = 0;
            foreach ($this->colonnes as $colonne) {
                $class = $colonne['class'];
                $code .= '<th' . ($class != '' ? ' class="' . $class . '"' : '') . '>' . ($colonne['libelle_entete'] != '' ? $colonne['libelle_entete'] : get_nom_colonne($colonne['DB_name'])) . ($tri ? "<a class=\"trier\" href=\"#\" onclick=\"trier_colonne_n('$tableau_id', $i);\"><span>&nbsp;</span></a>" : "") . "</th>"; //
                $i ++;
                if ($export) {
                    $code_3 .= format_caractere_csv(get_nom_colonne($colonne['DB_name'])) . ";";
                }
            }
            $code .= "</tr>";
        } else {
            $code .= "{$this->header}";
            if ($tri) {
                $code .= "<tr>";
                $i = 0;
                foreach ($this->colonnes as $colonne) {
                    $class = $colonne['class'];
                    $code .= '<th' . ($class != '' ? ' class="' . $class . '"' : '') . "><a class=\"trier\" href=\"#\" onclick=\"trier_colonne_n('$tableau_id', $i);\"><span>&nbsp;</span></a></th>"; //
                    $i ++;
                    if ($export) {
                        $code_3 .= format_caractere_csv(get_nom_colonne($colonne['DB_name'])) . ";";
                    }
                }
                $code .= "</tr>";
            }
        }

        if ($tri) { // COLONNE DE RECHERCHE
            $code .= '<tr id="ligne_recherche_' . $tableau_id . '" class="masquer">';
            $i = 0;
            foreach ($this->colonnes as $colonne) {
                $class = $colonne['class'];
                $code .= '<th' . ($class != '' ? ' class="' . $class . '"' : '') . "><span><input type=\"text\" id=\"{$tableau_id}_{$i}\" class=\"tableau_champ_recherche\" oninput=\"recherche_tableau('{$tableau_id}');\"></span></th>"; //
                $i ++;
            }
            $code .= '</tr>';
        }

        $code .= '</thead>';

        if ($this->footer != '') {
            $code .= $this->footer;
        }

        $code .= "<tbody>";
        if ($export) {
            $code_2 = $code; // tableau pour verison imprimable
            $code_3 .= "\n";
        }

        if ($this->activer_pagination) {
            $nb_elements_par_page = NB_ELEMENTS_MAX_PAR_TABLEAU;
        } else {
            $nb_elements_par_page = 999999999;
        }
        $nb_pages = round((count($this->donnees) - 1) / $nb_elements_par_page + 0.5);

        if (isset($_GET['page'])) {
            $num_page = round($_GET['page']);
        } else {
            $num_page = 1;
        }

        $compteur_ligne = 0;
        $odd = false;
        foreach ($this->donnees as $ligne_key => $ligne) {

            $num_champs_auto_ligne = 0;

            if (($num_page - 1) * $nb_elements_par_page <= $compteur_ligne && $compteur_ligne < $num_page * $nb_elements_par_page) {

                $ignorer_lien = false;
                if ((count($this->colonne_act_mod_code) > 0 || count($this->liste_Codes_ref) > 0) && $this->action_js == "") {
                    if ($this->act == '')
                        $ignorer_lien = true;
                    if ($this->autre_page == '')
                        $lien = "<a class='lien' href=\"?act={$this->act}";
                    else
                        $lien = "<a class='lien' " . ($this->autre_page_nouvel_onglet ? "target=\"_blank\"" : "") . " href=\"{$this->autre_page}?act={$this->act}";

                    foreach ($this->colonne_act_mod_code as $key => $value) {
                        if ($key == 0) {
                            $lien .= "&code={$ligne[$value]}";
                            if ($ligne[$value] == 0) {
                                $ignorer_lien = true;
                            }
                        } else
                            $lien .= "&code$key={$ligne[$value]}";
                    }

                    foreach ($this->liste_Codes_ref as $value) {
                        if (isset($ligne[$value]))
                            $lien .= '&' . $value . '=' . $ligne[$value];
                    }

                    $lien .= "\">";
                } elseif ($this->action_js != "") {
                    $lien = "<button class='lien' onclick=\"{$this->action_js}(";
                    foreach ($this->colonne_act_mod_code as $key => $value) {
                        if ($key == 0) {
                            $lien .= "{$ligne[$value]}";
                            if ($ligne[$value] == 0) {
                                $ignorer_lien = true;
                            }
                        } else
                            $lien .= ",{$ligne[$value]}";
                    }
                    $lien .= ");\">";
                } else {
                    $lien = "";
                }

                if ($ignorer_lien)
                    $lien = "";

                if ($lien != '') {
                    if ($this->action_js == '') {
                        $lien_fin = '</a>';
                    } else {
                        $lien_fin = '</button>';
                    }
                } else {
                    $lien_fin = "";
                }

                if ($this->colonne_discriminante == '') {
                    $code .= '<tr' . ($odd ? ' class="odd"' : '') . ">";
                    if ($export) {
                        $code_2 .= "<tr" . ($odd ? " class='odd'" : "") . ">";
                    }
                } else {
                    $discrim = $ligne[$this->colonne_discriminante];
                    $code .= "<tr class=\"" . ($odd ? "odd " : "") . "param_$discrim\">";
                    if ($export) {
                        $code_2 .= "<tr class=\"" . ($odd ? "odd " : "") . "param_$discrim\">";
                    }
                }

                foreach ($this->colonnes as $colonne) {

                    $special = $colonne['special'];
                    $class = $colonne['class'];
                    $DB_name = $colonne['DB_name'];
                    $DB_table_name = $colonne['DB_table_name'];

                    if ($special == 'modifiable' || $special == 'modifiable_sans_maj_anto') // un champs modifiable ne doit pas pointer vers un autre
                    {
                        $num_champs_auto_ligne = 0;
                    }

                    $code .= '<td class="' . $class . '"><label ' . ($this->activer_checkbox ? " for=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\"" : ($num_champs_auto_ligne != 0 ? 'for="form_dyn_' . ($num_champs_auto_ligne) . '"' : '')) . ">";
                    if ($export) {
                        $code_2 .= '<td' . ($class != '' ? ' class="' . $class . '"' : '') . '><label' . ($this->activer_checkbox ? ' for="checkbox_' . $ligne[$this->colonne_checkbox_code] . '"' : '') . '>';
                    }

                    $format_price = (stripos(' ' . $class . ' ', ' price ') !== false);
                    $format_date = (stripos(' ' . $class . ' ', ' date ') !== false);
                    $format_date_et_heure = (stripos(' ' . $class . ' ', ' date_heure ') !== false);
                    $format_date_lettre = (stripos(' ' . $class . ' ', ' date_lettre ') !== false);
                    $zerohidden = (stripos(' ' . $class . ' ', ' zerohidden ') !== false);
                    $format_color = (stripos(' ' . $class . ' ', ' color ') !== false);

                    if ('' . $ligne_key == 'total') {

                        $temp = $ligne[$DB_name];

                        if ($temp == '') {
                            $code .= '&nbsp;';
                            if ($export) {
                                $code_2 .= '&nbsp;';
                            }
                        } else {
                            if ($zerohidden && floatval($temp) == 0) {
                                $code .= '&nbsp;';
                            } elseif ($format_price) {
                                $code .= number_format($temp, 2, ',', ' ');
                            } elseif ($format_date_et_heure) {
                                $code .= format_datetime_fr($temp);
                            } elseif ($format_date_lettre) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr_en_lettre($temp);
                            } elseif ($format_date) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr($temp);
                            } elseif ($format_color) {
                                $code .= '<span style="display: inline-block; font-family: Consolas, monaco, monospace; padding: 1px 0; background-color: ' . $temp . '; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                            } else {
                                $code .= $temp;
                            }
                            if ($export) {
                                $code_2 .= $temp;
                            }
                        }

                        if ($export) {
                            $code_3 .= format_caractere_csv($temp) . ";";
                        }
                    } elseif ($special == "") {

                        $liste = $colonne["liste"];

                        $code .= $lien;

                        if ($liste)
                            $temp = text_html_br(get_nom_valeur($DB_name, $ligne[$DB_name]));
                        else
                            $temp = text_html_br($ligne[$DB_name]);

                        if ($temp == "") {
                            $code .= "&nbsp;";
                            if ($export) {
                                $code_2 .= "&nbsp;";
                            }
                        } else {
                            if ($zerohidden && floatval($temp) == 0) {
                                $code .= "&nbsp;";
                            } elseif ($format_price) {
                                $code .= number_format($temp, 2, ',', ' ');
                            } elseif ($format_date_et_heure) {
                                $code .= format_datetime_fr($temp);
                            } elseif ($format_date) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr($temp);
                            } elseif ($format_color) {
                                $code .= '<span style="display: inline-block; font-family: Consolas, monaco, monospace; padding: 1px 0; background-color: ' . $temp . '; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                            } elseif ($format_date_lettre) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr_en_lettre($temp);
                            } else {
                                $code .= $temp;
                            }
                            if ($export) {
                                $code_2 .= $temp;
                            }
                        }

                        $code .= $lien_fin;

                        if ($export) {
                            $code_3 .= format_caractere_csv($temp) . ";";
                        }
                    } elseif ($special == 'code_html') {

                        $code .= $lien;
                        $code .= ($ligne[$DB_name] != "" ? $ligne[$DB_name] : "&nbsp;");
                        if ($export) {
                            $code_2 .= $ligne[$DB_name];
                            $code_3 .= format_caractere_csv($ligne[$DB_name]) . ";";
                        }
                        $code .= $lien_fin;
                    } elseif ($special == 'googlemaps') {

                        $code .= "<iframe width=\"400\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"" . $ligne[$DB_name] . "\"></iframe>";
                        if ($export) {
                            $code_2 .= "<iframe width=\"400\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"" . $ligne[$DB_name] . "\"></iframe>";
                            $code_3 .= format_caractere_csv($ligne[$DB_name]) . ";";
                        }
                    } elseif ($special == 'fichier') {

                        $code .= $lien;
                        $code .= "<iframe width=\"200\" height=\"150\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"mf_fichier.php?n={$ligne[$DB_name]}\"></iframe>";
                        if ($export) {
                            $code_2 .= "<iframe width=\"400\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"mf_fichier.php?n={$ligne[$DB_name]}\"></iframe>";
                            $code_3 .= format_caractere_csv($ligne[$DB_name]) . ";";
                        }
                        $code .= $lien_fin;
                    } elseif ($special == 'image') {

                        $code .= $lien;
                        $code .= get_image($ligne[$DB_name], 75, 75, true, '', true, '', $class);
                        if ($export) {
                            $code_2 .= get_image($ligne[$DB_name], 75, 75, true, '', true, '', $class);
                            $code_3 .= format_caractere_csv($ligne[$DB_name]) . ";";
                        }
                        $code .= $lien_fin;
                    } elseif ($special == 'case_temoin_vert') {

                        $code .= $lien;
                        switch ($ligne[$DB_name]) {
                            case 1:
                                $val_class = "actif";
                                break;
                            case 2:
                                $val_class = "special";
                                break;
                            default:
                                $val_class = "non_actif";
                                break;
                        }

                        $code .= "<span class='$val_class'><span>$ligne[$DB_name]</span></span>";
                        if ($export) {
                            $code_2 .= "<span class='$val_class'><span>$ligne[$DB_name]</span></span>";
                        }
                        $code .= $lien_fin;
                        if ($export) {
                            $code_3 .= format_caractere_csv($ligne[$DB_name]) . ";";
                        }
                    } elseif ($special == 'modifiable') {

                        $liste_valeurs_cle_table = array();
                        foreach ($this->liste_Codes_ref as $value) {
                            $liste_valeurs_cle_table[$value] = $ligne[$value];
                        }

                        $num_champs_auto_ligne = $num_champs_auto;
                        $code .= ajouter_champ_modifiable($liste_valeurs_cle_table, $DB_name, $ligne[$DB_name], $DB_table_name, $colonne['rafraichissement_page'], '', false, '', array(), true, false);
                    } elseif ($special == 'modifiable_sans_maj_anto') {

                        $liste_valeurs_cle_table = array();
                        foreach ($this->liste_Codes_ref as $value) {
                            $liste_valeurs_cle_table[$value] = $ligne[$value];
                        }

                        $num_champs_auto_ligne = $num_champs_auto;
                        $code .= ajouter_champ_modifiable($liste_valeurs_cle_table, $DB_name, $ligne[$DB_name], $DB_table_name, $colonne['rafraichissement_page'], '', false, '', array(), false, false);
                    } elseif ($special == 'maj_auto') {

                        $liste_valeurs_cle_table = array();
                        foreach ($this->liste_Codes_ref as $value) {
                            $liste_valeurs_cle_table[$value] = $ligne[$value];
                        }

                        $code .= get_valeur_html_maj_auto($liste_valeurs_cle_table, $DB_name, $ligne[$DB_name], $DB_table_name, $class);
                    }
                    $code .= '</label></td>';
                    if ($export) {
                        $code_2 .= '</label></td>';
                    }
                }
                if ($this->activer_checkbox) {
                    $code .= "<td class='btn'><input type=\"checkbox\" name=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" id=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" value=\"1\" " . (isset($this->liste_initiale[$ligne[$this->colonne_checkbox_code]]) ? "checked=\"checked\"" : "") . "></td>";
                    if ($export) {
                        $code_2 .= "<td class='btn'><input type=\"checkbox\" name=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" id=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" value=\"1\" " . (isset($this->liste_initiale[$ligne[$this->colonne_checkbox_code]]) ? "checked=\"checked\"" : "") . "></td>";
                    }
                }
                $code .= '</tr>';
                if ($export) {
                    $code_2 .= '</tr>';
                    $code_3 .= "\n";
                }
                $odd = ! $odd;
            }
            $compteur_ligne ++;
        }
        $code .= '</tbody></table>';
        if ($export) {
            $code_2 .= '</tbody></table>';
        }

        if ($export) {

            // $cle_tableau_impression = $table_export_tableau->ajouter_valeur($code_2);
            // $cle_export_csv = $table_export_tableau->ajouter_valeur($code_3);

            $cle_tableau_impression = 'export';
            $cle_export_csv = 'export';
        }

        $retour = '<div class="bouton_tableau">';
        if ($export) {
            $retour .= " <a class=\"imprimer\" href=\"mf_printtab.php?cle=$cle_tableau_impression\" target=\"_blank\"><span>&nbsp;</span></a> <a class=\"format_csv\" href=\"mf_format_csv.php?cle=$cle_export_csv\" target=\"_blank\"><span>&nbsp;</span></a>";
        }
        if ($tri) {
            $retour .= " <a class=\"rechercher\" href=\"#\" onclick=\"afficher_ligne_tri('$tableau_id')\"><span>&nbsp;</span></a>";
        }

        $pagination = '';
        if ($nb_pages > 1) {
            $pagination .= '<div class="barre_pages_tableau">';

            $dichotomie_1 = round($num_page / 2);
            $dichotomie_2 = round(($nb_pages - $num_page) / 2 + $num_page);

            for ($i = 1; $i <= $nb_pages; $i ++) {
                $pagination .= "<a href=\"?page=$i\"><span class=\"num_page_tableau\">$i</span></a>";
                if ($i == 1 || $i == $nb_pages || $i == $num_page || $i == ($num_page - 1) || $i == ($num_page + 1) || $i == $dichotomie_1 || $i == $dichotomie_2) {
                    $menu_a_droite->ajouter_bouton_page_tableau($i, $num_page == $i);
                }
            }
            $pagination .= '</div>';
        }

        $retour .= "</div><div class=\"$this->class contour_tableau\">{$code}{$pagination}</div>";

        return $retour;
    }

    function generer_bootstrap_code($export = false, $tri = false, $append = false)
    {
        global $menu_a_droite, $lang_standard, $num_champs_auto;

        foreach ($this->colonnes_bouton as $bouton) {
            foreach ($this->donnees as $key => $ligne) {
                $lien_bouton = '?act=' . $bouton['action_bouton'];
                foreach ($this->liste_Codes_ref as $value) {
                    if (isset($ligne[$value]))
                        $lien_bouton .= '&' . $value . '=' . $ligne[$value];
                }
                if (! isset($menu_a_droite)) {
                    $menu_a_droite = new Menu_a_droite();
                }
                $menu_a_droite->ajouter_bouton($bouton['libelle_bouton'], $lien_bouton, 'lien', 'bouton_temp');
                $ligne['bouton_' . $bouton['indice_bouton']] = $menu_a_droite->generer_code_bouton('bouton_temp', '', true);
                $this->donnees[$key] = $ligne;
            }
        }

        self::$num_tableau ++;
        $tableau_id = 'tab_' . self::$num_tableau;

        if (! $append) {
            $code = '<table class="table table-striped ' . $this->class_tableau . '" id="' . $tableau_id . '">';
        } else {
            $code = '';
        }
        if ($export) {
            $code_3 = ''; // tableau CSV
        }

        $code .= '<thead>';

        if ($this->header == '') {
            $code .= '<tr>';
            $i = 0;
            foreach ($this->colonnes as $colonne) {
                $class = $colonne['class'];
                $code .= '<th class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '">' . ($colonne['libelle_entete'] != '' ? $colonne['libelle_entete'] : get_nom_colonne($colonne['DB_name'])) . ($tri ? "<a class=\"trier\" href=\"#\" onclick=\"trier_colonne_n('$tableau_id', $i);\"><span>&nbsp;</span></a>" : "") . "</th>"; //
                $i ++;
                if ($export) {
                    $code_3 .= format_caractere_csv(get_nom_colonne($colonne['DB_name'])) . ';';
                }
            }
            $code .= '</tr>';
        } else {
            $code .= '' . $this->header;
            if ($tri) {
                $code .= '<tr>';
                $i = 0;
                foreach ($this->colonnes as $colonne) {
                    $class = $colonne['class'];
                    $code .= '<th class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '"><a class="trier" href="#" onclick="trier_colonne_n("' . $tableau_id . '", ' . $i . ');"><span>&nbsp;</span></a></th>'; //
                    $i ++;
                    if ($export) {
                        $code_3 .= format_caractere_csv(get_nom_colonne($colonne['DB_name'])) . ';';
                    }
                }
                $code .= '</tr>';
            }
        }

        if ($tri) { // COLONNE DE RECHERCHE
            $code .= '<tr id="ligne_recherche_' . $tableau_id . '" class="masquer">';
            $i = 0;
            foreach ($this->colonnes as $colonne) {
                $class = $colonne['class'];
                $code .= '<th class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '"><span><input type="text" id="' . $tableau_id . '_' . $i . ' class="tableau_champ_recherche" oninput="recherche_tableau(\'' . $tableau_id . '\');"></span></th>'; //
                $i ++;
            }
            $code .= '</tr>';
        }

        $code .= '</thead>';

        if ($this->footer != '') {
            $code .= $this->footer;
        }

        $code .= '<tbody>';
        if ($export) {
            $code_2 = $code; // tableau pour verison imprimable
            $code_3 .= "\n";
        }

        if ($this->activer_pagination) {
            $nb_elements_par_page = NB_ELEMENTS_MAX_PAR_TABLEAU;
        } else {
            $nb_elements_par_page = 999999999;
        }
        $nb_pages = round((count($this->donnees) - 1) / $nb_elements_par_page + 0.5);

        if (isset($_GET['page'])) {
            $num_page = round($_GET['page']);
        } else {
            $num_page = 1;
        }

        $compteur_ligne = 0;

        foreach ($this->donnees as $ligne_key => $ligne) {

            $num_champs_auto_ligne = 0;

            if ($export) // $code_3 sur la globalité des valeurs pour un export complet
            {

                foreach ($this->colonnes as $colonne) {

                    $special = $colonne['special'];
                    $DB_name = $colonne['DB_name'];
                    $DB_table_name = $colonne['DB_table_name'];

                    if ('' . $ligne_key == 'total') {
                        $temp = $ligne[$DB_name];
                        $code_3 .= format_caractere_csv($temp) . ';';
                    } elseif ($special == '') {
                        $liste = $colonne['liste'];
                        if ($liste) {
                            $temp = text_html_br(get_nom_valeur($DB_name, $ligne[$DB_name]));
                        } else {
                            $temp = text_html_br($ligne[$DB_name]);
                        }
                        $code_3 .= format_caractere_csv($temp) . ';';
                    } elseif ($special == 'code_html') {
                        $code_3 .= format_caractere_csv($ligne[$DB_name]) . ';';
                    } elseif ($special == 'googlemaps') {
                        $code_3 .= format_caractere_csv($ligne[$DB_name]) . ';';
                    } elseif ($special == 'fichier') {
                        $code_3 .= format_caractere_csv($ligne[$DB_name]) . ';';
                    } elseif ($special == 'image') {
                        $code_3 .= format_caractere_csv($ligne[$DB_name]) . ';';
                    } elseif ($special == 'case_temoin_vert') {
                        $code_3 .= format_caractere_csv($ligne[$DB_name]) . ';';
                    }
                }

                $code_3 .= "\n";
            }

            if (($num_page - 1) * $nb_elements_par_page <= $compteur_ligne && $compteur_ligne < $num_page * $nb_elements_par_page) {

                $ignorer_lien = false;
                if ((count($this->colonne_act_mod_code) > 0 || count($this->liste_Codes_ref) > 0) && $this->action_js == "") {
                    if ($this->act == '') {
                        $ignorer_lien = true;
                    }
                    if ($this->autre_page == '') {
                        $lien = "<a class='lien' href=\"?act={$this->act}";
                    } else {
                        $lien = '<a class="lien" ' . ($this->autre_page_nouvel_onglet ? "target=\"_blank\"" : "") . " href=\"{$this->autre_page}?act={$this->act}";
                    }

                    foreach ($this->colonne_act_mod_code as $key => $value) {
                        if ($key == 0) {
                            $lien .= "&code={$ligne[$value]}";
                            if ($ligne[$value] == 0) {
                                $ignorer_lien = true;
                            }
                        } else {
                            $lien .= "&code$key={$ligne[$value]}";
                        }
                    }

                    foreach ($this->liste_Codes_ref as $value) {
                        if (isset($ligne[$value])) {
                            $lien .= '&' . $value . '=' . $ligne[$value];
                        }
                    }

                    $lien .= '">';
                } elseif ($this->action_js != '') {
                    $lien = '<button class="lien" onclick="' . $this->action_js . '(';
                    foreach ($this->colonne_act_mod_code as $key => $value) {
                        if ($key == 0) {
                            $lien .= "{$ligne[$value]}";
                            if ($ligne[$value] == 0) {
                                $ignorer_lien = true;
                            }
                        } else {
                            $lien .= ",{$ligne[$value]}";
                        }
                    }
                    $lien .= ');">';
                } else {
                    $lien = '';
                }

                if ($ignorer_lien) {
                    $lien = '';
                }

                if ($lien != '') {
                    if ($this->action_js == '') {
                        $lien_fin = '</a>';
                    } else {
                        $lien_fin = '</button>';
                    }
                } else {
                    $lien_fin = '';
                }

                if ($this->colonne_discriminante == '' && $this->colonne_class == '') {
                    $code .= '<tr' . ($this->colonne_selection != '' ? ($ligne[$this->colonne_selection] == $this->valeur_selection ? ' class=""' : '') : '') . ' class="">';
                    if ($export) {
                        $code_2 .= '<tr>';
                    }
                } else {
                    $class = ($this->colonne_discriminante != '' ? 'param_' . $ligne[$this->colonne_discriminante] : '') . ' ' . ($this->colonne_class != '' ? $ligne[$this->colonne_class] : '');
                    $code .= '<tr class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '">';
                    if ($export) {
                        $code_2 .= '<tr class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '">';
                    }
                }

                foreach ($this->colonnes as $colonne) {

                    $special = $colonne['special'];
                    $class = $colonne['class'];
                    $DB_name = $colonne['DB_name'];
                    $DB_table_name = $colonne['DB_table_name'];

                    if ($special == 'modifiable' || $special == 'modifiable_sans_maj_anto') // un champs modifiable ne doit pas pointer vers un autre
                    {
                        $num_champs_auto_ligne = 0;
                    }

                    $code .= '<td class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '"><' . ($num_champs_auto_ligne != 0 ? 'label' : 'span') . ($this->activer_checkbox ? " for=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\"" : ($num_champs_auto_ligne != 0 ? ' for="form_dyn_' . ($num_champs_auto_ligne) . '"' : '')) . '>';
                    if ($export) {
                        $code_2 .= '<td class="' . str_replace(' img-circle ', '', ' ' . $class . ' ') . '"><' . ($num_champs_auto_ligne != 0 ? 'label' : 'span') . ($this->activer_checkbox ? ' for="checkbox_' . $ligne[$this->colonne_checkbox_code] . '"' : '') . '>';
                    }

                    $format_price = (stripos(' ' . $class . ' ', ' price ') !== false);
                    $format_percent = (stripos(' ' . $class . ' ', ' percent ') !== false);
                    $format_date = (stripos(' ' . $class . ' ', ' date ') !== false);
                    $format_date_et_heure = (stripos(' ' . $class . ' ', ' date_heure ') !== false);
                    $format_date_lettre = (stripos(' ' . $class . ' ', ' date_lettre ') !== false);
                    $zerohidden = (stripos(' ' . $class . ' ', ' zerohidden ') !== false);
                    $format_color = (stripos(' ' . $class . ' ', ' color ') !== false);
                    $format_time = (stripos(' ' . $class . ' ', ' time ') !== false);

                    if ('' . $ligne_key == 'total') {

                        $temp = $ligne[$DB_name];

                        if ($temp == '') {
                            $code .= '&nbsp;';
                            if ($export) {
                                $code_2 .= '&nbsp;';
                            }
                        } else {
                            if ($zerohidden && floatval($temp) == 0) {
                                $code .= '&nbsp;';
                            } elseif ($format_price) {
                                $code .= number_format($temp, 2, ',', ' ');
                            } elseif ($format_percent) {
                                $code .= number_format(100 * $temp, 2, ',', ' ') . ' %';
                            } elseif ($format_date_et_heure) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_datetime_fr($temp);
                            } elseif ($format_date) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr($temp);
                            } elseif ($format_date_lettre) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr_en_lettre($temp);
                            } elseif ($format_color) {
                                $code .= '<span style="display: inline-block; font-family: Consolas, monaco, monospace; padding: 1px 0; background-color: ' . $temp . '; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                            } elseif ($format_time) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_time_fr($temp);
                            } else {
                                $code .= $temp;
                            }
                            if ($export) {
                                $code_2 .= $temp;
                            }
                        }

                        if ($export) {
                            // $code_3 .= format_caractere_csv($temp).';';
                        }
                    } elseif ($special == '') {

                        $liste = $colonne['liste'];

                        $code .= $lien;

                        if ($liste) {
                            $temp = text_html_br(get_nom_valeur($DB_name, $ligne[$DB_name]));
                        } else {
                            if (isset($ligne[$DB_name])) {
                                $temp = text_html_br($ligne[$DB_name]);
                            } else {
                                $temp = '';
                            }
                        }

                        if ($temp == '') {
                            $code .= '&nbsp;';
                            if ($export) {
                                $code_2 .= '&nbsp;';
                            }
                        } else {
                            if ($zerohidden && floatval($temp) == 0) {
                                $code .= '&nbsp;';
                            } elseif ($format_price) {
                                $code .= number_format($temp, 2, ',', ' ');
                            } elseif ($format_percent) {
                                $code .= number_format(100 * $temp, 2, ',', ' ') . ' %';
                            } elseif ($format_date_et_heure) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_datetime_fr($temp);
                            } elseif ($format_date) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr($temp);
                            } elseif ($format_color) {
                                $code .= '<span style="display: inline-block; font-family: Consolas, monaco, monospace; padding: 1px 0; background-color: ' . $temp . '; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                            } elseif ($format_date_lettre) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_date_fr_en_lettre($temp);
                            } elseif ($format_time) {
                                $code .= '<span class="masquer">' . $temp . '</span>' . format_time_fr($temp);
                            } else {
                                $code .= $temp;
                            }
                            if ($export) {
                                $code_2 .= $temp;
                            }
                        }

                        $code .= $lien_fin;

                        if ($export) {
                            // $code_3 .= format_caractere_csv($temp).';';
                        }
                    } elseif ($special == 'code_html') {

                        $code .= $lien;
                        $code .= ($ligne[$DB_name] != '' ? $ligne[$DB_name] : '&nbsp;');
                        if ($export) {
                            $code_2 .= $ligne[$DB_name];
                            // $code_3 .= format_caractere_csv($ligne[$DB_name]).';';
                        }
                        $code .= $lien_fin;
                    } elseif ($special == 'googlemaps') {

                        $code .= "<iframe width=\"400\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"" . $ligne[$DB_name] . "\"></iframe>";
                        if ($export) {
                            $code_2 .= "<iframe width=\"400\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"" . $ligne[$DB_name] . "\"></iframe>";
                            // $code_3 .= format_caractere_csv($ligne[$DB_name]).';';
                        }
                    } elseif ($special == 'fichier') {

                        $code .= $lien;
                        $code .= "<iframe width=\"200\" height=\"150\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"mf_fichier.php?n={$ligne[$DB_name]}\"></iframe>";
                        if ($export) {
                            $code_2 .= "<iframe width=\"400\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"mf_fichier.php?n={$ligne[$DB_name]}\"></iframe>";
                            // $code_3 .= format_caractere_csv($ligne[$DB_name]).';';
                        }
                        $code .= $lien_fin;
                    } elseif ($special == 'image') {

                        $code .= $lien;
                        if ($ligne[$DB_name] != '') {
                            $code .= get_image($ligne[$DB_name], 75, 75, true, '', true, '', $class);
                        } else {
                            $code .= '<div style="text-align: center;">?</div>';
                        }
                        if ($export) {
                            if ($ligne[$DB_name] != '') {
                                $code_2 .= "<div style=\"min-width: 75px; height:75px; background: url('mf_fichier.php?n={$ligne[$DB_name]}&width=75&height=75&troncage=0') center; background-size: contain; background-repeat: no-repeat;\"></div>";
                            } else {
                                $code_2 .= '<div style="text-align: center;">?</div>';
                            }
                            // $code_3 .= format_caractere_csv($ligne[$DB_name]).';';
                        }
                        $code .= $lien_fin;
                    } elseif ($special == 'case_temoin_vert') {

                        $code .= $lien;
                        switch ($ligne[$DB_name]) {
                            case 1:
                                $val_class = 'actif';
                                break;
                            case 2:
                                $val_class = 'special';
                                break;
                            default:
                                $val_class = 'non_actif';
                                break;
                        }

                        $code .= "<span class='$val_class'><span>$ligne[$DB_name]</span></span>";
                        if ($export) {
                            $code_2 .= "<span class='$val_class'><span>$ligne[$DB_name]</span></span>";
                        }
                        $code .= $lien_fin;
                        if ($export) {
                            // $code_3 .= format_caractere_csv($ligne[$DB_name]).';';
                        }
                    } elseif ($special == 'modifiable') {

                        $liste_valeurs_cle_table = array();
                        foreach ($this->liste_Codes_ref as $value) {
                            $liste_valeurs_cle_table[$value] = $ligne[$value];
                        }

                        $num_champs_auto_ligne = $num_champs_auto;
                        $code .= '' . ajouter_champ_modifiable_interface(array(
                            'liste_valeurs_cle_table' => $liste_valeurs_cle_table,
                            'DB_name' => $DB_name,
                            'nom_table' => $DB_table_name,
                            'valeur_initiale' => $ligne[$DB_name],
                            'rafraichissement_page' => $colonne['rafraichissement_page'],
                            'titre' => false,
                            'mode_formulaire' => false,
                            'class' => $class
                        ));
                    } elseif ($special == 'modifiable_sans_maj_anto') {

                        $liste_valeurs_cle_table = array();
                        foreach ($this->liste_Codes_ref as $value) {
                            $liste_valeurs_cle_table[$value] = $ligne[$value];
                        }

                        $num_champs_auto_ligne = $num_champs_auto;
                        if (isset($ligne[$DB_name])) {
                            $code .= ajouter_champ_modifiable_interface(array(
                                'liste_valeurs_cle_table' => $liste_valeurs_cle_table,
                                'DB_name' => $DB_name,
                                'nom_table' => $DB_table_name,
                                'valeur_initiale' => $ligne[$DB_name],
                                'rafraichissement_page' => $colonne['rafraichissement_page'],
                                'titre' => false,
                                'maj_auto' => false,
                                'mode_formulaire' => false,
                                'class' => $class
                            ));
                        }
                    } elseif ($special == 'maj_auto') {

                        $code .= $lien;

                        $liste_valeurs_cle_table = array();
                        foreach ($this->liste_Codes_ref as $value) {
                            $liste_valeurs_cle_table[$value] = $ligne[$value];
                        }

                        $code .= get_valeur_html_maj_auto($liste_valeurs_cle_table, $DB_name, $ligne[$DB_name], $DB_table_name, $class, true, false);

                        $code .= $lien_fin;
                    }
                    $code .= '' . ($num_champs_auto_ligne != 0 ? '</label>' : '</span>') . '</td>';
                    if ($export) {
                        $code_2 .= '' . ($num_champs_auto_ligne != 0 ? '</label>' : '</span>') . '</td>';
                    }
                }
                if ($this->activer_checkbox) {
                    $code .= "<td class='btn'><input type=\"checkbox\" name=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" id=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" value=\"1\" " . (isset($this->liste_initiale[$ligne[$this->colonne_checkbox_code]]) ? "checked=\"checked\"" : "") . "></td>";
                    if ($export) {
                        $code_2 .= "<td class='btn'><input type=\"checkbox\" name=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" id=\"checkbox_{$ligne[$this->colonne_checkbox_code]}\" value=\"1\" " . (isset($this->liste_initiale[$ligne[$this->colonne_checkbox_code]]) ? "checked=\"checked\"" : "") . "></td>";
                    }
                }
                $code .= '</tr>';
                if ($export) {
                    $code_2 .= '</tr>';
                    // $code_3 .= "\n";
                }
            }
            $compteur_ligne ++;
        }

        $code .= '</tbody>';
        if (! $append) {
            $code .= '</table>';
        }

        if ($export) {
            $code_2 .= '</tbody></table>';
        }

        if ($export) {
            $cache = new Cache();
            $s = salt_minuscules(16);
            $cle_tableau_impression = $s . 'imp';
            $cle_export_csv = $s . 'csv';
            $cache->write($cle_tableau_impression, $code_2);
            $cache->write($cle_export_csv, $code_3);
            // $cle_tableau_impression = $table_export_tableau->ajouter_valeur($code_2);
            // $cle_export_csv = $table_export_tableau->ajouter_valeur($code_3);
        }

        if (! $append) {
            $retour = '<div class="bouton_tableau">';
            if ($export) {
                $retour .= " <a class=\"imprimer\" href=\"mf_printtab.php?cle=$cle_tableau_impression\" target=\"_blank\"><span>&nbsp;</span></a> <a class=\"format_csv\" href=\"mf_format_csv.php?cle=$cle_export_csv\" target=\"_blank\"><span>&nbsp;</span></a>";
            }
            if ($tri) {
                $retour .= " <a class=\"rechercher\" href=\"#tab_filtre_switch\" onclick=\"afficher_ligne_tri('$tableau_id')\"><span>&nbsp;</span></a>";
            }

            $pagination = '';
            if ($nb_pages > 1) {
                $pagination .= '<div class="text-center"><ul class="pagination">';
                for ($i = 1; $i <= $nb_pages; $i ++) {
                    $pagination .= '<li' . ($num_page == $i ? ' class="active"' : '') . '><a href="?page=' . $i . '">' . $i . '</a></li>';
                }
                $pagination .= '</ul></div>';
            }

            $retour .= '</div><div class="' . $this->class . ' contour_tableau">' . $code . '</div>' . $pagination;

            return $retour;
        } else {
            return $code;
        }
    }
}

?>
