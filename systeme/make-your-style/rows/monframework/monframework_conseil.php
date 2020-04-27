<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_conseil
{

    // Key
    private $Code_conseil;

    // Column
    private $conseil_Libelle = '';
    private $conseil_Description = '';
    private $conseil_Actif = false;

    /**
     * conseil constructor.
     * @param int|null $Code_conseil
     */
    function __construct(?int $Code_conseil = null)
    {
        if ($Code_conseil !== null) {
            $this->read_from_db($Code_conseil);
        }
    }

    // Read
    public function read_from_db(int $Code_conseil): bool
    {
        $db = new DB();
        $conseil = $db->conseil()->mf_get_2($Code_conseil);
        if (isset($conseil['Code_conseil'])) {
            $this->Code_conseil = $conseil['Code_conseil'];
            $this->conseil_Libelle = $conseil['conseil_Libelle'];
            $this->conseil_Description = $conseil['conseil_Description'];
            $this->conseil_Actif = $conseil['conseil_Actif'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_conseil(): int { return $this->Code_conseil; }

    // Columns
    // conseil_Libelle
    public function get_Libelle(): string { return $this->conseil_Libelle; }
    public function set_Libelle(string $conseil_Libelle)  { $this->conseil_Libelle = $conseil_Libelle; }
    // conseil_Description
    public function get_Description(): string { return $this->conseil_Description; }
    public function set_Description(string $conseil_Description)  { $this->conseil_Description = $conseil_Description; }
    // conseil_Actif
    public function get_Actif(): ?bool { return $this->conseil_Actif; }
    public function set_Actif(?bool $conseil_Actif)  { $this->conseil_Actif = $conseil_Actif; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $conseil = [];
        $conseil['Code_conseil'] = $this->Code_conseil;
        $conseil['conseil_Libelle'] = $this->conseil_Libelle;
        $conseil['conseil_Description'] = $this->conseil_Description;
        $conseil['conseil_Actif'] = $this->conseil_Actif;
        $db = new DB();
        return $db->conseil()->mf_modifier_2([$this->Code_conseil => $conseil], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $conseil = [];
        $conseil['conseil_Libelle'] = $this->conseil_Libelle;
        $conseil['conseil_Description'] = $this->conseil_Description;
        $conseil['conseil_Actif'] = $this->conseil_Actif;
        $db = new DB();
        $r = $db->conseil()->mf_ajouter_2($conseil, $force);
        return $r['Code_conseil'];
    }

}
