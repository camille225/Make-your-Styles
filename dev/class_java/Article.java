
public class Article {

    // key
    private int code_article;

    // dependences
    private int code_sous_categorie_article;

    // informations
    private String article_Libelle;
    private String article_Description;
    private int article_Saison_Type;
    private String article_Nom_fournisseur;
    private String article_Url;
    private String article_Reference;
    private String article_Couleur;
    private String article_Code_couleur_svg;
    private int article_Taille_Pays_Type;
    private int article_Taille;
    private String article_Matiere;
    private String article_Photo_Fichier;
    private float article_Prix;
    private boolean article_Actif;

    public Article() { }

    public Article( int code_article,  int code_sous_categorie_article,  String article_Libelle,  String article_Description,  int article_Saison_Type,  String article_Nom_fournisseur,  String article_Url,  String article_Reference,  String article_Couleur,  String article_Code_couleur_svg,  int article_Taille_Pays_Type,  int article_Taille,  String article_Matiere,  String article_Photo_Fichier,  float article_Prix,  boolean article_Actif ) {
        this.code_article = code_article;
        this.code_sous_categorie_article = code_sous_categorie_article;
        this.article_Libelle = article_Libelle;
        this.article_Description = article_Description;
        this.article_Saison_Type = article_Saison_Type;
        this.article_Nom_fournisseur = article_Nom_fournisseur;
        this.article_Url = article_Url;
        this.article_Reference = article_Reference;
        this.article_Couleur = article_Couleur;
        this.article_Code_couleur_svg = article_Code_couleur_svg;
        this.article_Taille_Pays_Type = article_Taille_Pays_Type;
        this.article_Taille = article_Taille;
        this.article_Matiere = article_Matiere;
        this.article_Photo_Fichier = article_Photo_Fichier;
        this.article_Prix = article_Prix;
        this.article_Actif = article_Actif;
    }

    public int get_code_article() { return this.code_article; }
    public int get_code_sous_categorie_article() { return this.code_sous_categorie_article; }
    public String get_article_Libelle() { return this.article_Libelle; }
    public String get_article_Description() { return this.article_Description; }
    public int get_article_Saison_Type() { return this.article_Saison_Type; }
    public String get_article_Nom_fournisseur() { return this.article_Nom_fournisseur; }
    public String get_article_Url() { return this.article_Url; }
    public String get_article_Reference() { return this.article_Reference; }
    public String get_article_Couleur() { return this.article_Couleur; }
    public String get_article_Code_couleur_svg() { return this.article_Code_couleur_svg; }
    public int get_article_Taille_Pays_Type() { return this.article_Taille_Pays_Type; }
    public int get_article_Taille() { return this.article_Taille; }
    public String get_article_Matiere() { return this.article_Matiere; }
    public String get_article_Photo_Fichier() { return this.article_Photo_Fichier; }
    public float get_article_Prix() { return this.article_Prix; }
    public boolean get_article_Actif() { return this.article_Actif; }

    public void set_code_sous_categorie_article( int code_sous_categorie_article ) { this.code_sous_categorie_article = code_sous_categorie_article; }
    public void set_article_Libelle( String article_Libelle ) { this.article_Libelle = article_Libelle; }
    public void set_article_Description( String article_Description ) { this.article_Description = article_Description; }
    public void set_article_Saison_Type( int article_Saison_Type ) { this.article_Saison_Type = article_Saison_Type; }
    public void set_article_Nom_fournisseur( String article_Nom_fournisseur ) { this.article_Nom_fournisseur = article_Nom_fournisseur; }
    public void set_article_Url( String article_Url ) { this.article_Url = article_Url; }
    public void set_article_Reference( String article_Reference ) { this.article_Reference = article_Reference; }
    public void set_article_Couleur( String article_Couleur ) { this.article_Couleur = article_Couleur; }
    public void set_article_Code_couleur_svg( String article_Code_couleur_svg ) { this.article_Code_couleur_svg = article_Code_couleur_svg; }
    public void set_article_Taille_Pays_Type( int article_Taille_Pays_Type ) { this.article_Taille_Pays_Type = article_Taille_Pays_Type; }
    public void set_article_Taille( int article_Taille ) { this.article_Taille = article_Taille; }
    public void set_article_Matiere( String article_Matiere ) { this.article_Matiere = article_Matiere; }
    public void set_article_Photo_Fichier( String article_Photo_Fichier ) { this.article_Photo_Fichier = article_Photo_Fichier; }
    public void set_article_Prix( float article_Prix ) { this.article_Prix = article_Prix; }
    public void set_article_Actif( boolean article_Actif ) { this.article_Actif = article_Actif; }

}
