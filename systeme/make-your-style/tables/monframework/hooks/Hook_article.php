<?php

class Hook_article
{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$article_Libelle, string &$article_Photo_Fichier, float &$article_Prix, bool &$article_Actif, int &$Code_type_produit, ?int $Code_article = null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter(?int $Code_type_produit = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['article__AJOUTER'] = false;
        $mf_droits_defaut['article__CREER'] = false; // actualisation uniquement pour l'affichage
        // Mise à jour des droits
        $mf_droits_defaut['article__AJOUTER'] = true;
        // ici le code
    }

    static function autorisation_ajout(string $article_Libelle, string $article_Photo_Fichier, float $article_Prix, bool $article_Actif, int $Code_type_produit)
    {
        return true;
    }

    static function data_controller(string &$article_Libelle, string &$article_Photo_Fichier, float &$article_Prix, bool &$article_Actif, int &$Code_type_produit, ?int $Code_article = null)
    {
        // ici le code
    }

    static function calcul_signature(string $article_Libelle, string $article_Photo_Fichier, float $article_Prix, bool $article_Actif, int $Code_type_produit)
    {
        return md5($article_Libelle . '-' . $article_Photo_Fichier . '-' . $article_Prix . '-' . $article_Actif . '-' . $Code_type_produit);
    }

    static function calcul_cle_unique(string $article_Libelle, string $article_Photo_Fichier, float $article_Prix, bool $article_Actif, int $Code_type_produit)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return $Code_type_produit . '.' . sha1($article_Libelle . '.' . $article_Photo_Fichier . '.' . $article_Prix . '.' . $article_Actif);
    }

    static function ajouter(int $Code_article)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['article__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__article_Libelle'] = false;
        $mf_droits_defaut['api_modifier__article_Photo_Fichier'] = false;
        $mf_droits_defaut['api_modifier__article_Prix'] = false;
        $mf_droits_defaut['api_modifier__article_Actif'] = false;
        $mf_droits_defaut['api_modifier_ref__article__Code_type_produit'] = false;
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_modification(int $Code_article, string $article_Libelle__new, string $article_Photo_Fichier__new, float $article_Prix__new, bool $article_Actif__new, int $Code_type_produit__new)
    {
        return true;
    }

    static function data_controller__article_Libelle(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    static function data_controller__article_Photo_Fichier(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    static function data_controller__article_Prix(float $old, float &$new, int $Code_article)
    {
        // ici le code
    }

    static function data_controller__article_Actif(bool $old, bool &$new, int $Code_article)
    {
        // ici le code
    }

    static function data_controller__Code_type_produit(int $old, int &$new, int $Code_article)
    {
        // ici le code
    }

    /*
     * modifier : $Code_article permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_article, bool $bool__article_Libelle, bool $bool__article_Photo_Fichier, bool $bool__article_Prix, bool $bool__article_Actif, bool $bool__Code_type_produit)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['article__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($Code_article != 0 && $mf_droits_defaut['article__SUPPRIMER']) {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_article)
    {
        return true;
    }

    static function supprimer(array $copie__article)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_article)
    {
        foreach ($copie__liste_article as &$copie__article) {
            self::supprimer($copie__article);
        }
        unset($copie__article);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_article']
         * $donnees['Code_type_produit']
         * $donnees['article_Libelle']
         * $donnees['article_Photo_Fichier']
         * $donnees['article_Prix']
         * $donnees['article_Actif']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_article)
    {
        // ici le code
    }

    static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_article']
         * $donnees['Code_type_produit']
         * $donnees['article_Libelle']
         * $donnees['article_Photo_Fichier']
         * $donnees['article_Prix']
         * $donnees['article_Actif']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    static function callback_post(int $Code_article)
    {
        return null;
    }

    static function callback_put(int $Code_article)
    {
        return null;
    }
}
