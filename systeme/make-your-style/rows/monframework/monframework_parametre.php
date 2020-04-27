<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_parametre
{

    // Key
    private $Code_parametre;

    // Column
    private $parametre_Libelle = '';

    /**
     * parametre constructor.
     * @param int|null $Code_parametre
     */
    function __construct(?int $Code_parametre = null)
    {
        if ($Code_parametre !== null) {
            $this->read_from_db($Code_parametre);
        }
    }

    // Read
    public function read_from_db(int $Code_parametre): bool
    {
        $db = new DB();
        $parametre = $db->parametre()->mf_get_2($Code_parametre);
        if (isset($parametre['Code_parametre'])) {
            $this->Code_parametre = $parametre['Code_parametre'];
            $this->parametre_Libelle = $parametre['parametre_Libelle'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_parametre(): int { return $this->Code_parametre; }

    // Columns
    // parametre_Libelle
    public function get_Libelle(): string { return $this->parametre_Libelle; }
    public function set_Libelle(string $parametre_Libelle)  { $this->parametre_Libelle = $parametre_Libelle; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $parametre = [];
        $parametre['Code_parametre'] = $this->Code_parametre;
        $parametre['parametre_Libelle'] = $this->parametre_Libelle;
        $db = new DB();
        return $db->parametre()->mf_modifier_2([$this->Code_parametre => $parametre], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $parametre = [];
        $parametre['parametre_Libelle'] = $this->parametre_Libelle;
        $db = new DB();
        $r = $db->parametre()->mf_ajouter_2($parametre, $force);
        return $r['Code_parametre'];
    }

}
