
public class Commande {

    // key
    private int code_commande;

    // dependences
    private int code_utilisateur;

    // informations
    private float commande_Prix_total;
    private String commande_Date_livraison;
    private String commande_Date_creation;

    public Commande() { }

    public Commande( int code_commande,  int code_utilisateur,  float commande_Prix_total,  String commande_Date_livraison,  String commande_Date_creation ) {
        this.code_commande = code_commande;
        this.code_utilisateur = code_utilisateur;
        this.commande_Prix_total = commande_Prix_total;
        this.commande_Date_livraison = commande_Date_livraison;
        this.commande_Date_creation = commande_Date_creation;
    }

    public int get_code_commande() { return this.code_commande; }
    public int get_code_utilisateur() { return this.code_utilisateur; }
    public float get_commande_Prix_total() { return this.commande_Prix_total; }
    public String get_commande_Date_livraison() { return this.commande_Date_livraison; }
    public String get_commande_Date_creation() { return this.commande_Date_creation; }

    public void set_code_utilisateur( int code_utilisateur ) { this.code_utilisateur = code_utilisateur; }
    public void set_commande_Prix_total( float commande_Prix_total ) { this.commande_Prix_total = commande_Prix_total; }
    public void set_commande_Date_livraison( String commande_Date_livraison ) { this.commande_Date_livraison = commande_Date_livraison; }
    public void set_commande_Date_creation( String commande_Date_creation ) { this.commande_Date_creation = commande_Date_creation; }

}
