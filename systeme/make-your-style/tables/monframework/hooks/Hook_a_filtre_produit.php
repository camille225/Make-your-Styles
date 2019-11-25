<?php

class Hook_a_filtre_produit
{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(int &$a_filtre_produit_Actif, int $Code_filtre, int $Code_article, bool $add_function)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_filtre = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_filtre_produit__AJOUTER'] = false;
        $mf_droits_defaut['a_filtre_produit__CREER'] = false; // actualisation uniquement pour l'affichage
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_ajout(int $a_filtre_produit_Actif, int $Code_filtre, int $Code_article)
    {
        return true;
    }

    static function data_controller(int &$a_filtre_produit_Actif, int $Code_filtre, int $Code_article, bool $add_function)
    {
        // ici le code
    }

    static function ajouter(int $Code_filtre, int $Code_article)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_filtre = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_filtre_produit__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__a_filtre_produit_Actif'] = false;
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_modification(int $Code_filtre, int $Code_article, int $a_filtre_produit_Actif__new)
    {
        return true;
    }

    static function data_controller__a_filtre_produit_Actif(int $old, int &$new, int $Code_filtre, int $Code_article)
    {
        // ici le code
    }

    /*
     * modifier : $Code_..., permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_filtre, int $Code_article, bool $bool__a_filtre_produit_Actif)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_filtre = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_filtre_produit__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($mf_droits_defaut['a_filtre_produit__SUPPRIMER']) {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_filtre, int $Code_article)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_filtre_produit)
    {
        // ici le code
    }

    static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_filtre']
         * $donnees['Code_article']
         * $donnees['a_filtre_produit_Actif']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    static function callback_post(int $Code_filtre, int $Code_article)
    {
        return null;
    }

    static function callback_put(int $Code_filtre, int $Code_article)
    {
        return null;
    }
}
