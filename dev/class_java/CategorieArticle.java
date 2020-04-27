
public class CategorieArticle {

    // key
    private int code_categorie_article;

    // dependences

    // informations
    private String categorie_article_Libelle;

    public CategorieArticle() { }

    public CategorieArticle( int code_categorie_article,  String categorie_article_Libelle ) {
        this.code_categorie_article = code_categorie_article;
        this.categorie_article_Libelle = categorie_article_Libelle;
    }

    public int get_code_categorie_article() { return this.code_categorie_article; }
    public String get_categorie_article_Libelle() { return this.categorie_article_Libelle; }

    public void set_categorie_article_Libelle( String categorie_article_Libelle ) { this.categorie_article_Libelle = categorie_article_Libelle; }

}
