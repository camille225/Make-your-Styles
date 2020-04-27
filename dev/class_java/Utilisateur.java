
public class Utilisateur {

    // key
    private int code_utilisateur;

    // dependences

    // informations
    private String utilisateur_Identifiant;
    private String utilisateur_Password;
    private String utilisateur_Email;
    private int utilisateur_Civilite_Type;
    private String utilisateur_Prenom;
    private String utilisateur_Nom;
    private String utilisateur_Adresse_1;
    private String utilisateur_Adresse_2;
    private String utilisateur_Ville;
    private String utilisateur_Code_postal;
    private String utilisateur_Date_naissance;
    private boolean utilisateur_Accepte_mail_publicitaire;
    private boolean utilisateur_Administrateur;
    private boolean utilisateur_Fournisseur;

    public Utilisateur() { }

    public Utilisateur( int code_utilisateur,  String utilisateur_Identifiant,  String utilisateur_Password,  String utilisateur_Email,  int utilisateur_Civilite_Type,  String utilisateur_Prenom,  String utilisateur_Nom,  String utilisateur_Adresse_1,  String utilisateur_Adresse_2,  String utilisateur_Ville,  String utilisateur_Code_postal,  String utilisateur_Date_naissance,  boolean utilisateur_Accepte_mail_publicitaire,  boolean utilisateur_Administrateur,  boolean utilisateur_Fournisseur ) {
        this.code_utilisateur = code_utilisateur;
        this.utilisateur_Identifiant = utilisateur_Identifiant;
        this.utilisateur_Password = utilisateur_Password;
        this.utilisateur_Email = utilisateur_Email;
        this.utilisateur_Civilite_Type = utilisateur_Civilite_Type;
        this.utilisateur_Prenom = utilisateur_Prenom;
        this.utilisateur_Nom = utilisateur_Nom;
        this.utilisateur_Adresse_1 = utilisateur_Adresse_1;
        this.utilisateur_Adresse_2 = utilisateur_Adresse_2;
        this.utilisateur_Ville = utilisateur_Ville;
        this.utilisateur_Code_postal = utilisateur_Code_postal;
        this.utilisateur_Date_naissance = utilisateur_Date_naissance;
        this.utilisateur_Accepte_mail_publicitaire = utilisateur_Accepte_mail_publicitaire;
        this.utilisateur_Administrateur = utilisateur_Administrateur;
        this.utilisateur_Fournisseur = utilisateur_Fournisseur;
    }

    public int get_code_utilisateur() { return this.code_utilisateur; }
    public String get_utilisateur_Identifiant() { return this.utilisateur_Identifiant; }
    public String get_utilisateur_Password() { return this.utilisateur_Password; }
    public String get_utilisateur_Email() { return this.utilisateur_Email; }
    public int get_utilisateur_Civilite_Type() { return this.utilisateur_Civilite_Type; }
    public String get_utilisateur_Prenom() { return this.utilisateur_Prenom; }
    public String get_utilisateur_Nom() { return this.utilisateur_Nom; }
    public String get_utilisateur_Adresse_1() { return this.utilisateur_Adresse_1; }
    public String get_utilisateur_Adresse_2() { return this.utilisateur_Adresse_2; }
    public String get_utilisateur_Ville() { return this.utilisateur_Ville; }
    public String get_utilisateur_Code_postal() { return this.utilisateur_Code_postal; }
    public String get_utilisateur_Date_naissance() { return this.utilisateur_Date_naissance; }
    public boolean get_utilisateur_Accepte_mail_publicitaire() { return this.utilisateur_Accepte_mail_publicitaire; }
    public boolean get_utilisateur_Administrateur() { return this.utilisateur_Administrateur; }
    public boolean get_utilisateur_Fournisseur() { return this.utilisateur_Fournisseur; }

    public void set_utilisateur_Identifiant( String utilisateur_Identifiant ) { this.utilisateur_Identifiant = utilisateur_Identifiant; }
    public void set_utilisateur_Password( String utilisateur_Password ) { this.utilisateur_Password = utilisateur_Password; }
    public void set_utilisateur_Email( String utilisateur_Email ) { this.utilisateur_Email = utilisateur_Email; }
    public void set_utilisateur_Civilite_Type( int utilisateur_Civilite_Type ) { this.utilisateur_Civilite_Type = utilisateur_Civilite_Type; }
    public void set_utilisateur_Prenom( String utilisateur_Prenom ) { this.utilisateur_Prenom = utilisateur_Prenom; }
    public void set_utilisateur_Nom( String utilisateur_Nom ) { this.utilisateur_Nom = utilisateur_Nom; }
    public void set_utilisateur_Adresse_1( String utilisateur_Adresse_1 ) { this.utilisateur_Adresse_1 = utilisateur_Adresse_1; }
    public void set_utilisateur_Adresse_2( String utilisateur_Adresse_2 ) { this.utilisateur_Adresse_2 = utilisateur_Adresse_2; }
    public void set_utilisateur_Ville( String utilisateur_Ville ) { this.utilisateur_Ville = utilisateur_Ville; }
    public void set_utilisateur_Code_postal( String utilisateur_Code_postal ) { this.utilisateur_Code_postal = utilisateur_Code_postal; }
    public void set_utilisateur_Date_naissance( String utilisateur_Date_naissance ) { this.utilisateur_Date_naissance = utilisateur_Date_naissance; }
    public void set_utilisateur_Accepte_mail_publicitaire( boolean utilisateur_Accepte_mail_publicitaire ) { this.utilisateur_Accepte_mail_publicitaire = utilisateur_Accepte_mail_publicitaire; }
    public void set_utilisateur_Administrateur( boolean utilisateur_Administrateur ) { this.utilisateur_Administrateur = utilisateur_Administrateur; }
    public void set_utilisateur_Fournisseur( boolean utilisateur_Fournisseur ) { this.utilisateur_Fournisseur = utilisateur_Fournisseur; }

}
