<?php

class Hook_a_article_commande
{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(int $Code_commande, int $Code_article, bool $add_function)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_commande = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_article_commande__AJOUTER'] = false;
        $mf_droits_defaut['a_article_commande__CREER'] = false; // actualisation uniquement pour l'affichage
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_ajout(int $Code_commande, int $Code_article)
    {
        return true;
    }

    static function data_controller(int $Code_commande, int $Code_article, bool $add_function)
    {
        // ici le code
    }

    static function ajouter(int $Code_commande, int $Code_article)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_commande = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_article_commande__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($mf_droits_defaut['a_article_commande__SUPPRIMER']) {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_commande, int $Code_article)
    {
        return true;
    }

    static function supprimer(array $copie__liste_a_article_commande)
    {
        // ici le code
    }

    static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_commande']
         * $donnees['Code_article']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    static function callback_post(int $Code_commande, int $Code_article)
    {
        return null;
    }

    static function callback_put(int $Code_commande, int $Code_article)
    {
        return null;
    }
}
