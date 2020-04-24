<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_utilisateur
{

    // Key
    private $Code_utilisateur;

    // Column
    private $utilisateur_Identifiant = '';
    private $utilisateur_Password = '';
    private $utilisateur_Email = '';
    private $utilisateur_Civilite_Type = 1;
    private $utilisateur_Prenom = '';
    private $utilisateur_Nom = '';
    private $utilisateur_Adresse_1 = '';
    private $utilisateur_Adresse_2 = '';
    private $utilisateur_Ville = '';
    private $utilisateur_Code_postal = '';
    private $utilisateur_Date_naissance = '';
    private $utilisateur_Accepte_mail_publicitaire = false;
    private $utilisateur_Administrateur = false;
    private $utilisateur_Fournisseur = false;

    /**
     * utilisateur constructor.
     * @param int|null $Code_utilisateur
     */
    function __construct(?int $Code_utilisateur = null)
    {
        if ($Code_utilisateur !== null) {
            $this->read_from_db($Code_utilisateur);
        }
    }

    // Read
    public function read_from_db(int $Code_utilisateur): bool
    {
        $db = new DB();
        $utilisateur = $db->utilisateur()->mf_get_2($Code_utilisateur);
        if (isset($utilisateur['Code_utilisateur'])) {
            $this->Code_utilisateur = $utilisateur['Code_utilisateur'];
            $this->utilisateur_Identifiant = $utilisateur['utilisateur_Identifiant'];
            $this->utilisateur_Password = $utilisateur['utilisateur_Password'];
            $this->utilisateur_Email = $utilisateur['utilisateur_Email'];
            $this->utilisateur_Civilite_Type = $utilisateur['utilisateur_Civilite_Type'];
            $this->utilisateur_Prenom = $utilisateur['utilisateur_Prenom'];
            $this->utilisateur_Nom = $utilisateur['utilisateur_Nom'];
            $this->utilisateur_Adresse_1 = $utilisateur['utilisateur_Adresse_1'];
            $this->utilisateur_Adresse_2 = $utilisateur['utilisateur_Adresse_2'];
            $this->utilisateur_Ville = $utilisateur['utilisateur_Ville'];
            $this->utilisateur_Code_postal = $utilisateur['utilisateur_Code_postal'];
            $this->utilisateur_Date_naissance = $utilisateur['utilisateur_Date_naissance'];
            $this->utilisateur_Accepte_mail_publicitaire = $utilisateur['utilisateur_Accepte_mail_publicitaire'];
            $this->utilisateur_Administrateur = $utilisateur['utilisateur_Administrateur'];
            $this->utilisateur_Fournisseur = $utilisateur['utilisateur_Fournisseur'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    public function get_Code_utilisateur(): int { return $this->Code_utilisateur; }

    // Columns
    // utilisateur_Identifiant
    public function get_Identifiant(): string { return $this->utilisateur_Identifiant; }
    public function set_Identifiant(string $utilisateur_Identifiant)  { $this->utilisateur_Identifiant = $utilisateur_Identifiant; }
    // utilisateur_Password
    public function get_Password(): string { return $this->utilisateur_Password; }
    public function set_Password(string $utilisateur_Password)  { $this->utilisateur_Password = $utilisateur_Password; }
    // utilisateur_Email
    public function get_Email(): string { return $this->utilisateur_Email; }
    public function set_Email(string $utilisateur_Email)  { $this->utilisateur_Email = $utilisateur_Email; }
    // utilisateur_Civilite_Type
    public function get_Civilite_Type(): ?int { return $this->utilisateur_Civilite_Type; }
    public function set_Civilite_Type(?int $utilisateur_Civilite_Type)  { $this->utilisateur_Civilite_Type = $utilisateur_Civilite_Type; }
    // utilisateur_Prenom
    public function get_Prenom(): string { return $this->utilisateur_Prenom; }
    public function set_Prenom(string $utilisateur_Prenom)  { $this->utilisateur_Prenom = $utilisateur_Prenom; }
    // utilisateur_Nom
    public function get_Nom(): string { return $this->utilisateur_Nom; }
    public function set_Nom(string $utilisateur_Nom)  { $this->utilisateur_Nom = $utilisateur_Nom; }
    // utilisateur_Adresse_1
    public function get_Adresse_1(): string { return $this->utilisateur_Adresse_1; }
    public function set_Adresse_1(string $utilisateur_Adresse_1)  { $this->utilisateur_Adresse_1 = $utilisateur_Adresse_1; }
    // utilisateur_Adresse_2
    public function get_Adresse_2(): string { return $this->utilisateur_Adresse_2; }
    public function set_Adresse_2(string $utilisateur_Adresse_2)  { $this->utilisateur_Adresse_2 = $utilisateur_Adresse_2; }
    // utilisateur_Ville
    public function get_Ville(): string { return $this->utilisateur_Ville; }
    public function set_Ville(string $utilisateur_Ville)  { $this->utilisateur_Ville = $utilisateur_Ville; }
    // utilisateur_Code_postal
    public function get_Code_postal(): string { return $this->utilisateur_Code_postal; }
    public function set_Code_postal(string $utilisateur_Code_postal)  { $this->utilisateur_Code_postal = $utilisateur_Code_postal; }
    // utilisateur_Date_naissance
    public function get_Date_naissance(): string { return $this->utilisateur_Date_naissance; }
    public function set_Date_naissance(string $utilisateur_Date_naissance)  { $this->utilisateur_Date_naissance = $utilisateur_Date_naissance; }
    // utilisateur_Accepte_mail_publicitaire
    public function get_Accepte_mail_publicitaire(): ?bool { return $this->utilisateur_Accepte_mail_publicitaire; }
    public function set_Accepte_mail_publicitaire(?bool $utilisateur_Accepte_mail_publicitaire)  { $this->utilisateur_Accepte_mail_publicitaire = $utilisateur_Accepte_mail_publicitaire; }
    // utilisateur_Administrateur
    public function get_Administrateur(): ?bool { return $this->utilisateur_Administrateur; }
    public function set_Administrateur(?bool $utilisateur_Administrateur)  { $this->utilisateur_Administrateur = $utilisateur_Administrateur; }
    // utilisateur_Fournisseur
    public function get_Fournisseur(): ?bool { return $this->utilisateur_Fournisseur; }
    public function set_Fournisseur(?bool $utilisateur_Fournisseur)  { $this->utilisateur_Fournisseur = $utilisateur_Fournisseur; }

    // Write in DB
    public function write(bool $force=false): array
    {
        $utilisateur = [];
        $utilisateur['Code_utilisateur'] = $this->Code_utilisateur;
        $utilisateur['utilisateur_Identifiant'] = $this->utilisateur_Identifiant;
        $utilisateur['utilisateur_Password'] = $this->utilisateur_Password;
        $utilisateur['utilisateur_Email'] = $this->utilisateur_Email;
        $utilisateur['utilisateur_Civilite_Type'] = $this->utilisateur_Civilite_Type;
        $utilisateur['utilisateur_Prenom'] = $this->utilisateur_Prenom;
        $utilisateur['utilisateur_Nom'] = $this->utilisateur_Nom;
        $utilisateur['utilisateur_Adresse_1'] = $this->utilisateur_Adresse_1;
        $utilisateur['utilisateur_Adresse_2'] = $this->utilisateur_Adresse_2;
        $utilisateur['utilisateur_Ville'] = $this->utilisateur_Ville;
        $utilisateur['utilisateur_Code_postal'] = $this->utilisateur_Code_postal;
        $utilisateur['utilisateur_Date_naissance'] = $this->utilisateur_Date_naissance;
        $utilisateur['utilisateur_Accepte_mail_publicitaire'] = $this->utilisateur_Accepte_mail_publicitaire;
        $utilisateur['utilisateur_Administrateur'] = $this->utilisateur_Administrateur;
        $utilisateur['utilisateur_Fournisseur'] = $this->utilisateur_Fournisseur;
        $db = new DB();
        return $db->utilisateur()->mf_modifier_2([$this->Code_utilisateur => $utilisateur], $force);
    }

    // Write as new in DB
    public function write_as_new(bool $force=false): int
    {
        $utilisateur = [];
        $utilisateur['utilisateur_Identifiant'] = $this->utilisateur_Identifiant;
        $utilisateur['utilisateur_Password'] = $this->utilisateur_Password;
        $utilisateur['utilisateur_Email'] = $this->utilisateur_Email;
        $utilisateur['utilisateur_Civilite_Type'] = $this->utilisateur_Civilite_Type;
        $utilisateur['utilisateur_Prenom'] = $this->utilisateur_Prenom;
        $utilisateur['utilisateur_Nom'] = $this->utilisateur_Nom;
        $utilisateur['utilisateur_Adresse_1'] = $this->utilisateur_Adresse_1;
        $utilisateur['utilisateur_Adresse_2'] = $this->utilisateur_Adresse_2;
        $utilisateur['utilisateur_Ville'] = $this->utilisateur_Ville;
        $utilisateur['utilisateur_Code_postal'] = $this->utilisateur_Code_postal;
        $utilisateur['utilisateur_Date_naissance'] = $this->utilisateur_Date_naissance;
        $utilisateur['utilisateur_Accepte_mail_publicitaire'] = $this->utilisateur_Accepte_mail_publicitaire;
        $utilisateur['utilisateur_Administrateur'] = $this->utilisateur_Administrateur;
        $utilisateur['utilisateur_Fournisseur'] = $this->utilisateur_Fournisseur;
        $db = new DB();
        $r = $db->utilisateur()->mf_ajouter_2($utilisateur, $force);
        return $r['Code_utilisateur'];
    }

}
