
public class AParametreUtilisateur {

    // dependences
    private int code_utilisateur;
    private int code_parametre;

    // informations
    private int a_parametre_utilisateur_Valeur;
    private int a_parametre_utilisateur_Actif;

    public AParametreUtilisateur() { }

    public AParametreUtilisateur(  int code_utilisateur,  int code_parametre,  int a_parametre_utilisateur_Valeur,  int a_parametre_utilisateur_Actif ) {
        this.code_utilisateur = code_utilisateur;
        this.code_parametre = code_parametre;
        this.a_parametre_utilisateur_Valeur = a_parametre_utilisateur_Valeur;
        this.a_parametre_utilisateur_Actif = a_parametre_utilisateur_Actif;
    }

    public int get_code_utilisateur() { return this.code_utilisateur; }
    public int get_code_parametre() { return this.code_parametre; }
    public int get_a_parametre_utilisateur_Valeur() { return this.a_parametre_utilisateur_Valeur; }
    public int get_a_parametre_utilisateur_Actif() { return this.a_parametre_utilisateur_Actif; }

    public void set_a_parametre_utilisateur_Valeur( int a_parametre_utilisateur_Valeur ) { this.a_parametre_utilisateur_Valeur = a_parametre_utilisateur_Valeur; }
    public void set_a_parametre_utilisateur_Actif( int a_parametre_utilisateur_Actif ) { this.a_parametre_utilisateur_Actif = a_parametre_utilisateur_Actif; }

}
