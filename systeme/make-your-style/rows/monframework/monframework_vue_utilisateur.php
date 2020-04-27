<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_vue_utilisateur
{

    // Key
    private $Code_vue_utilisateur;

    // Column
    private $vue_utilisateur_Recherche = '';
    private $vue_utilisateur_Filtre_Saison_Type = 1;
    private $vue_utilisateur_Filtre_Couleur = '';
    private $vue_utilisateur_Filtre_Taille_Pays_Type = 1;
    private $vue_utilisateur_Filtre_Taille_Max = null;
    private $vue_utilisateur_Filtre_Taille_Min = null;

    /**
     * vue_utilisateur constructor.
     * @param int|null $Code_vue_utilisateur
     */
    function __construct(?int $Code_vue_utilisateur = null)
    {
        if ($Code_vue_utilisateur !== null) {
            $this->read_from_db($Code_vue_utilisateur);
        }
    }

    // Read
    public function read_from_db(int $Code_vue_utilisateur): bool
    {
        $db = new DB();
        $vue_utilisateur = $db->vue_utilisateur()->mf_get_2($Code_vue_utilisateur);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {
            $this->Code_vue_utilisateur = $vue_utilisateur['Code_vue_utilisateur'];
            $this->vue_utilisateur_Recherche = $vue_utilisateur['vue_utilisateur_Recherche'];
            $this->vue_utilisateur_Filtre_Saison_Type = $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'];
            $this->vue_utilisateur_Filtre_Couleur = $vue_utilisateur['vue_utilisateur_Filtre_Couleur'];
            $this->vue_utilisateur_Filtre_Taille_Pays_Type = $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'];
            $this->vue_utilisateur_Filtre_Taille_Max = $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'];
            $this->vue_utilisateur_Filtre_Taille_Min = $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_vue_utilisateur(): int { return $this->Code_vue_utilisateur; }

    // Columns
    // vue_utilisateur_Recherche
    public function get_Recherche(): string { return $this->vue_utilisateur_Recherche; }
    public function set_Recherche(string $vue_utilisateur_Recherche)  { $this->vue_utilisateur_Recherche = $vue_utilisateur_Recherche; }
    // vue_utilisateur_Filtre_Saison_Type
    public function get_Filtre_Saison_Type(): ?int { return $this->vue_utilisateur_Filtre_Saison_Type; }
    public function set_Filtre_Saison_Type(?int $vue_utilisateur_Filtre_Saison_Type)  { $this->vue_utilisateur_Filtre_Saison_Type = $vue_utilisateur_Filtre_Saison_Type; }
    // vue_utilisateur_Filtre_Couleur
    public function get_Filtre_Couleur(): string { return $this->vue_utilisateur_Filtre_Couleur; }
    public function set_Filtre_Couleur(string $vue_utilisateur_Filtre_Couleur)  { $this->vue_utilisateur_Filtre_Couleur = $vue_utilisateur_Filtre_Couleur; }
    // vue_utilisateur_Filtre_Taille_Pays_Type
    public function get_Filtre_Taille_Pays_Type(): ?int { return $this->vue_utilisateur_Filtre_Taille_Pays_Type; }
    public function set_Filtre_Taille_Pays_Type(?int $vue_utilisateur_Filtre_Taille_Pays_Type)  { $this->vue_utilisateur_Filtre_Taille_Pays_Type = $vue_utilisateur_Filtre_Taille_Pays_Type; }
    // vue_utilisateur_Filtre_Taille_Max
    public function get_Filtre_Taille_Max(): ?int { return $this->vue_utilisateur_Filtre_Taille_Max; }
    public function set_Filtre_Taille_Max(?int $vue_utilisateur_Filtre_Taille_Max)  { $this->vue_utilisateur_Filtre_Taille_Max = $vue_utilisateur_Filtre_Taille_Max; }
    // vue_utilisateur_Filtre_Taille_Min
    public function get_Filtre_Taille_Min(): ?int { return $this->vue_utilisateur_Filtre_Taille_Min; }
    public function set_Filtre_Taille_Min(?int $vue_utilisateur_Filtre_Taille_Min)  { $this->vue_utilisateur_Filtre_Taille_Min = $vue_utilisateur_Filtre_Taille_Min; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $vue_utilisateur = [];
        $vue_utilisateur['Code_vue_utilisateur'] = $this->Code_vue_utilisateur;
        $vue_utilisateur['vue_utilisateur_Recherche'] = $this->vue_utilisateur_Recherche;
        $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'] = $this->vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur['vue_utilisateur_Filtre_Couleur'] = $this->vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'] = $this->vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'] = $this->vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'] = $this->vue_utilisateur_Filtre_Taille_Min;
        $db = new DB();
        return $db->vue_utilisateur()->mf_modifier_2([$this->Code_vue_utilisateur => $vue_utilisateur], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $vue_utilisateur = [];
        $vue_utilisateur['vue_utilisateur_Recherche'] = $this->vue_utilisateur_Recherche;
        $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'] = $this->vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur['vue_utilisateur_Filtre_Couleur'] = $this->vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'] = $this->vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'] = $this->vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'] = $this->vue_utilisateur_Filtre_Taille_Min;
        $db = new DB();
        $r = $db->vue_utilisateur()->mf_ajouter_2($vue_utilisateur, $force);
        return $r['Code_vue_utilisateur'];
    }

}
