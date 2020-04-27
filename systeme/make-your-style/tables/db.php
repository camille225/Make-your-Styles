<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class DB
{

    private $utilisateur = null;
    private $article = null;
    private $commande = null;
    private $categorie_article = null;
    private $parametre = null;
    private $vue_utilisateur = null;
    private $sous_categorie_article = null;
    private $conseil = null;
    private $a_commande_article = null;
    private $a_parametre_utilisateur = null;
    private $a_filtrer = null;

    public function __construct()
    {
    }

    /**
     * @return table_utilisateur
     */
    public function utilisateur(): table_utilisateur
    {
        if ($this->utilisateur == null) {
            $this->utilisateur = new table_utilisateur();
        }
        return $this->utilisateur;
    }

    /**
     * @return table_article
     */
    public function article(): table_article
    {
        if ($this->article == null) {
            $this->article = new table_article();
        }
        return $this->article;
    }

    /**
     * @return table_commande
     */
    public function commande(): table_commande
    {
        if ($this->commande == null) {
            $this->commande = new table_commande();
        }
        return $this->commande;
    }

    /**
     * @return table_categorie_article
     */
    public function categorie_article(): table_categorie_article
    {
        if ($this->categorie_article == null) {
            $this->categorie_article = new table_categorie_article();
        }
        return $this->categorie_article;
    }

    /**
     * @return table_parametre
     */
    public function parametre(): table_parametre
    {
        if ($this->parametre == null) {
            $this->parametre = new table_parametre();
        }
        return $this->parametre;
    }

    /**
     * @return table_vue_utilisateur
     */
    public function vue_utilisateur(): table_vue_utilisateur
    {
        if ($this->vue_utilisateur == null) {
            $this->vue_utilisateur = new table_vue_utilisateur();
        }
        return $this->vue_utilisateur;
    }

    /**
     * @return table_sous_categorie_article
     */
    public function sous_categorie_article(): table_sous_categorie_article
    {
        if ($this->sous_categorie_article == null) {
            $this->sous_categorie_article = new table_sous_categorie_article();
        }
        return $this->sous_categorie_article;
    }

    /**
     * @return table_conseil
     */
    public function conseil(): table_conseil
    {
        if ($this->conseil == null) {
            $this->conseil = new table_conseil();
        }
        return $this->conseil;
    }

    /**
     * @return table_a_commande_article
     */
    function a_commande_article(): table_a_commande_article
    {
        if ($this->a_commande_article == null) {
            $this->a_commande_article = new table_a_commande_article();
        }
        return $this->a_commande_article;
    }

    /**
     * @return table_a_parametre_utilisateur
     */
    function a_parametre_utilisateur(): table_a_parametre_utilisateur
    {
        if ($this->a_parametre_utilisateur == null) {
            $this->a_parametre_utilisateur = new table_a_parametre_utilisateur();
        }
        return $this->a_parametre_utilisateur;
    }

    /**
     * @return table_a_filtrer
     */
    function a_filtrer(): table_a_filtrer
    {
        if ($this->a_filtrer == null) {
            $this->a_filtrer = new table_a_filtrer();
        }
        return $this->a_filtrer;
    }


    static function mf_raz_instance()
    {
        table_utilisateur_monframework::mf_raz_instance();
        table_article_monframework::mf_raz_instance();
        table_commande_monframework::mf_raz_instance();
        table_categorie_article_monframework::mf_raz_instance();
        table_parametre_monframework::mf_raz_instance();
        table_vue_utilisateur_monframework::mf_raz_instance();
        table_sous_categorie_article_monframework::mf_raz_instance();
        table_conseil_monframework::mf_raz_instance();
        table_a_commande_article_monframework::mf_raz_instance();
        table_a_parametre_utilisateur_monframework::mf_raz_instance();
        table_a_filtrer_monframework::mf_raz_instance();
    }

    public function mf_table($nom_table)
    {
        switch ($nom_table) {
            case 'utilisateur':
                return $this->utilisateur();
                break;
            case 'article':
                return $this->article();
                break;
            case 'commande':
                return $this->commande();
                break;
            case 'categorie_article':
                return $this->categorie_article();
                break;
            case 'parametre':
                return $this->parametre();
                break;
            case 'vue_utilisateur':
                return $this->vue_utilisateur();
                break;
            case 'sous_categorie_article':
                return $this->sous_categorie_article();
                break;
            case 'conseil':
                return $this->conseil();
                break;
            case 'a_commande_article':
                return $this->a_commande_article();
                break;
            case 'a_parametre_utilisateur':
                return $this->a_parametre_utilisateur();
                break;
            case 'a_filtrer':
                return $this->a_filtrer();
                break;
            default:
                return null;
        }
    }

}
