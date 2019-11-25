
public class TypeProduit {

    // key
    private int code_type_produit;

    // dependences

    // informations
    private String type_produit_Libelle;

    public TypeProduit() { }

    public TypeProduit( int code_type_produit,  String type_produit_Libelle ) {
        this.code_type_produit = code_type_produit;
        this.type_produit_Libelle = type_produit_Libelle;
    }

    public int get_code_type_produit() { return this.code_type_produit; }
    public String get_type_produit_Libelle() { return this.type_produit_Libelle; }

    public void set_type_produit_Libelle( String type_produit_Libelle ) { this.type_produit_Libelle = type_produit_Libelle; }

}
