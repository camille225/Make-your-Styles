<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_a_parametre_utilisateur
{

    // Key
    private $Code_utilisateur;
    private $Code_parametre;

    // Column
    private $a_parametre_utilisateur_Valeur = null;
    private $a_parametre_utilisateur_Actif = null;

    /**
     * a_parametre_utilisateur constructor.
     * @param int|null $Code_utilisateur
     * @param int|null $Code_parametre
     */
    function __construct(?int $Code_utilisateur = null, ?int $Code_parametre = null)
    {
        if ($Code_utilisateur !== null && $Code_parametre !== null) {
            $this->read_from_db($Code_utilisateur, $Code_parametre);
        }
    }

    // Read
    public function read_from_db(int $Code_utilisateur, int $Code_parametre): bool
    {
        $db = new DB();
        $a_parametre_utilisateur = $db->a_parametre_utilisateur()->mf_get_2($Code_utilisateur, $Code_parametre);
        if (isset($a_parametre_utilisateur['Code_utilisateur'])) {
            $this->a_parametre_utilisateur_Valeur = $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'];
            $this->a_parametre_utilisateur_Actif = $a_parametre_utilisateur['a_parametre_utilisateur_Actif'];
            $this->Code_utilisateur = $a_parametre_utilisateur['Code_utilisateur'];
            $this->Code_parametre = $a_parametre_utilisateur['Code_parametre'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    // Code_utilisateur
    public function get_Code_utilisateur(): int { return $this->Code_utilisateur; }
    // Code_parametre
    public function get_Code_parametre(): int { return $this->Code_parametre; }

    // Columns
    // a_parametre_utilisateur_Valeur
    public function get_Valeur(): ?int { return $this->a_parametre_utilisateur_Valeur; }
    public function set_Valeur(?int $a_parametre_utilisateur_Valeur)  { $this->a_parametre_utilisateur_Valeur = $a_parametre_utilisateur_Valeur; }
    // a_parametre_utilisateur_Actif
    public function get_Actif(): ?int { return $this->a_parametre_utilisateur_Actif; }
    public function set_Actif(?int $a_parametre_utilisateur_Actif)  { $this->a_parametre_utilisateur_Actif = $a_parametre_utilisateur_Actif; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $a_parametre_utilisateur = [];
        $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] = $this->a_parametre_utilisateur_Valeur;
        $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] = $this->a_parametre_utilisateur_Actif;
        $a_parametre_utilisateur['Code_utilisateur'] = $this->Code_utilisateur;
        $a_parametre_utilisateur['Code_parametre'] = $this->Code_parametre;
        $db = new DB();
        return $db->a_parametre_utilisateur()->mf_modifier_2([$a_parametre_utilisateur], $force);
    }

}
