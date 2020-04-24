<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_categorie_article
{

    // Key
    private $Code_categorie_article;

    // Column
    private $categorie_article_Libelle = '';

    /**
     * categorie_article constructor.
     * @param int|null $Code_categorie_article
     */
    function __construct(?int $Code_categorie_article = null)
    {
        if ($Code_categorie_article !== null) {
            $this->read_from_db($Code_categorie_article);
        }
    }

    // Read
    public function read_from_db(int $Code_categorie_article): bool
    {
        $db = new DB();
        $categorie_article = $db->categorie_article()->mf_get_2($Code_categorie_article);
        if (isset($categorie_article['Code_categorie_article'])) {
            $this->Code_categorie_article = $categorie_article['Code_categorie_article'];
            $this->categorie_article_Libelle = $categorie_article['categorie_article_Libelle'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_categorie_article(): int { return $this->Code_categorie_article; }

    // Columns
    // categorie_article_Libelle
    public function get_Libelle(): string { return $this->categorie_article_Libelle; }
    public function set_Libelle(string $categorie_article_Libelle)  { $this->categorie_article_Libelle = $categorie_article_Libelle; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $categorie_article = [];
        $categorie_article['Code_categorie_article'] = $this->Code_categorie_article;
        $categorie_article['categorie_article_Libelle'] = $this->categorie_article_Libelle;
        $db = new DB();
        return $db->categorie_article()->mf_modifier_2([$this->Code_categorie_article => $categorie_article], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $categorie_article = [];
        $categorie_article['categorie_article_Libelle'] = $this->categorie_article_Libelle;
        $db = new DB();
        $r = $db->categorie_article()->mf_ajouter_2($categorie_article, $force);
        return $r['Code_categorie_article'];
    }

}
