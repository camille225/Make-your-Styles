
public class Utilisateur {

    // key
    private int code_utilisateur;

    // dependences

    // informations
    private String utilisateur_Identifiant;
    private String utilisateur_Password;
    private String utilisateur_Email;
    private boolean utilisateur_Administrateur;
    private boolean utilisateur_Developpeur;

    public Utilisateur() { }

    public Utilisateur( int code_utilisateur,  String utilisateur_Identifiant,  String utilisateur_Password,  String utilisateur_Email,  boolean utilisateur_Administrateur,  boolean utilisateur_Developpeur ) {
        this.code_utilisateur = code_utilisateur;
        this.utilisateur_Identifiant = utilisateur_Identifiant;
        this.utilisateur_Password = utilisateur_Password;
        this.utilisateur_Email = utilisateur_Email;
        this.utilisateur_Administrateur = utilisateur_Administrateur;
        this.utilisateur_Developpeur = utilisateur_Developpeur;
    }

    public int get_code_utilisateur() { return this.code_utilisateur; }
    public String get_utilisateur_Identifiant() { return this.utilisateur_Identifiant; }
    public String get_utilisateur_Password() { return this.utilisateur_Password; }
    public String get_utilisateur_Email() { return this.utilisateur_Email; }
    public boolean get_utilisateur_Administrateur() { return this.utilisateur_Administrateur; }
    public boolean get_utilisateur_Developpeur() { return this.utilisateur_Developpeur; }

    public void set_utilisateur_Identifiant( String utilisateur_Identifiant ) { this.utilisateur_Identifiant = utilisateur_Identifiant; }
    public void set_utilisateur_Password( String utilisateur_Password ) { this.utilisateur_Password = utilisateur_Password; }
    public void set_utilisateur_Email( String utilisateur_Email ) { this.utilisateur_Email = utilisateur_Email; }
    public void set_utilisateur_Administrateur( boolean utilisateur_Administrateur ) { this.utilisateur_Administrateur = utilisateur_Administrateur; }
    public void set_utilisateur_Developpeur( boolean utilisateur_Developpeur ) { this.utilisateur_Developpeur = utilisateur_Developpeur; }

}
