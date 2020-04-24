
public class Conseil {

    // key
    private int code_conseil;

    // dependences

    // informations
    private String conseil_Libelle;
    private String conseil_Description;
    private boolean conseil_Actif;

    public Conseil() { }

    public Conseil( int code_conseil,  String conseil_Libelle,  String conseil_Description,  boolean conseil_Actif ) {
        this.code_conseil = code_conseil;
        this.conseil_Libelle = conseil_Libelle;
        this.conseil_Description = conseil_Description;
        this.conseil_Actif = conseil_Actif;
    }

    public int get_code_conseil() { return this.code_conseil; }
    public String get_conseil_Libelle() { return this.conseil_Libelle; }
    public String get_conseil_Description() { return this.conseil_Description; }
    public boolean get_conseil_Actif() { return this.conseil_Actif; }

    public void set_conseil_Libelle( String conseil_Libelle ) { this.conseil_Libelle = conseil_Libelle; }
    public void set_conseil_Description( String conseil_Description ) { this.conseil_Description = conseil_Description; }
    public void set_conseil_Actif( boolean conseil_Actif ) { this.conseil_Actif = conseil_Actif; }

}
