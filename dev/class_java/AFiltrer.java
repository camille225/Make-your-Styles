
public class AFiltrer {

    // dependences
    private int code_utilisateur;
    private int code_vue_utilisateur;

    // informations

    public AFiltrer() { }

    public AFiltrer(  int code_utilisateur,  int code_vue_utilisateur ) {
        this.code_utilisateur = code_utilisateur;
        this.code_vue_utilisateur = code_vue_utilisateur;
    }

    public int get_code_utilisateur() { return this.code_utilisateur; }
    public int get_code_vue_utilisateur() { return this.code_vue_utilisateur; }


}
