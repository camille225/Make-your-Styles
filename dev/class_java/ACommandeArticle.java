
public class ACommandeArticle {

    // dependences
    private int code_commande;
    private int code_article;

    // informations
    private int a_commande_article_Quantite;
    private float a_commande_article_Prix_ligne;

    public ACommandeArticle() { }

    public ACommandeArticle(  int code_commande,  int code_article,  int a_commande_article_Quantite,  float a_commande_article_Prix_ligne ) {
        this.code_commande = code_commande;
        this.code_article = code_article;
        this.a_commande_article_Quantite = a_commande_article_Quantite;
        this.a_commande_article_Prix_ligne = a_commande_article_Prix_ligne;
    }

    public int get_code_commande() { return this.code_commande; }
    public int get_code_article() { return this.code_article; }
    public int get_a_commande_article_Quantite() { return this.a_commande_article_Quantite; }
    public float get_a_commande_article_Prix_ligne() { return this.a_commande_article_Prix_ligne; }

    public void set_a_commande_article_Quantite( int a_commande_article_Quantite ) { this.a_commande_article_Quantite = a_commande_article_Quantite; }
    public void set_a_commande_article_Prix_ligne( float a_commande_article_Prix_ligne ) { this.a_commande_article_Prix_ligne = a_commande_article_Prix_ligne; }

}
