<?php declare(strict_types=1);

class Hook_a_parametre_utilisateur
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(?int &$a_parametre_utilisateur_Valeur, ?int &$a_parametre_utilisateur_Actif, int &$Code_utilisateur, int &$Code_parametre, bool $add_function)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter(?int $Code_utilisateur = null, ?int $Code_parametre = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_parametre_utilisateur__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['a_parametre_utilisateur__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(?int $a_parametre_utilisateur_Valeur, ?int $a_parametre_utilisateur_Actif, int $Code_utilisateur, int $Code_parametre)
    {
        return true;
    }

    public static function data_controller(?int &$a_parametre_utilisateur_Valeur, ?int &$a_parametre_utilisateur_Actif, int $Code_utilisateur, int $Code_parametre, bool $add_function)
    {
        // ici le code
    }

    public static function ajouter(int $Code_utilisateur, int $Code_parametre)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_utilisateur = null, ?int $Code_parametre = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_parametre_utilisateur__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Valeur'] = false;
        $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Actif'] = false;
        // Mise à jour des droits
        if (get_utilisateur_courant(MF_UTILISATEUR__ID) == $Code_utilisateur) {
            $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Valeur'] = true;
            $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Actif'] = true;
        }
    }

    public static function autorisation_modification(int $Code_utilisateur, int $Code_parametre, ?int $a_parametre_utilisateur_Valeur__new, ?int $a_parametre_utilisateur_Actif__new)
    {
        return true;
    }

    public static function data_controller__a_parametre_utilisateur_Valeur(?int $old, ?int &$new, int $Code_utilisateur, int $Code_parametre)
    {
        // ici le code
    }

    public static function data_controller__a_parametre_utilisateur_Actif(?int $old, ?int &$new, int $Code_utilisateur, int $Code_parametre)
    {
        // ici le code
    }

    /*
     * modifier : $Code_..., permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_utilisateur, int $Code_parametre, bool $bool__a_parametre_utilisateur_Valeur, bool $bool__a_parametre_utilisateur_Actif)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_utilisateur = null, ?int $Code_parametre = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_parametre_utilisateur__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
    }

    public static function autorisation_suppression(int $Code_utilisateur, int $Code_parametre)
    {
        return true;
    }

    public static function supprimer(array $copie__liste_a_parametre_utilisateur)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_utilisateur']
         * $donnees['Code_parametre']
         * $donnees['a_parametre_utilisateur_Valeur']
         * $donnees['a_parametre_utilisateur_Actif']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_utilisateur, int $Code_parametre)
    {
        return null;
    }

    public static function callback_put(int $Code_utilisateur, int $Code_parametre)
    {
        return null;
    }
}
