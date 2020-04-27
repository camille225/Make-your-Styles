<?php declare(strict_types=1);

class Api_make_your_style {

    private $url_api;
    private $mf_token = '';
    private $mf_id = '';
    private $mf_num_error = 0;
    private $mf_label_error = '';
    private $mf_connector_token = '';
    private $mf_instance = 0;

    public function __construct($url_api, $mf_connector_token='', $mf_instance=0)
    {
        $this->url_api = $url_api;
        $this->mf_connector_token = $mf_connector_token;
        $this->mf_instance = $mf_instance;
    }

    public function get($appel_api) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->url_api.$appel_api );
        curl_setopt( $ch, CURLOPT_COOKIESESSION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $r = json_decode(curl_exec($ch), true);
        $this->mf_num_error = (isset($r['error']['number']) ? $r['error']['number'] : 0);
        $this->mf_label_error = (isset($r['error']['number']) ? $r['error']['label'] : '');
        curl_close( $ch );
        return $r['data'];
    }

    public function post($appel_api, $data) {
        $ch = curl_init($this->url_api.$appel_api);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = json_decode(curl_exec($ch), true);
        $this->mf_num_error = $r['error']['number'];
        $this->mf_label_error = $r['error']['label'];
        curl_close($ch);
        return $r['data'];
    }

    public function put($appel_api, $data) {
        $ch = curl_init($this->url_api.$appel_api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = json_decode(curl_exec($ch), true);
        $this->mf_num_error = $r['error']['number'];
        $this->mf_label_error = $r['error']['label'];
        curl_close($ch);
        return $r['data'];
    }

    public function delete($appel_api) {
        $ch = curl_init($this->url_api.$appel_api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = json_decode(curl_exec($ch), true );
        curl_close($ch);
        $this->mf_num_error = $r['error']['number'];
        $this->mf_label_error = $r['error']['label'];
        return $r['data'];
    }

    public function connexion($mf_login, $mf_pwd) {
        $r = $this->post('mf_connexion', ['mf_login'=>$mf_login, 'mf_pwd'=>$mf_pwd]);
        if ( $r['error']['number']==0 ) {
            $this->mf_token = $r['data']['mf_token'];
            $this->mf_id = $r['data']['id'];
            return $this->mf_id;
        }
        else
        {
            $this->mf_num_error = $r['error']['number'];
        }
        return false;
    }

    public function get_id_connexion() {
        return $this->mf_id;
    }

    public function get_num_error() {
        return $this->mf_num_error;
    }

    public function get_label_error() {
        return $this->mf_label_error;
    }

    // +-------------+
    // | utilisateur |
    // +-------------+

    public function utilisateur__get($Code_utilisateur) {
        return $this->get('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function utilisateur__get_all() {
        $requete = '';
        return $this->get($requete . 'utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function utilisateur__add($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur) {
        $data = [
            'utilisateur_Identifiant' => $utilisateur_Identifiant,
            'utilisateur_Password' => $utilisateur_Password,
            'utilisateur_Email' => $utilisateur_Email,
            'utilisateur_Civilite_Type' => $utilisateur_Civilite_Type,
            'utilisateur_Prenom' => $utilisateur_Prenom,
            'utilisateur_Nom' => $utilisateur_Nom,
            'utilisateur_Adresse_1' => $utilisateur_Adresse_1,
            'utilisateur_Adresse_2' => $utilisateur_Adresse_2,
            'utilisateur_Ville' => $utilisateur_Ville,
            'utilisateur_Code_postal' => $utilisateur_Code_postal,
            'utilisateur_Date_naissance' => $utilisateur_Date_naissance,
            'utilisateur_Accepte_mail_publicitaire' => $utilisateur_Accepte_mail_publicitaire,
            'utilisateur_Administrateur' => $utilisateur_Administrateur,
            'utilisateur_Fournisseur' => $utilisateur_Fournisseur,
        ];
        return $this->post('utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit($Code_utilisateur, $utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur) {
        $data = [
            'utilisateur_Identifiant' => $utilisateur_Identifiant,
            'utilisateur_Password' => $utilisateur_Password,
            'utilisateur_Email' => $utilisateur_Email,
            'utilisateur_Civilite_Type' => $utilisateur_Civilite_Type,
            'utilisateur_Prenom' => $utilisateur_Prenom,
            'utilisateur_Nom' => $utilisateur_Nom,
            'utilisateur_Adresse_1' => $utilisateur_Adresse_1,
            'utilisateur_Adresse_2' => $utilisateur_Adresse_2,
            'utilisateur_Ville' => $utilisateur_Ville,
            'utilisateur_Code_postal' => $utilisateur_Code_postal,
            'utilisateur_Date_naissance' => $utilisateur_Date_naissance,
            'utilisateur_Accepte_mail_publicitaire' => $utilisateur_Accepte_mail_publicitaire,
            'utilisateur_Administrateur' => $utilisateur_Administrateur,
            'utilisateur_Fournisseur' => $utilisateur_Fournisseur,
        ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Identifiant($Code_utilisateur, $utilisateur_Identifiant) {
        $data = ['utilisateur_Identifiant' => $utilisateur_Identifiant ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Password($Code_utilisateur, $utilisateur_Password) {
        $data = ['utilisateur_Password' => $utilisateur_Password ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Email($Code_utilisateur, $utilisateur_Email) {
        $data = ['utilisateur_Email' => $utilisateur_Email ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Civilite_Type($Code_utilisateur, $utilisateur_Civilite_Type) {
        $data = ['utilisateur_Civilite_Type' => $utilisateur_Civilite_Type ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Prenom($Code_utilisateur, $utilisateur_Prenom) {
        $data = ['utilisateur_Prenom' => $utilisateur_Prenom ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Nom($Code_utilisateur, $utilisateur_Nom) {
        $data = ['utilisateur_Nom' => $utilisateur_Nom ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Adresse_1($Code_utilisateur, $utilisateur_Adresse_1) {
        $data = ['utilisateur_Adresse_1' => $utilisateur_Adresse_1 ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Adresse_2($Code_utilisateur, $utilisateur_Adresse_2) {
        $data = ['utilisateur_Adresse_2' => $utilisateur_Adresse_2 ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Ville($Code_utilisateur, $utilisateur_Ville) {
        $data = ['utilisateur_Ville' => $utilisateur_Ville ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Code_postal($Code_utilisateur, $utilisateur_Code_postal) {
        $data = ['utilisateur_Code_postal' => $utilisateur_Code_postal ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Date_naissance($Code_utilisateur, $utilisateur_Date_naissance) {
        $data = ['utilisateur_Date_naissance' => $utilisateur_Date_naissance ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Accepte_mail_publicitaire($Code_utilisateur, $utilisateur_Accepte_mail_publicitaire) {
        $data = ['utilisateur_Accepte_mail_publicitaire' => $utilisateur_Accepte_mail_publicitaire ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Administrateur($Code_utilisateur, $utilisateur_Administrateur) {
        $data = ['utilisateur_Administrateur' => $utilisateur_Administrateur ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Fournisseur($Code_utilisateur, $utilisateur_Fournisseur) {
        $data = ['utilisateur_Fournisseur' => $utilisateur_Fournisseur ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__delete($Code_utilisateur) {
        return $this->delete('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +---------+
    // | article |
    // +---------+

    public function article__get($Code_article) {
        return $this->get('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function article__get_all(?int $Code_sous_categorie_article = null) {
        $requete = '';
        $Code_sous_categorie_article = (int) $Code_sous_categorie_article;
        if ($Code_sous_categorie_article != 0) { $requete .= 'sous_categorie_article/' . $Code_sous_categorie_article . '/'; }
        return $this->get($requete . 'article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function article__add($Code_sous_categorie_article, $article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif) {
        $data = [
            'article_Libelle' => $article_Libelle,
            'article_Description' => $article_Description,
            'article_Saison_Type' => $article_Saison_Type,
            'article_Nom_fournisseur' => $article_Nom_fournisseur,
            'article_Url' => $article_Url,
            'article_Reference' => $article_Reference,
            'article_Couleur' => $article_Couleur,
            'article_Code_couleur_svg' => $article_Code_couleur_svg,
            'article_Taille_Pays_Type' => $article_Taille_Pays_Type,
            'article_Taille' => $article_Taille,
            'article_Matiere' => $article_Matiere,
            'article_Photo_Fichier' => $article_Photo_Fichier,
            'article_Prix' => $article_Prix,
            'article_Actif' => $article_Actif,
            'Code_sous_categorie_article' => $Code_sous_categorie_article,
        ];
        return $this->post('article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit($Code_article, $Code_sous_categorie_article, $article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif) {
        $data = [
            'article_Libelle' => $article_Libelle,
            'article_Description' => $article_Description,
            'article_Saison_Type' => $article_Saison_Type,
            'article_Nom_fournisseur' => $article_Nom_fournisseur,
            'article_Url' => $article_Url,
            'article_Reference' => $article_Reference,
            'article_Couleur' => $article_Couleur,
            'article_Code_couleur_svg' => $article_Code_couleur_svg,
            'article_Taille_Pays_Type' => $article_Taille_Pays_Type,
            'article_Taille' => $article_Taille,
            'article_Matiere' => $article_Matiere,
            'article_Photo_Fichier' => $article_Photo_Fichier,
            'article_Prix' => $article_Prix,
            'article_Actif' => $article_Actif,
            'Code_sous_categorie_article' => $Code_sous_categorie_article,
        ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Libelle($Code_article, $article_Libelle) {
        $data = ['article_Libelle' => $article_Libelle ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Description($Code_article, $article_Description) {
        $data = ['article_Description' => $article_Description ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Saison_Type($Code_article, $article_Saison_Type) {
        $data = ['article_Saison_Type' => $article_Saison_Type ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Nom_fournisseur($Code_article, $article_Nom_fournisseur) {
        $data = ['article_Nom_fournisseur' => $article_Nom_fournisseur ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Url($Code_article, $article_Url) {
        $data = ['article_Url' => $article_Url ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Reference($Code_article, $article_Reference) {
        $data = ['article_Reference' => $article_Reference ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Couleur($Code_article, $article_Couleur) {
        $data = ['article_Couleur' => $article_Couleur ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Code_couleur_svg($Code_article, $article_Code_couleur_svg) {
        $data = ['article_Code_couleur_svg' => $article_Code_couleur_svg ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Taille_Pays_Type($Code_article, $article_Taille_Pays_Type) {
        $data = ['article_Taille_Pays_Type' => $article_Taille_Pays_Type ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Taille($Code_article, $article_Taille) {
        $data = ['article_Taille' => $article_Taille ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Matiere($Code_article, $article_Matiere) {
        $data = ['article_Matiere' => $article_Matiere ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Photo_Fichier($Code_article, $article_Photo_Fichier) {
        $data = ['article_Photo_Fichier' => $article_Photo_Fichier ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Prix($Code_article, $article_Prix) {
        $data = ['article_Prix' => $article_Prix ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Actif($Code_article, $article_Actif) {
        $data = ['article_Actif' => $article_Actif ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__sous_categorie_article($Code_article, $sous_categorie_article) {
        $data = ['sous_categorie_article' => $sous_categorie_article ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__delete($Code_article) {
        return $this->delete('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +----------+
    // | commande |
    // +----------+

    public function commande__get($Code_commande) {
        return $this->get('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function commande__get_all(?int $Code_utilisateur = null) {
        $requete = '';
        $Code_utilisateur = (int) $Code_utilisateur;
        if ($Code_utilisateur != 0) { $requete .= 'utilisateur/' . $Code_utilisateur . '/'; }
        return $this->get($requete . 'commande?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function commande__add($Code_utilisateur, $commande_Prix_total, $commande_Date_livraison, $commande_Date_creation) {
        $data = [
            'commande_Prix_total' => $commande_Prix_total,
            'commande_Date_livraison' => $commande_Date_livraison,
            'commande_Date_creation' => $commande_Date_creation,
            'Code_utilisateur' => $Code_utilisateur,
        ];
        return $this->post('commande?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function commande__edit($Code_commande, $Code_utilisateur, $commande_Prix_total, $commande_Date_livraison, $commande_Date_creation) {
        $data = [
            'commande_Prix_total' => $commande_Prix_total,
            'commande_Date_livraison' => $commande_Date_livraison,
            'commande_Date_creation' => $commande_Date_creation,
            'Code_utilisateur' => $Code_utilisateur,
        ];
        return $this->put('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function commande__edit__commande_Prix_total($Code_commande, $commande_Prix_total) {
        $data = ['commande_Prix_total' => $commande_Prix_total ];
        return $this->put('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function commande__edit__commande_Date_livraison($Code_commande, $commande_Date_livraison) {
        $data = ['commande_Date_livraison' => $commande_Date_livraison ];
        return $this->put('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function commande__edit__commande_Date_creation($Code_commande, $commande_Date_creation) {
        $data = ['commande_Date_creation' => $commande_Date_creation ];
        return $this->put('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function commande__edit__utilisateur($Code_commande, $utilisateur) {
        $data = ['utilisateur' => $utilisateur ];
        return $this->put('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function commande__delete($Code_commande) {
        return $this->delete('commande/'.$Code_commande.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-------------------+
    // | categorie_article |
    // +-------------------+

    public function categorie_article__get($Code_categorie_article) {
        return $this->get('categorie_article/'.$Code_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function categorie_article__get_all() {
        $requete = '';
        return $this->get($requete . 'categorie_article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function categorie_article__add($categorie_article_Libelle) {
        $data = [
            'categorie_article_Libelle' => $categorie_article_Libelle,
        ];
        return $this->post('categorie_article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function categorie_article__edit($Code_categorie_article, $categorie_article_Libelle) {
        $data = [
            'categorie_article_Libelle' => $categorie_article_Libelle,
        ];
        return $this->put('categorie_article/'.$Code_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function categorie_article__edit__categorie_article_Libelle($Code_categorie_article, $categorie_article_Libelle) {
        $data = ['categorie_article_Libelle' => $categorie_article_Libelle ];
        return $this->put('categorie_article/'.$Code_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function categorie_article__delete($Code_categorie_article) {
        return $this->delete('categorie_article/'.$Code_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-----------+
    // | parametre |
    // +-----------+

    public function parametre__get($Code_parametre) {
        return $this->get('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function parametre__get_all() {
        $requete = '';
        return $this->get($requete . 'parametre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function parametre__add($parametre_Libelle) {
        $data = [
            'parametre_Libelle' => $parametre_Libelle,
        ];
        return $this->post('parametre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit($Code_parametre, $parametre_Libelle) {
        $data = [
            'parametre_Libelle' => $parametre_Libelle,
        ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__edit__parametre_Libelle($Code_parametre, $parametre_Libelle) {
        $data = ['parametre_Libelle' => $parametre_Libelle ];
        return $this->put('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function parametre__delete($Code_parametre) {
        return $this->delete('parametre/'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-----------------+
    // | vue_utilisateur |
    // +-----------------+

    public function vue_utilisateur__get($Code_vue_utilisateur) {
        return $this->get('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function vue_utilisateur__get_all() {
        $requete = '';
        return $this->get($requete . 'vue_utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function vue_utilisateur__add($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min) {
        $data = [
            'vue_utilisateur_Recherche' => $vue_utilisateur_Recherche,
            'vue_utilisateur_Filtre_Saison_Type' => $vue_utilisateur_Filtre_Saison_Type,
            'vue_utilisateur_Filtre_Couleur' => $vue_utilisateur_Filtre_Couleur,
            'vue_utilisateur_Filtre_Taille_Pays_Type' => $vue_utilisateur_Filtre_Taille_Pays_Type,
            'vue_utilisateur_Filtre_Taille_Max' => $vue_utilisateur_Filtre_Taille_Max,
            'vue_utilisateur_Filtre_Taille_Min' => $vue_utilisateur_Filtre_Taille_Min,
        ];
        return $this->post('vue_utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit($Code_vue_utilisateur, $vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min) {
        $data = [
            'vue_utilisateur_Recherche' => $vue_utilisateur_Recherche,
            'vue_utilisateur_Filtre_Saison_Type' => $vue_utilisateur_Filtre_Saison_Type,
            'vue_utilisateur_Filtre_Couleur' => $vue_utilisateur_Filtre_Couleur,
            'vue_utilisateur_Filtre_Taille_Pays_Type' => $vue_utilisateur_Filtre_Taille_Pays_Type,
            'vue_utilisateur_Filtre_Taille_Max' => $vue_utilisateur_Filtre_Taille_Max,
            'vue_utilisateur_Filtre_Taille_Min' => $vue_utilisateur_Filtre_Taille_Min,
        ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit__vue_utilisateur_Recherche($Code_vue_utilisateur, $vue_utilisateur_Recherche) {
        $data = ['vue_utilisateur_Recherche' => $vue_utilisateur_Recherche ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit__vue_utilisateur_Filtre_Saison_Type($Code_vue_utilisateur, $vue_utilisateur_Filtre_Saison_Type) {
        $data = ['vue_utilisateur_Filtre_Saison_Type' => $vue_utilisateur_Filtre_Saison_Type ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit__vue_utilisateur_Filtre_Couleur($Code_vue_utilisateur, $vue_utilisateur_Filtre_Couleur) {
        $data = ['vue_utilisateur_Filtre_Couleur' => $vue_utilisateur_Filtre_Couleur ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit__vue_utilisateur_Filtre_Taille_Pays_Type($Code_vue_utilisateur, $vue_utilisateur_Filtre_Taille_Pays_Type) {
        $data = ['vue_utilisateur_Filtre_Taille_Pays_Type' => $vue_utilisateur_Filtre_Taille_Pays_Type ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit__vue_utilisateur_Filtre_Taille_Max($Code_vue_utilisateur, $vue_utilisateur_Filtre_Taille_Max) {
        $data = ['vue_utilisateur_Filtre_Taille_Max' => $vue_utilisateur_Filtre_Taille_Max ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__edit__vue_utilisateur_Filtre_Taille_Min($Code_vue_utilisateur, $vue_utilisateur_Filtre_Taille_Min) {
        $data = ['vue_utilisateur_Filtre_Taille_Min' => $vue_utilisateur_Filtre_Taille_Min ];
        return $this->put('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function vue_utilisateur__delete($Code_vue_utilisateur) {
        return $this->delete('vue_utilisateur/'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------------------------+
    // | sous_categorie_article |
    // +------------------------+

    public function sous_categorie_article__get($Code_sous_categorie_article) {
        return $this->get('sous_categorie_article/'.$Code_sous_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function sous_categorie_article__get_all(?int $Code_categorie_article = null) {
        $requete = '';
        $Code_categorie_article = (int) $Code_categorie_article;
        if ($Code_categorie_article != 0) { $requete .= 'categorie_article/' . $Code_categorie_article . '/'; }
        return $this->get($requete . 'sous_categorie_article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function sous_categorie_article__add($Code_categorie_article, $sous_categorie_article_Libelle) {
        $data = [
            'sous_categorie_article_Libelle' => $sous_categorie_article_Libelle,
            'Code_categorie_article' => $Code_categorie_article,
        ];
        return $this->post('sous_categorie_article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function sous_categorie_article__edit($Code_sous_categorie_article, $Code_categorie_article, $sous_categorie_article_Libelle) {
        $data = [
            'sous_categorie_article_Libelle' => $sous_categorie_article_Libelle,
            'Code_categorie_article' => $Code_categorie_article,
        ];
        return $this->put('sous_categorie_article/'.$Code_sous_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function sous_categorie_article__edit__sous_categorie_article_Libelle($Code_sous_categorie_article, $sous_categorie_article_Libelle) {
        $data = ['sous_categorie_article_Libelle' => $sous_categorie_article_Libelle ];
        return $this->put('sous_categorie_article/'.$Code_sous_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function sous_categorie_article__edit__categorie_article($Code_sous_categorie_article, $categorie_article) {
        $data = ['categorie_article' => $categorie_article ];
        return $this->put('sous_categorie_article/'.$Code_sous_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function sous_categorie_article__delete($Code_sous_categorie_article) {
        return $this->delete('sous_categorie_article/'.$Code_sous_categorie_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +---------+
    // | conseil |
    // +---------+

    public function conseil__get($Code_conseil) {
        return $this->get('conseil/'.$Code_conseil.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function conseil__get_all() {
        $requete = '';
        return $this->get($requete . 'conseil?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function conseil__add($conseil_Libelle, $conseil_Description, $conseil_Actif) {
        $data = [
            'conseil_Libelle' => $conseil_Libelle,
            'conseil_Description' => $conseil_Description,
            'conseil_Actif' => $conseil_Actif,
        ];
        return $this->post('conseil?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function conseil__edit($Code_conseil, $conseil_Libelle, $conseil_Description, $conseil_Actif) {
        $data = [
            'conseil_Libelle' => $conseil_Libelle,
            'conseil_Description' => $conseil_Description,
            'conseil_Actif' => $conseil_Actif,
        ];
        return $this->put('conseil/'.$Code_conseil.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function conseil__edit__conseil_Libelle($Code_conseil, $conseil_Libelle) {
        $data = ['conseil_Libelle' => $conseil_Libelle ];
        return $this->put('conseil/'.$Code_conseil.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function conseil__edit__conseil_Description($Code_conseil, $conseil_Description) {
        $data = ['conseil_Description' => $conseil_Description ];
        return $this->put('conseil/'.$Code_conseil.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function conseil__edit__conseil_Actif($Code_conseil, $conseil_Actif) {
        $data = ['conseil_Actif' => $conseil_Actif ];
        return $this->put('conseil/'.$Code_conseil.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function conseil__delete($Code_conseil) {
        return $this->delete('conseil/'.$Code_conseil.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +--------------------+
    // | a_commande_article |
    // +--------------------+

    public function a_commande_article__get($Code_commande, $Code_article) {
        return $this->get('a_commande_article/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_commande_article__get_all(?int $Code_commande = null, ?int $Code_article = null) {
        $requete = '';
        $Code_commande = (int) $Code_commande;
        if ($Code_commande != 0) { $requete .= 'commande/' . $Code_commande . '/'; }
        $Code_article = (int) $Code_article;
        if ($Code_article != 0) { $requete .= 'article/' . $Code_article . '/'; }
        return $this->get($requete . 'a_commande_article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_commande_article__add($Code_commande, $Code_article, $a_commande_article_Quantite, $a_commande_article_Prix_ligne) {
        $data = [
            'a_commande_article_Quantite' => $a_commande_article_Quantite,
            'a_commande_article_Prix_ligne' => $a_commande_article_Prix_ligne,
            'Code_commande' => $Code_commande,
            'Code_article' => $Code_article,
        ];
        return $this->post('a_commande_article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_commande_article__edit($Code_commande, $Code_article, $a_commande_article_Quantite, $a_commande_article_Prix_ligne) {
        $data = [
            'a_commande_article_Quantite' => $a_commande_article_Quantite,
            'a_commande_article_Prix_ligne' => $a_commande_article_Prix_ligne,
        ];
        return $this->put('a_commande_article/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_commande_article__edit__a_commande_article_Quantite($Code_commande, $Code_article, $a_commande_article_Quantite) {
        $data = ['a_commande_article_Quantite' => $a_commande_article_Quantite ];
        return $this->put('a_commande_article/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_commande_article__edit__a_commande_article_Prix_ligne($Code_commande, $Code_article, $a_commande_article_Prix_ligne) {
        $data = ['a_commande_article_Prix_ligne' => $a_commande_article_Prix_ligne ];
        return $this->put('a_commande_article/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_commande_article__delete($Code_commande, $Code_article) {
        return $this->delete('a_commande_article/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-------------------------+
    // | a_parametre_utilisateur |
    // +-------------------------+

    public function a_parametre_utilisateur__get($Code_utilisateur, $Code_parametre) {
        return $this->get('a_parametre_utilisateur/'.$Code_utilisateur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_parametre_utilisateur__get_all(?int $Code_utilisateur = null, ?int $Code_parametre = null) {
        $requete = '';
        $Code_utilisateur = (int) $Code_utilisateur;
        if ($Code_utilisateur != 0) { $requete .= 'utilisateur/' . $Code_utilisateur . '/'; }
        $Code_parametre = (int) $Code_parametre;
        if ($Code_parametre != 0) { $requete .= 'parametre/' . $Code_parametre . '/'; }
        return $this->get($requete . 'a_parametre_utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_parametre_utilisateur__add($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif) {
        $data = [
            'a_parametre_utilisateur_Valeur' => $a_parametre_utilisateur_Valeur,
            'a_parametre_utilisateur_Actif' => $a_parametre_utilisateur_Actif,
            'Code_utilisateur' => $Code_utilisateur,
            'Code_parametre' => $Code_parametre,
        ];
        return $this->post('a_parametre_utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_parametre_utilisateur__edit($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif) {
        $data = [
            'a_parametre_utilisateur_Valeur' => $a_parametre_utilisateur_Valeur,
            'a_parametre_utilisateur_Actif' => $a_parametre_utilisateur_Actif,
        ];
        return $this->put('a_parametre_utilisateur/'.$Code_utilisateur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_parametre_utilisateur__edit__a_parametre_utilisateur_Valeur($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Valeur) {
        $data = ['a_parametre_utilisateur_Valeur' => $a_parametre_utilisateur_Valeur ];
        return $this->put('a_parametre_utilisateur/'.$Code_utilisateur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_parametre_utilisateur__edit__a_parametre_utilisateur_Actif($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Actif) {
        $data = ['a_parametre_utilisateur_Actif' => $a_parametre_utilisateur_Actif ];
        return $this->put('a_parametre_utilisateur/'.$Code_utilisateur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_parametre_utilisateur__delete($Code_utilisateur, $Code_parametre) {
        return $this->delete('a_parametre_utilisateur/'.$Code_utilisateur.'-'.$Code_parametre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +-----------+
    // | a_filtrer |
    // +-----------+

    public function a_filtrer__get($Code_utilisateur, $Code_vue_utilisateur) {
        return $this->get('a_filtrer/'.$Code_utilisateur.'-'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_filtrer__get_all(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null) {
        $requete = '';
        $Code_utilisateur = (int) $Code_utilisateur;
        if ($Code_utilisateur != 0) { $requete .= 'utilisateur/' . $Code_utilisateur . '/'; }
        $Code_vue_utilisateur = (int) $Code_vue_utilisateur;
        if ($Code_vue_utilisateur != 0) { $requete .= 'vue_utilisateur/' . $Code_vue_utilisateur . '/'; }
        return $this->get($requete . 'a_filtrer?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_filtrer__add($Code_utilisateur, $Code_vue_utilisateur) {
        $data = [
            'Code_utilisateur' => $Code_utilisateur,
            'Code_vue_utilisateur' => $Code_vue_utilisateur,
        ];
        return $this->post('a_filtrer?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_filtrer__edit($Code_utilisateur, $Code_vue_utilisateur) {
        $data = [
        ];
        return $this->put('a_filtrer/'.$Code_utilisateur.'-'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_filtrer__delete($Code_utilisateur, $Code_vue_utilisateur) {
        return $this->delete('a_filtrer/'.$Code_utilisateur.'-'.$Code_vue_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

}
