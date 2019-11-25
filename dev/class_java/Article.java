
public class Article {

    // key
    private int code_article;

    // dependences
    private int code_type_produit;

    // informations
    private String article_Libelle;
    private String article_Photo_Fichier;
    private float article_Prix;
    private boolean article_Actif;

    public Article() { }

    public Article( int code_article,  int code_type_produit,  String article_Libelle,  String article_Photo_Fichier,  float article_Prix,  boolean article_Actif ) {
        this.code_article = code_article;
        this.code_type_produit = code_type_produit;
        this.article_Libelle = article_Libelle;
        this.article_Photo_Fichier = article_Photo_Fichier;
        this.article_Prix = article_Prix;
        this.article_Actif = article_Actif;
    }

    public int get_code_article() { return this.code_article; }
    public int get_code_type_produit() { return this.code_type_produit; }
    public String get_article_Libelle() { return this.article_Libelle; }
    public String get_article_Photo_Fichier() { return this.article_Photo_Fichier; }
    public float get_article_Prix() { return this.article_Prix; }
    public boolean get_article_Actif() { return this.article_Actif; }

    public void set_code_type_produit( int code_type_produit ) { this.code_type_produit = code_type_produit; }
    public void set_article_Libelle( String article_Libelle ) { this.article_Libelle = article_Libelle; }
    public void set_article_Photo_Fichier( String article_Photo_Fichier ) { this.article_Photo_Fichier = article_Photo_Fichier; }
    public void set_article_Prix( float article_Prix ) { this.article_Prix = article_Prix; }
    public void set_article_Actif( boolean article_Actif ) { this.article_Actif = article_Actif; }

}
