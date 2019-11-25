
public class AArticleCommande {

    // dependences
    private int code_commande;
    private int code_article;

    // informations

    public AArticleCommande() { }

    public AArticleCommande(  int code_commande,  int code_article ) {
        this.code_commande = code_commande;
        this.code_article = code_article;
    }

    public int get_code_commande() { return this.code_commande; }
    public int get_code_article() { return this.code_article; }


}
