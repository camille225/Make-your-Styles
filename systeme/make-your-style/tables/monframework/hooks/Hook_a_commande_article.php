<?php declare(strict_types=1);

class Hook_a_commande_article
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(?int &$a_commande_article_Quantite, ?float &$a_commande_article_Prix_ligne, int &$Code_commande, int &$Code_article, bool $add_function)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter(?int $Code_commande = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_commande_article__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['a_commande_article__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(?int $a_commande_article_Quantite, ?float $a_commande_article_Prix_ligne, int $Code_commande, int $Code_article)
    {
        return true;
    }

    public static function data_controller(?int &$a_commande_article_Quantite, ?float &$a_commande_article_Prix_ligne, int $Code_commande, int $Code_article, bool $add_function)
    {
        // ici le code
    }

    public static function ajouter(int $Code_commande, int $Code_article)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_commande = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_commande_article__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__a_commande_article_Quantite'] = false;
        $mf_droits_defaut['api_modifier__a_commande_article_Prix_ligne'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_modification(int $Code_commande, int $Code_article, ?int $a_commande_article_Quantite__new, ?float $a_commande_article_Prix_ligne__new)
    {
        return true;
    }

    public static function data_controller__a_commande_article_Quantite(?int $old, ?int &$new, int $Code_commande, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__a_commande_article_Prix_ligne(?float $old, ?float &$new, int $Code_commande, int $Code_article)
    {
        // ici le code
    }

    /*
     * modifier : $Code_..., permettent de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_commande, int $Code_article, bool $bool__a_commande_article_Quantite, bool $bool__a_commande_article_Prix_ligne)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_commande = null, ?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['a_commande_article__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
    }

    public static function autorisation_suppression(int $Code_commande, int $Code_article)
    {
        return true;
    }

    public static function supprimer(array $copie__liste_a_commande_article)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_commande']
         * $donnees['Code_article']
         * $donnees['a_commande_article_Quantite']
         * $donnees['a_commande_article_Prix_ligne']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_commande, int $Code_article)
    {
        return null;
    }

    public static function callback_put(int $Code_commande, int $Code_article)
    {
        return null;
    }
}
