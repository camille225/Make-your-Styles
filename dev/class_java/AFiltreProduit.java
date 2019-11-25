
public class AFiltreProduit {

    // dependences
    private int code_filtre;
    private int code_article;

    // informations
    private int a_filtre_produit_Actif;

    public AFiltreProduit() { }

    public AFiltreProduit(  int code_filtre,  int code_article,  int a_filtre_produit_Actif ) {
        this.code_filtre = code_filtre;
        this.code_article = code_article;
        this.a_filtre_produit_Actif = a_filtre_produit_Actif;
    }

    public int get_code_filtre() { return this.code_filtre; }
    public int get_code_article() { return this.code_article; }
    public int get_a_filtre_produit_Actif() { return this.a_filtre_produit_Actif; }

    public void set_a_filtre_produit_Actif( int a_filtre_produit_Actif ) { this.a_filtre_produit_Actif = a_filtre_produit_Actif; }

}
