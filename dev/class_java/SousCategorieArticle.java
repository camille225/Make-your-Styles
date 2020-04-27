
public class SousCategorieArticle {

    // key
    private int code_sous_categorie_article;

    // dependences
    private int code_categorie_article;

    // informations
    private String sous_categorie_article_Libelle;

    public SousCategorieArticle() { }

    public SousCategorieArticle( int code_sous_categorie_article,  int code_categorie_article,  String sous_categorie_article_Libelle ) {
        this.code_sous_categorie_article = code_sous_categorie_article;
        this.code_categorie_article = code_categorie_article;
        this.sous_categorie_article_Libelle = sous_categorie_article_Libelle;
    }

    public int get_code_sous_categorie_article() { return this.code_sous_categorie_article; }
    public int get_code_categorie_article() { return this.code_categorie_article; }
    public String get_sous_categorie_article_Libelle() { return this.sous_categorie_article_Libelle; }

    public void set_code_categorie_article( int code_categorie_article ) { this.code_categorie_article = code_categorie_article; }
    public void set_sous_categorie_article_Libelle( String sous_categorie_article_Libelle ) { this.sous_categorie_article_Libelle = sous_categorie_article_Libelle; }

}
