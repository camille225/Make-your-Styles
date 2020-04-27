<?php declare(strict_types=1);

class Hook_a_filtrer
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(int &$Code_utilisateur, int &$Code_vue_utilisateur, bool $add_function)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_filtrer__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['a_filtrer__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(int $Code_utilisateur, int $Code_vue_utilisateur)
    {
        return true;
    }

    public static function data_controller(int $Code_utilisateur, int $Code_vue_utilisateur, bool $add_function)
    {
        // ici le code
    }

    public static function ajouter(int $Code_utilisateur, int $Code_vue_utilisateur)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_filtrer__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
    }

    public static function autorisation_suppression(int $Code_utilisateur, int $Code_vue_utilisateur)
    {
        return true;
    }

    public static function supprimer(array $copie__liste_a_filtrer)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_utilisateur']
         * $donnees['Code_vue_utilisateur']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_utilisateur, int $Code_vue_utilisateur)
    {
        return null;
    }

    public static function callback_put(int $Code_utilisateur, int $Code_vue_utilisateur)
    {
        return null;
    }
}
