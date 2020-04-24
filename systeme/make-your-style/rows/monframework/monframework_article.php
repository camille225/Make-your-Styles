<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_article
{

    // Key
    private $Code_article;

    // Column
    private $article_Libelle = '';
    private $article_Description = '';
    private $article_Saison_Type = 1;
    private $article_Nom_fournisseur = '';
    private $article_Url = '';
    private $article_Reference = '';
    private $article_Couleur = '';
    private $article_Code_couleur_svg = '';
    private $article_Taille_Pays_Type = 1;
    private $article_Taille = null;
    private $article_Matiere = '';
    private $article_Photo_Fichier = '';
    private $article_Prix = null;
    private $article_Actif = false;

    // Referecences
    private $Code_sous_categorie_article;

    // Indirect references
    private $Code_categorie_article;

    /**
     * article constructor.
     * @param int|null $Code_article
     */
    function __construct(?int $Code_article = null)
    {
        if ($Code_article !== null) {
            $this->read_from_db($Code_article);
        }
    }

    // Read
    public function read_from_db(int $Code_article): bool
    {
        $db = new DB();
        $article = $db->article()->mf_get_2($Code_article);
        if (isset($article['Code_article'])) {
            $this->Code_article = $article['Code_article'];
            $this->article_Libelle = $article['article_Libelle'];
            $this->article_Description = $article['article_Description'];
            $this->article_Saison_Type = $article['article_Saison_Type'];
            $this->article_Nom_fournisseur = $article['article_Nom_fournisseur'];
            $this->article_Url = $article['article_Url'];
            $this->article_Reference = $article['article_Reference'];
            $this->article_Couleur = $article['article_Couleur'];
            $this->article_Code_couleur_svg = $article['article_Code_couleur_svg'];
            $this->article_Taille_Pays_Type = $article['article_Taille_Pays_Type'];
            $this->article_Taille = $article['article_Taille'];
            $this->article_Matiere = $article['article_Matiere'];
            $this->article_Photo_Fichier = $article['article_Photo_Fichier'];
            $this->article_Prix = $article['article_Prix'];
            $this->article_Actif = $article['article_Actif'];
            $this->Code_sous_categorie_article = $article['Code_sous_categorie_article'];
            $this->genealogy();
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_article(): int { return $this->Code_article; }

    // Columns
    // article_Libelle
    public function get_Libelle(): string { return $this->article_Libelle; }
    public function set_Libelle(string $article_Libelle)  { $this->article_Libelle = $article_Libelle; }
    // article_Description
    public function get_Description(): string { return $this->article_Description; }
    public function set_Description(string $article_Description)  { $this->article_Description = $article_Description; }
    // article_Saison_Type
    public function get_Saison_Type(): ?int { return $this->article_Saison_Type; }
    public function set_Saison_Type(?int $article_Saison_Type)  { $this->article_Saison_Type = $article_Saison_Type; }
    // article_Nom_fournisseur
    public function get_Nom_fournisseur(): string { return $this->article_Nom_fournisseur; }
    public function set_Nom_fournisseur(string $article_Nom_fournisseur)  { $this->article_Nom_fournisseur = $article_Nom_fournisseur; }
    // article_Url
    public function get_Url(): string { return $this->article_Url; }
    public function set_Url(string $article_Url)  { $this->article_Url = $article_Url; }
    // article_Reference
    public function get_Reference(): string { return $this->article_Reference; }
    public function set_Reference(string $article_Reference)  { $this->article_Reference = $article_Reference; }
    // article_Couleur
    public function get_Couleur(): string { return $this->article_Couleur; }
    public function set_Couleur(string $article_Couleur)  { $this->article_Couleur = $article_Couleur; }
    // article_Code_couleur_svg
    public function get_Code_couleur_svg(): string { return $this->article_Code_couleur_svg; }
    public function set_Code_couleur_svg(string $article_Code_couleur_svg)  { $this->article_Code_couleur_svg = $article_Code_couleur_svg; }
    // article_Taille_Pays_Type
    public function get_Taille_Pays_Type(): ?int { return $this->article_Taille_Pays_Type; }
    public function set_Taille_Pays_Type(?int $article_Taille_Pays_Type)  { $this->article_Taille_Pays_Type = $article_Taille_Pays_Type; }
    // article_Taille
    public function get_Taille(): ?int { return $this->article_Taille; }
    public function set_Taille(?int $article_Taille)  { $this->article_Taille = $article_Taille; }
    // article_Matiere
    public function get_Matiere(): string { return $this->article_Matiere; }
    public function set_Matiere(string $article_Matiere)  { $this->article_Matiere = $article_Matiere; }
    // article_Photo_Fichier
    public function get_Photo_Fichier(): string { return $this->article_Photo_Fichier; }
    public function set_Photo_Fichier(string $article_Photo_Fichier)  { $this->article_Photo_Fichier = $article_Photo_Fichier; }
    // article_Prix
    public function get_Prix(): ?float { return $this->article_Prix; }
    public function set_Prix(?float $article_Prix)  { $this->article_Prix = $article_Prix; }
    // article_Actif
    public function get_Actif(): ?bool { return $this->article_Actif; }
    public function set_Actif(?bool $article_Actif)  { $this->article_Actif = $article_Actif; }

    // Referecences
    // Code_sous_categorie_article
    public function get_Code_sous_categorie_article(): int { return $this->Code_sous_categorie_article; }
    public function set_Code_sous_categorie_article(int $Code_sous_categorie_article) { $this->Code_sous_categorie_article = $Code_sous_categorie_article; $this->genealogy(); }

    // Write in DB
    public function write(bool $force=false): array
    {
        $article = [];
        $article['Code_article'] = $this->Code_article;
        $article['article_Libelle'] = $this->article_Libelle;
        $article['article_Description'] = $this->article_Description;
        $article['article_Saison_Type'] = $this->article_Saison_Type;
        $article['article_Nom_fournisseur'] = $this->article_Nom_fournisseur;
        $article['article_Url'] = $this->article_Url;
        $article['article_Reference'] = $this->article_Reference;
        $article['article_Couleur'] = $this->article_Couleur;
        $article['article_Code_couleur_svg'] = $this->article_Code_couleur_svg;
        $article['article_Taille_Pays_Type'] = $this->article_Taille_Pays_Type;
        $article['article_Taille'] = $this->article_Taille;
        $article['article_Matiere'] = $this->article_Matiere;
        $article['article_Photo_Fichier'] = $this->article_Photo_Fichier;
        $article['article_Prix'] = $this->article_Prix;
        $article['article_Actif'] = $this->article_Actif;
        $article['Code_sous_categorie_article'] = $this->Code_sous_categorie_article;
        $db = new DB();
        return $db->article()->mf_modifier_2([$this->Code_article => $article], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $article = [];
        $article['article_Libelle'] = $this->article_Libelle;
        $article['article_Description'] = $this->article_Description;
        $article['article_Saison_Type'] = $this->article_Saison_Type;
        $article['article_Nom_fournisseur'] = $this->article_Nom_fournisseur;
        $article['article_Url'] = $this->article_Url;
        $article['article_Reference'] = $this->article_Reference;
        $article['article_Couleur'] = $this->article_Couleur;
        $article['article_Code_couleur_svg'] = $this->article_Code_couleur_svg;
        $article['article_Taille_Pays_Type'] = $this->article_Taille_Pays_Type;
        $article['article_Taille'] = $this->article_Taille;
        $article['article_Matiere'] = $this->article_Matiere;
        $article['article_Photo_Fichier'] = $this->article_Photo_Fichier;
        $article['article_Prix'] = $this->article_Prix;
        $article['article_Actif'] = $this->article_Actif;
        $article['Code_sous_categorie_article'] = $this->Code_sous_categorie_article;
        $db = new DB();
        $r = $db->article()->mf_ajouter_2($article, $force);
        return $r['Code_article'];
    }

    // Indirect references
    // Code_categorie_article
    public function get_Code_categorie_article(): int { return $this->Code_categorie_article; }

    // Indirect references
    private function genealogy()
    {
        $db = new DB();
        $this->Code_categorie_article = $db->sous_categorie_article()->mf_convertir_Code_sous_categorie_article_vers_Code_categorie_article($this->Code_sous_categorie_article);
    }

}
