
public class Filtre {

    // key
    private int code_filtre;

    // dependences

    // informations
    private String filtre_Libelle;

    public Filtre() { }

    public Filtre( int code_filtre,  String filtre_Libelle ) {
        this.code_filtre = code_filtre;
        this.filtre_Libelle = filtre_Libelle;
    }

    public int get_code_filtre() { return this.code_filtre; }
    public String get_filtre_Libelle() { return this.filtre_Libelle; }

    public void set_filtre_Libelle( String filtre_Libelle ) { this.filtre_Libelle = filtre_Libelle; }

}
