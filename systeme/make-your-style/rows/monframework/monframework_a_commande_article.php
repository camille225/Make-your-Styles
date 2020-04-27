<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_a_commande_article
{

    // Key
    private $Code_commande;
    private $Code_article;

    // Column
    private $a_commande_article_Quantite = null;
    private $a_commande_article_Prix_ligne = null;

    /**
     * a_commande_article constructor.
     * @param int|null $Code_commande
     * @param int|null $Code_article
     */
    function __construct(?int $Code_commande = null, ?int $Code_article = null)
    {
        if ($Code_commande !== null && $Code_article !== null) {
            $this->read_from_db($Code_commande, $Code_article);
        }
    }

    // Read
    public function read_from_db(int $Code_commande, int $Code_article): bool
    {
        $db = new DB();
        $a_commande_article = $db->a_commande_article()->mf_get_2($Code_commande, $Code_article);
        if (isset($a_commande_article['Code_commande'])) {
            $this->a_commande_article_Quantite = $a_commande_article['a_commande_article_Quantite'];
            $this->a_commande_article_Prix_ligne = $a_commande_article['a_commande_article_Prix_ligne'];
            $this->Code_commande = $a_commande_article['Code_commande'];
            $this->Code_article = $a_commande_article['Code_article'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    // Code_commande
    public function get_Code_commande(): int { return $this->Code_commande; }
    // Code_article
    public function get_Code_article(): int { return $this->Code_article; }

    // Columns
    // a_commande_article_Quantite
    public function get_Quantite(): ?int { return $this->a_commande_article_Quantite; }
    public function set_Quantite(?int $a_commande_article_Quantite)  { $this->a_commande_article_Quantite = $a_commande_article_Quantite; }
    // a_commande_article_Prix_ligne
    public function get_Prix_ligne(): ?float { return $this->a_commande_article_Prix_ligne; }
    public function set_Prix_ligne(?float $a_commande_article_Prix_ligne)  { $this->a_commande_article_Prix_ligne = $a_commande_article_Prix_ligne; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $a_commande_article = [];
        $a_commande_article['a_commande_article_Quantite'] = $this->a_commande_article_Quantite;
        $a_commande_article['a_commande_article_Prix_ligne'] = $this->a_commande_article_Prix_ligne;
        $a_commande_article['Code_commande'] = $this->Code_commande;
        $a_commande_article['Code_article'] = $this->Code_article;
        $db = new DB();
        return $db->a_commande_article()->mf_modifier_2([$a_commande_article], $force);
    }

}
