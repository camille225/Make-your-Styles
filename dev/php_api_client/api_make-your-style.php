<?php

class Api_make_your_style {

    private $url_api;
    private $mf_token='';
    private $mf_id='';
    private $mf_num_error=0;
    private $mf_errot_lib='';
    private $mf_connector_token='';
    private $mf_instance=0;

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
        $this->mf_num_error = $r['error']['number'];
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

    public function utilisateur__add($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur) {
        $data = [
            'utilisateur_Identifiant' => $utilisateur_Identifiant,
            'utilisateur_Password' => $utilisateur_Password,
            'utilisateur_Email' => $utilisateur_Email,
            'utilisateur_Administrateur' => $utilisateur_Administrateur,
            'utilisateur_Developpeur' => $utilisateur_Developpeur,
        ];
        return $this->post('utilisateur?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit($Code_utilisateur, $utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur) {
        $data = [
            'utilisateur_Identifiant' => $utilisateur_Identifiant,
            'utilisateur_Password' => $utilisateur_Password,
            'utilisateur_Email' => $utilisateur_Email,
            'utilisateur_Administrateur' => $utilisateur_Administrateur,
            'utilisateur_Developpeur' => $utilisateur_Developpeur,
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

    public function utilisateur__edit__utilisateur_Administrateur($Code_utilisateur, $utilisateur_Administrateur) {
        $data = ['utilisateur_Administrateur' => $utilisateur_Administrateur ];
        return $this->put('utilisateur/'.$Code_utilisateur.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function utilisateur__edit__utilisateur_Developpeur($Code_utilisateur, $utilisateur_Developpeur) {
        $data = ['utilisateur_Developpeur' => $utilisateur_Developpeur ];
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

    public function article__get_all(?int $Code_type_produit = null) {
        $requete = '';
        $Code_type_produit = (int) $Code_type_produit;
        if ($Code_type_produit != 0) { $requete .= 'type_produit/' . $Code_type_produit . '/'; }
        return $this->get($requete . 'article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function article__add($Code_type_produit, $article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif) {
        $data = [
            'article_Libelle' => $article_Libelle,
            'article_Photo_Fichier' => $article_Photo_Fichier,
            'article_Prix' => $article_Prix,
            'article_Actif' => $article_Actif,
            'Code_type_produit' => $Code_type_produit,
        ];
        return $this->post('article?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit($Code_article, $Code_type_produit, $article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif) {
        $data = [
            'article_Libelle' => $article_Libelle,
            'article_Photo_Fichier' => $article_Photo_Fichier,
            'article_Prix' => $article_Prix,
            'article_Actif' => $article_Actif,
            'Code_type_produit' => $Code_type_produit,
        ];
        return $this->put('article/'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function article__edit__article_Libelle($Code_article, $article_Libelle) {
        $data = ['article_Libelle' => $article_Libelle ];
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

    public function article__edit__type_produit($Code_article, $type_produit) {
        $data = ['type_produit' => $type_produit ];
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

    // +--------------+
    // | type_produit |
    // +--------------+

    public function type_produit__get($Code_type_produit) {
        return $this->get('type_produit/'.$Code_type_produit.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function type_produit__get_all() {
        $requete = '';
        return $this->get($requete . 'type_produit?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function type_produit__add($type_produit_Libelle) {
        $data = [
            'type_produit_Libelle' => $type_produit_Libelle,
        ];
        return $this->post('type_produit?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type_produit__edit($Code_type_produit, $type_produit_Libelle) {
        $data = [
            'type_produit_Libelle' => $type_produit_Libelle,
        ];
        return $this->put('type_produit/'.$Code_type_produit.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type_produit__edit__type_produit_Libelle($Code_type_produit, $type_produit_Libelle) {
        $data = ['type_produit_Libelle' => $type_produit_Libelle ];
        return $this->put('type_produit/'.$Code_type_produit.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function type_produit__delete($Code_type_produit) {
        return $this->delete('type_produit/'.$Code_type_produit.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
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

    // +--------+
    // | filtre |
    // +--------+

    public function filtre__get($Code_filtre) {
        return $this->get('filtre/'.$Code_filtre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function filtre__get_all() {
        $requete = '';
        return $this->get($requete . 'filtre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function filtre__add($filtre_Libelle) {
        $data = [
            'filtre_Libelle' => $filtre_Libelle,
        ];
        return $this->post('filtre?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function filtre__edit($Code_filtre, $filtre_Libelle) {
        $data = [
            'filtre_Libelle' => $filtre_Libelle,
        ];
        return $this->put('filtre/'.$Code_filtre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function filtre__edit__filtre_Libelle($Code_filtre, $filtre_Libelle) {
        $data = ['filtre_Libelle' => $filtre_Libelle ];
        return $this->put('filtre/'.$Code_filtre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function filtre__delete($Code_filtre) {
        return $this->delete('filtre/'.$Code_filtre.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +--------------------+
    // | a_article_commande |
    // +--------------------+

    public function a_article_commande__get($Code_commande, $Code_article) {
        return $this->get('a_article_commande/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_article_commande__get_all(?int $Code_commande = null, ?int $Code_article = null) {
        $requete = '';
        $Code_commande = (int) $Code_commande;
        if ($Code_commande != 0) { $requete .= 'commande/' . $Code_commande . '/'; }
        $Code_article = (int) $Code_article;
        if ($Code_article != 0) { $requete .= 'article/' . $Code_article . '/'; }
        return $this->get($requete . 'a_article_commande?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_article_commande__add($Code_commande, $Code_article) {
        $data = [
            'Code_commande' => $Code_commande,
            'Code_article' => $Code_article,
        ];
        return $this->post('a_article_commande?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_article_commande__edit($Code_commande, $Code_article) {
        $data = [
        ];
        return $this->put('a_article_commande/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_article_commande__delete($Code_commande, $Code_article) {
        return $this->delete('a_article_commande/'.$Code_commande.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    // +------------------+
    // | a_filtre_produit |
    // +------------------+

    public function a_filtre_produit__get($Code_filtre, $Code_article) {
        return $this->get('a_filtre_produit/'.$Code_filtre.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_filtre_produit__get_all(?int $Code_filtre = null, ?int $Code_article = null) {
        $requete = '';
        $Code_filtre = (int) $Code_filtre;
        if ($Code_filtre != 0) { $requete .= 'filtre/' . $Code_filtre . '/'; }
        $Code_article = (int) $Code_article;
        if ($Code_article != 0) { $requete .= 'article/' . $Code_article . '/'; }
        return $this->get($requete . 'a_filtre_produit?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
    }

    public function a_filtre_produit__add($Code_filtre, $Code_article, $a_filtre_produit_Actif) {
        $data = [
            'a_filtre_produit_Actif' => $a_filtre_produit_Actif,
            'Code_filtre' => $Code_filtre,
            'Code_article' => $Code_article,
        ];
        return $this->post('a_filtre_produit?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_filtre_produit__edit($Code_filtre, $Code_article, $a_filtre_produit_Actif) {
        $data = [
            'a_filtre_produit_Actif' => $a_filtre_produit_Actif,
        ];
        return $this->put('a_filtre_produit/'.$Code_filtre.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_filtre_produit__edit__a_filtre_produit_Actif($Code_filtre, $Code_article, $a_filtre_produit_Actif) {
        $data = ['a_filtre_produit_Actif' => $a_filtre_produit_Actif ];
        return $this->put('a_filtre_produit/'.$Code_filtre.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance, $data);
    }

    public function a_filtre_produit__delete($Code_filtre, $Code_article) {
        return $this->delete('a_filtre_produit/'.$Code_filtre.'-'.$Code_article.'?mf_token='.$this->mf_token.'&mf_connector_token='.$this->mf_connector_token.'&mf_instance='.$this->mf_instance);
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

}
