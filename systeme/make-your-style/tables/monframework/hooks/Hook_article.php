<?php declare(strict_types=1);

class Hook_article
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(string &$article_Libelle, string &$article_Description, ?int &$article_Saison_Type, string &$article_Nom_fournisseur, string &$article_Url, string &$article_Reference, string &$article_Couleur, string &$article_Code_couleur_svg, ?int &$article_Taille_Pays_Type, ?int &$article_Taille, string &$article_Matiere, string &$article_Photo_Fichier, ?float &$article_Prix, bool &$article_Actif, int &$Code_sous_categorie_article, ?int $Code_article = null)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter(?int $Code_sous_categorie_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['article__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['article__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(string $article_Libelle, string $article_Description, ?int $article_Saison_Type, string $article_Nom_fournisseur, string $article_Url, string $article_Reference, string $article_Couleur, string $article_Code_couleur_svg, ?int $article_Taille_Pays_Type, ?int $article_Taille, string $article_Matiere, string $article_Photo_Fichier, ?float $article_Prix, bool $article_Actif, int $Code_sous_categorie_article)
    {
        return true;
    }

    public static function data_controller(string &$article_Libelle, string &$article_Description, ?int &$article_Saison_Type, string &$article_Nom_fournisseur, string &$article_Url, string &$article_Reference, string &$article_Couleur, string &$article_Code_couleur_svg, ?int &$article_Taille_Pays_Type, ?int &$article_Taille, string &$article_Matiere, string &$article_Photo_Fichier, ?float &$article_Prix, bool &$article_Actif, int &$Code_sous_categorie_article, ?int $Code_article = null)
    {
        // ici le code
    }

    public static function calcul_signature(string $article_Libelle, string $article_Description, ?int $article_Saison_Type, string $article_Nom_fournisseur, string $article_Url, string $article_Reference, string $article_Couleur, string $article_Code_couleur_svg, ?int $article_Taille_Pays_Type, ?int $article_Taille, string $article_Matiere, string $article_Photo_Fichier, ?float $article_Prix, bool $article_Actif, int $Code_sous_categorie_article): string
    {
        return md5("$article_Libelle-$article_Description-$article_Saison_Type-$article_Nom_fournisseur-$article_Url-$article_Reference-$article_Couleur-$article_Code_couleur_svg-$article_Taille_Pays_Type-$article_Taille-$article_Matiere-$article_Photo_Fichier-$article_Prix-$article_Actif-$Code_sous_categorie_article");
    }

    public static function calcul_cle_unique(string $article_Libelle, string $article_Description, ?int $article_Saison_Type, string $article_Nom_fournisseur, string $article_Url, string $article_Reference, string $article_Couleur, string $article_Code_couleur_svg, ?int $article_Taille_Pays_Type, ?int $article_Taille, string $article_Matiere, string $article_Photo_Fichier, ?float $article_Prix, bool $article_Actif, int $Code_sous_categorie_article): string
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return "$Code_sous_categorie_article".sha1("$article_Libelle-$article_Description-$article_Saison_Type-$article_Nom_fournisseur-$article_Url-$article_Reference-$article_Couleur-$article_Code_couleur_svg-$article_Taille_Pays_Type-$article_Taille-$article_Matiere-$article_Photo_Fichier-$article_Prix-$article_Actif");
    }

    public static function ajouter(int $Code_article)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['article__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__article_Libelle'] = false;
        $mf_droits_defaut['api_modifier__article_Description'] = false;
        $mf_droits_defaut['api_modifier__article_Saison_Type'] = false;
        $mf_droits_defaut['api_modifier__article_Nom_fournisseur'] = false;
        $mf_droits_defaut['api_modifier__article_Url'] = false;
        $mf_droits_defaut['api_modifier__article_Reference'] = false;
        $mf_droits_defaut['api_modifier__article_Couleur'] = false;
        $mf_droits_defaut['api_modifier__article_Code_couleur_svg'] = false;
        $mf_droits_defaut['api_modifier__article_Taille_Pays_Type'] = false;
        $mf_droits_defaut['api_modifier__article_Taille'] = false;
        $mf_droits_defaut['api_modifier__article_Matiere'] = false;
        $mf_droits_defaut['api_modifier__article_Photo_Fichier'] = false;
        $mf_droits_defaut['api_modifier__article_Prix'] = false;
        $mf_droits_defaut['api_modifier__article_Actif'] = false;
        $mf_droits_defaut['api_modifier_ref__article__Code_sous_categorie_article'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_modification(int $Code_article, string $article_Libelle__new, string $article_Description__new, ?int $article_Saison_Type__new, string $article_Nom_fournisseur__new, string $article_Url__new, string $article_Reference__new, string $article_Couleur__new, string $article_Code_couleur_svg__new, ?int $article_Taille_Pays_Type__new, ?int $article_Taille__new, string $article_Matiere__new, string $article_Photo_Fichier__new, ?float $article_Prix__new, bool $article_Actif__new, int $Code_sous_categorie_article__new)
    {
        return true;
    }

    /**
     * A partir de la valeur $article_Saison_Type, liste des états autorisés
     * Cette opéraion est effectuée en ammont.
     * @param int $article_Saison_Type
     * @return array
     */
    public static function workflow__article_Saison_Type(int $article_Saison_Type): array
    {
        // Par défaut, l'ensemble des choix sont permi
        global $lang_standard;
        return lister_cles($lang_standard['article_Saison_Type_']);
    }

    /**
     * A partir de la valeur $article_Taille_Pays_Type, liste des états autorisés
     * Cette opéraion est effectuée en ammont.
     * @param int $article_Taille_Pays_Type
     * @return array
     */
    public static function workflow__article_Taille_Pays_Type(int $article_Taille_Pays_Type): array
    {
        // Par défaut, l'ensemble des choix sont permi
        global $lang_standard;
        return lister_cles($lang_standard['article_Taille_Pays_Type_']);
    }

    public static function data_controller__article_Libelle(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Description(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Saison_Type(?int $old, ?int &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Nom_fournisseur(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Url(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Reference(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Couleur(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Code_couleur_svg(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Taille_Pays_Type(?int $old, ?int &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Taille(?int $old, ?int &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Matiere(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Photo_Fichier(string $old, string &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Prix(?float $old, ?float &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__article_Actif(bool $old, bool &$new, int $Code_article)
    {
        // ici le code
    }

    public static function data_controller__Code_sous_categorie_article(int $old, int &$new, int $Code_article)
    {
        // ici le code
    }

    /*
     * modifier : $Code_article permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_article, bool $bool__article_Libelle, bool $bool__article_Description, bool $bool__article_Saison_Type, bool $bool__article_Nom_fournisseur, bool $bool__article_Url, bool $bool__article_Reference, bool $bool__article_Couleur, bool $bool__article_Code_couleur_svg, bool $bool__article_Taille_Pays_Type, bool $bool__article_Taille, bool $bool__article_Matiere, bool $bool__article_Photo_Fichier, bool $bool__article_Prix, bool $bool__article_Actif, bool $bool__Code_sous_categorie_article)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_article = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['article__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
    }

    public static function autorisation_suppression(int $Code_article)
    {
        return true;
    }

    public static function supprimer(array $copie__article)
    {
        // ici le code
    }

    public static function supprimer_2(array $copie__liste_article)
    {
        foreach ($copie__liste_article as &$copie__article) {
            self::supprimer($copie__article);
        }
        unset($copie__article);
    }

    public static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_article']
         * $donnees['Code_sous_categorie_article']
         * $donnees['article_Libelle']
         * $donnees['article_Description']
         * $donnees['article_Saison_Type']
         * $donnees['article_Nom_fournisseur']
         * $donnees['article_Url']
         * $donnees['article_Reference']
         * $donnees['article_Couleur']
         * $donnees['article_Code_couleur_svg']
         * $donnees['article_Taille_Pays_Type']
         * $donnees['article_Taille']
         * $donnees['article_Matiere']
         * $donnees['article_Photo_Fichier']
         * $donnees['article_Prix']
         * $donnees['article_Actif']
         */
        return true;
    }

    public static function mettre_a_jour(array $liste_article)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_article']
         * $donnees['Code_sous_categorie_article']
         * $donnees['article_Libelle']
         * $donnees['article_Description']
         * $donnees['article_Saison_Type']
         * $donnees['article_Nom_fournisseur']
         * $donnees['article_Url']
         * $donnees['article_Reference']
         * $donnees['article_Couleur']
         * $donnees['article_Code_couleur_svg']
         * $donnees['article_Taille_Pays_Type']
         * $donnees['article_Taille']
         * $donnees['article_Matiere']
         * $donnees['article_Photo_Fichier']
         * $donnees['article_Prix']
         * $donnees['article_Actif']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_article)
    {
        return null;
    }

    public static function callback_put(int $Code_article)
    {
        return null;
    }
}
