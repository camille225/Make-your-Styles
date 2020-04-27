<?php declare(strict_types=1);

class Hook_sous_categorie_article
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(string &$sous_categorie_article_Libelle, int &$Code_categorie_article, ?int $Code_sous_categorie_article = null)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter(?int $Code_categorie_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['sous_categorie_article__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['sous_categorie_article__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(string $sous_categorie_article_Libelle, int $Code_categorie_article)
    {
        return true;
    }

    public static function data_controller(string &$sous_categorie_article_Libelle, int &$Code_categorie_article, ?int $Code_sous_categorie_article = null)
    {
        // ici le code
    }

    public static function calcul_signature(string $sous_categorie_article_Libelle, int $Code_categorie_article): string
    {
        return md5("$sous_categorie_article_Libelle-$Code_categorie_article");
    }

    public static function calcul_cle_unique(string $sous_categorie_article_Libelle, int $Code_categorie_article): string
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return "$Code_categorie_article".sha1("$sous_categorie_article_Libelle");
    }

    public static function ajouter(int $Code_sous_categorie_article)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_sous_categorie_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['sous_categorie_article__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__sous_categorie_article_Libelle'] = false;
        $mf_droits_defaut['api_modifier_ref__sous_categorie_article__Code_categorie_article'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_modification(int $Code_sous_categorie_article, string $sous_categorie_article_Libelle__new, int $Code_categorie_article__new)
    {
        return true;
    }

    public static function data_controller__sous_categorie_article_Libelle(string $old, string &$new, int $Code_sous_categorie_article)
    {
        // ici le code
    }

    public static function data_controller__Code_categorie_article(int $old, int &$new, int $Code_sous_categorie_article)
    {
        // ici le code
    }

    /*
     * modifier : $Code_sous_categorie_article permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_sous_categorie_article, bool $bool__sous_categorie_article_Libelle, bool $bool__Code_categorie_article)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_sous_categorie_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['sous_categorie_article__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($Code_sous_categorie_article != 0 && $mf_droits_defaut['sous_categorie_article__SUPPRIMER']) {
            $db = new DB();
            $mf_droits_defaut['sous_categorie_article__SUPPRIMER'] = $db->article()->mfi_compter(['Code_sous_categorie_article' => $Code_sous_categorie_article]) == 0;
        }
    }

    public static function autorisation_suppression(int $Code_sous_categorie_article)
    {
        return true;
    }

    public static function supprimer(array $copie__sous_categorie_article)
    {
        // ici le code
    }

    public static function supprimer_2(array $copie__liste_sous_categorie_article)
    {
        foreach ($copie__liste_sous_categorie_article as &$copie__sous_categorie_article) {
            self::supprimer($copie__sous_categorie_article);
        }
        unset($copie__sous_categorie_article);
    }

    public static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_sous_categorie_article']
         * $donnees['Code_categorie_article']
         * $donnees['sous_categorie_article_Libelle']
         */
        return true;
    }

    public static function mettre_a_jour(array $liste_sous_categorie_article)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_sous_categorie_article']
         * $donnees['Code_categorie_article']
         * $donnees['sous_categorie_article_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_sous_categorie_article)
    {
        return null;
    }

    public static function callback_put(int $Code_sous_categorie_article)
    {
        return null;
    }
}
