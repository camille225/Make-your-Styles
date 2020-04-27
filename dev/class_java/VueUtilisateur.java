
public class VueUtilisateur {

    // key
    private int code_vue_utilisateur;

    // dependences

    // informations
    private String vue_utilisateur_Recherche;
    private int vue_utilisateur_Filtre_Saison_Type;
    private String vue_utilisateur_Filtre_Couleur;
    private int vue_utilisateur_Filtre_Taille_Pays_Type;
    private int vue_utilisateur_Filtre_Taille_Max;
    private int vue_utilisateur_Filtre_Taille_Min;

    public VueUtilisateur() { }

    public VueUtilisateur( int code_vue_utilisateur,  String vue_utilisateur_Recherche,  int vue_utilisateur_Filtre_Saison_Type,  String vue_utilisateur_Filtre_Couleur,  int vue_utilisateur_Filtre_Taille_Pays_Type,  int vue_utilisateur_Filtre_Taille_Max,  int vue_utilisateur_Filtre_Taille_Min ) {
        this.code_vue_utilisateur = code_vue_utilisateur;
        this.vue_utilisateur_Recherche = vue_utilisateur_Recherche;
        this.vue_utilisateur_Filtre_Saison_Type = vue_utilisateur_Filtre_Saison_Type;
        this.vue_utilisateur_Filtre_Couleur = vue_utilisateur_Filtre_Couleur;
        this.vue_utilisateur_Filtre_Taille_Pays_Type = vue_utilisateur_Filtre_Taille_Pays_Type;
        this.vue_utilisateur_Filtre_Taille_Max = vue_utilisateur_Filtre_Taille_Max;
        this.vue_utilisateur_Filtre_Taille_Min = vue_utilisateur_Filtre_Taille_Min;
    }

    public int get_code_vue_utilisateur() { return this.code_vue_utilisateur; }
    public String get_vue_utilisateur_Recherche() { return this.vue_utilisateur_Recherche; }
    public int get_vue_utilisateur_Filtre_Saison_Type() { return this.vue_utilisateur_Filtre_Saison_Type; }
    public String get_vue_utilisateur_Filtre_Couleur() { return this.vue_utilisateur_Filtre_Couleur; }
    public int get_vue_utilisateur_Filtre_Taille_Pays_Type() { return this.vue_utilisateur_Filtre_Taille_Pays_Type; }
    public int get_vue_utilisateur_Filtre_Taille_Max() { return this.vue_utilisateur_Filtre_Taille_Max; }
    public int get_vue_utilisateur_Filtre_Taille_Min() { return this.vue_utilisateur_Filtre_Taille_Min; }

    public void set_vue_utilisateur_Recherche( String vue_utilisateur_Recherche ) { this.vue_utilisateur_Recherche = vue_utilisateur_Recherche; }
    public void set_vue_utilisateur_Filtre_Saison_Type( int vue_utilisateur_Filtre_Saison_Type ) { this.vue_utilisateur_Filtre_Saison_Type = vue_utilisateur_Filtre_Saison_Type; }
    public void set_vue_utilisateur_Filtre_Couleur( String vue_utilisateur_Filtre_Couleur ) { this.vue_utilisateur_Filtre_Couleur = vue_utilisateur_Filtre_Couleur; }
    public void set_vue_utilisateur_Filtre_Taille_Pays_Type( int vue_utilisateur_Filtre_Taille_Pays_Type ) { this.vue_utilisateur_Filtre_Taille_Pays_Type = vue_utilisateur_Filtre_Taille_Pays_Type; }
    public void set_vue_utilisateur_Filtre_Taille_Max( int vue_utilisateur_Filtre_Taille_Max ) { this.vue_utilisateur_Filtre_Taille_Max = vue_utilisateur_Filtre_Taille_Max; }
    public void set_vue_utilisateur_Filtre_Taille_Min( int vue_utilisateur_Filtre_Taille_Min ) { this.vue_utilisateur_Filtre_Taille_Min = vue_utilisateur_Filtre_Taille_Min; }

}
