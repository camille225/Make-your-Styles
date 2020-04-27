<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_sous_categorie_article
{

    // Key
    private $Code_sous_categorie_article;

    // Column
    private $sous_categorie_article_Libelle = '';

    // Referecences
    private $Code_categorie_article;

    /**
     * sous_categorie_article constructor.
     * @param int|null $Code_sous_categorie_article
     */
    function __construct(?int $Code_sous_categorie_article = null)
    {
        if ($Code_sous_categorie_article !== null) {
            $this->read_from_db($Code_sous_categorie_article);
        }
    }

    // Read
    public function read_from_db(int $Code_sous_categorie_article): bool
    {
        $db = new DB();
        $sous_categorie_article = $db->sous_categorie_article()->mf_get_2($Code_sous_categorie_article);
        if (isset($sous_categorie_article['Code_sous_categorie_article'])) {
            $this->Code_sous_categorie_article = $sous_categorie_article['Code_sous_categorie_article'];
            $this->sous_categorie_article_Libelle = $sous_categorie_article['sous_categorie_article_Libelle'];
            $this->Code_categorie_article = $sous_categorie_article['Code_categorie_article'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_sous_categorie_article(): int { return $this->Code_sous_categorie_article; }

    // Columns
    // sous_categorie_article_Libelle
    public function get_Libelle(): string { return $this->sous_categorie_article_Libelle; }
    public function set_Libelle(string $sous_categorie_article_Libelle)  { $this->sous_categorie_article_Libelle = $sous_categorie_article_Libelle; }

    // Referecences
    // Code_categorie_article
    public function get_Code_categorie_article(): int { return $this->Code_categorie_article; }
    public function set_Code_categorie_article(int $Code_categorie_article) { $this->Code_categorie_article = $Code_categorie_article; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $sous_categorie_article = [];
        $sous_categorie_article['Code_sous_categorie_article'] = $this->Code_sous_categorie_article;
        $sous_categorie_article['sous_categorie_article_Libelle'] = $this->sous_categorie_article_Libelle;
        $sous_categorie_article['Code_categorie_article'] = $this->Code_categorie_article;
        $db = new DB();
        return $db->sous_categorie_article()->mf_modifier_2([$this->Code_sous_categorie_article => $sous_categorie_article], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $sous_categorie_article = [];
        $sous_categorie_article['sous_categorie_article_Libelle'] = $this->sous_categorie_article_Libelle;
        $sous_categorie_article['Code_categorie_article'] = $this->Code_categorie_article;
        $db = new DB();
        $r = $db->sous_categorie_article()->mf_ajouter_2($sous_categorie_article, $force);
        return $r['Code_sous_categorie_article'];
    }

}
