<?php

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
    private $type_produit = null;
    private $parametre = null;
    private $filtre = null;
    private $a_article_commande = null;
    private $a_filtre_produit = null;
    private $a_parametre_utilisateur = null;

    function __construct() {}

    function utilisateur()
    {
        if ($this->utilisateur == null) {
            $this->utilisateur = new utilisateur();
        } return $this->utilisateur;
    }

    function article()
    {
        if ($this->article == null) {
            $this->article = new article();
        } return $this->article;
    }

    function commande()
    {
        if ($this->commande == null) {
            $this->commande = new commande();
        } return $this->commande;
    }

    function type_produit()
    {
        if ($this->type_produit == null) {
            $this->type_produit = new type_produit();
        } return $this->type_produit;
    }

    function parametre()
    {
        if ($this->parametre == null) {
            $this->parametre = new parametre();
        } return $this->parametre;
    }

    function filtre()
    {
        if ($this->filtre == null) {
            $this->filtre = new filtre();
        } return $this->filtre;
    }

    function a_article_commande()
    {
        if ($this->a_article_commande == null) {
            $this->a_article_commande = new a_article_commande();
        }
        return $this->a_article_commande;
    }

    function a_filtre_produit()
    {
        if ($this->a_filtre_produit == null) {
            $this->a_filtre_produit = new a_filtre_produit();
        }
        return $this->a_filtre_produit;
    }

    function a_parametre_utilisateur()
    {
        if ($this->a_parametre_utilisateur == null) {
            $this->a_parametre_utilisateur = new a_parametre_utilisateur();
        }
        return $this->a_parametre_utilisateur;
    }


    static function mf_raz_instance() {
        utilisateur::mf_raz_instance();
        article::mf_raz_instance();
        commande::mf_raz_instance();
        type_produit::mf_raz_instance();
        parametre::mf_raz_instance();
        filtre::mf_raz_instance();
        a_article_commande::mf_raz_instance();
        a_filtre_produit::mf_raz_instance();
        a_parametre_utilisateur::mf_raz_instance();
    }

    function mf_table($nom_table) {
        switch ($nom_table) {
            case 'utilisateur': return $this->utilisateur(); break;
            case 'article': return $this->article(); break;
            case 'commande': return $this->commande(); break;
            case 'type_produit': return $this->type_produit(); break;
            case 'parametre': return $this->parametre(); break;
            case 'filtre': return $this->filtre(); break;
            case 'a_article_commande': return $this->a_article_commande(); break;
            case 'a_filtre_produit': return $this->a_filtre_produit(); break;
            case 'a_parametre_utilisateur': return $this->a_parametre_utilisateur(); break;
        }
    }

}
