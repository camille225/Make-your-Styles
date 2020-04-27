<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_commande
{

    // Key
    private $Code_commande;

    // Column
    private $commande_Prix_total = null;
    private $commande_Date_livraison = '';
    private $commande_Date_creation = '';

    // Referecences
    private $Code_utilisateur;

    /**
     * commande constructor.
     * @param int|null $Code_commande
     */
    function __construct(?int $Code_commande = null)
    {
        if ($Code_commande !== null) {
            $this->read_from_db($Code_commande);
        }
    }

    // Read
    public function read_from_db(int $Code_commande): bool
    {
        $db = new DB();
        $commande = $db->commande()->mf_get_2($Code_commande);
        if (isset($commande['Code_commande'])) {
            $this->Code_commande = $commande['Code_commande'];
            $this->commande_Prix_total = $commande['commande_Prix_total'];
            $this->commande_Date_livraison = $commande['commande_Date_livraison'];
            $this->commande_Date_creation = $commande['commande_Date_creation'];
            $this->Code_utilisateur = $commande['Code_utilisateur'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_commande(): int { return $this->Code_commande; }

    // Columns
    // commande_Prix_total
    public function get_Prix_total(): ?float { return $this->commande_Prix_total; }
    public function set_Prix_total(?float $commande_Prix_total)  { $this->commande_Prix_total = $commande_Prix_total; }
    // commande_Date_livraison
    public function get_Date_livraison(): string { return $this->commande_Date_livraison; }
    public function set_Date_livraison(string $commande_Date_livraison)  { $this->commande_Date_livraison = $commande_Date_livraison; }
    // commande_Date_creation
    public function get_Date_creation(): string { return $this->commande_Date_creation; }
    public function set_Date_creation(string $commande_Date_creation)  { $this->commande_Date_creation = $commande_Date_creation; }

    // Referecences
    // Code_utilisateur
    public function get_Code_utilisateur(): int { return $this->Code_utilisateur; }
    public function set_Code_utilisateur(int $Code_utilisateur) { $this->Code_utilisateur = $Code_utilisateur; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $commande = [];
        $commande['Code_commande'] = $this->Code_commande;
        $commande['commande_Prix_total'] = $this->commande_Prix_total;
        $commande['commande_Date_livraison'] = $this->commande_Date_livraison;
        $commande['commande_Date_creation'] = $this->commande_Date_creation;
        $commande['Code_utilisateur'] = $this->Code_utilisateur;
        $db = new DB();
        return $db->commande()->mf_modifier_2([$this->Code_commande => $commande], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $commande = [];
        $commande['commande_Prix_total'] = $this->commande_Prix_total;
        $commande['commande_Date_livraison'] = $this->commande_Date_livraison;
        $commande['commande_Date_creation'] = $this->commande_Date_creation;
        $commande['Code_utilisateur'] = $this->Code_utilisateur;
        $db = new DB();
        $r = $db->commande()->mf_ajouter_2($commande, $force);
        return $r['Code_commande'];
    }

}
