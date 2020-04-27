<?php declare(strict_types=1);

class Hook_categorie_article
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(string &$categorie_article_Libelle, ?int $Code_categorie_article = null)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['categorie_article__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['categorie_article__CREER'] = false;
        // Mise à jour des droits
        if (est_administrateur()) {
            $mf_droits_defaut['categorie_article__AJOUTER'] = true;
        }
    }

    public static function autorisation_ajout(string $categorie_article_Libelle)
    {
        return true;
    }

    public static function data_controller(string &$categorie_article_Libelle, ?int $Code_categorie_article = null)
    {
        // ici le code
    }

    public static function calcul_signature(string $categorie_article_Libelle): string
    {
        return md5("$categorie_article_Libelle");
    }

    public static function calcul_cle_unique(string $categorie_article_Libelle): string
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1("$categorie_article_Libelle");
    }

    public static function ajouter(int $Code_categorie_article)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_categorie_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['categorie_article__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__categorie_article_Libelle'] = false;
        // Mise à jour des droits
        if (est_administrateur()) {
            $mf_droits_defaut['api_modifier__categorie_article_Libelle'] = true;
        }
    }

    public static function autorisation_modification(int $Code_categorie_article, string $categorie_article_Libelle__new)
    {
        return true;
    }

    public static function data_controller__categorie_article_Libelle(string $old, string &$new, int $Code_categorie_article)
    {
        // ici le code
    }

    /*
     * modifier : $Code_categorie_article permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_categorie_article, bool $bool__categorie_article_Libelle)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_categorie_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['categorie_article__SUPPRIMER'] = false;
        // Mise à jour des droits
        if (est_administrateur()) {
            $mf_droits_defaut['categorie_article__SUPPRIMER'] = true;
        }
        if ($Code_categorie_article != 0 && $mf_droits_defaut['categorie_article__SUPPRIMER']) {
            $db = new DB();
            $mf_droits_defaut['categorie_article__SUPPRIMER'] = $db->sous_categorie_article()->mfi_compter(['Code_categorie_article' => $Code_categorie_article]) == 0;
        }
    }

    public static function autorisation_suppression(int $Code_categorie_article)
    {
        return true;
    }

    public static function supprimer(array $copie__categorie_article)
    {
        // ici le code
    }

    public static function supprimer_2(array $copie__liste_categorie_article)
    {
        foreach ($copie__liste_categorie_article as &$copie__categorie_article) {
            self::supprimer($copie__categorie_article);
        }
        unset($copie__categorie_article);
    }

    public static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_categorie_article']
         * $donnees['categorie_article_Libelle']
         */
        return true;
    }

    public static function mettre_a_jour(array $liste_categorie_article)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_categorie_article']
         * $donnees['categorie_article_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_categorie_article)
    {
        return null;
    }

    public static function callback_put(int $Code_categorie_article)
    {
        return null;
    }
}
