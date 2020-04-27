function worker() {
    execution_passe();
    setTimeout(worker, PERIODE_EXECUTION);
}

$(function(){worker();});

var chrono_promesse = 0;
var collection_promesses = [];
var nb_requetes_en_cours = 0;

function ajouter_action(type, methode, data) {
    nb_requetes_en_cours++;
    var num_promesse = ++chrono_promesse;
    $.ajax({
        url: API_ADDRESS + methode,
        type: type,
        dataType: 'json',
        contentType: 'application/json',
        processData: true,
        headers : {'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'},
        data: data,
        success: function(data) {
            collection_promesses[num_promesse] = data;
            nb_requetes_en_cours--;
        },
        error: function(data) {
            console.log(data.responseText);
            collection_promesses[num_promesse] = false;
            nb_requetes_en_cours--;
        }
    });
    return num_promesse;
}

function promesse(num_promesse) {
    if ( collection_promesses[num_promesse] ) {
        var $p = collection_promesses[num_promesse];
        collection_promesses[num_promesse] = false;
        return $p;
    } else {
        return false;
    }
}

function get_token() {
    return mf_token;
}

function set_token(token) {
    return mf_token = token;
}

// Functions api

var mf_token = "";

var id_promesse__connexion = 0;
function connexion(mf_login, mf_pwd) { id_promesse__connexion = ajouter_action( "POST", "mf_connexion?mf_instance=" + mf_instance, JSON.stringify( { mf_login: mf_login, mf_pwd: mf_pwd } ) ); }
function r__connexion() { var r = promesse(id_promesse__connexion); if ( r ) { mf_token = r['data']['mf_token']; } return r; }

var id_promesse__inscription = 0;
function inscription(mf_login, mf_pwd, mf_pwd_2, mf_email, mf_email_2) { id_promesse__inscription = ajouter_action( "POST", "mf_inscription?mf_instance=" + mf_instance, JSON.stringify( { mf_login: mf_login, mf_pwd: mf_pwd, mf_pwd_2: mf_pwd_2, mf_email: mf_email, mf_email_2: mf_email_2 } ) ); }
function r__inscription() { return promesse(id_promesse__inscription); }

var id_promesse__maj_mdp = 0;
function maj_mdp(Code_utilisateur, mf_current_pwd, mf_new_pwd, mf_conf_pwd) { id_promesse__maj_mdp = ajouter_action( "PUT", "mf_change_password/" + Code_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify( { mf_current_pwd: mf_current_pwd, mf_new_pwd: mf_new_pwd, mf_conf_pwd: mf_conf_pwd } ) ); }
function r__maj_mdp() { return promesse(id_promesse__maj_mdp); }

var id_promesse__demande_nouv_mdp = 0;
function demande_nouv_mdp(mf_login, mf_email) { id_promesse__demande_nouv_mdp = ajouter_action( "POST", "mf_new_password?mf_instance=" + mf_instance, JSON.stringify( { mf_login: mf_login, mf_email: mf_email } ) ); }
function r__demande_nouv_mdp() { return promesse(id_promesse__demande_nouv_mdp); }

// +-------------+
// | utilisateur |
// +-------------+

var id_promesse__utilisateur__get = 0;
var ref_promesse__utilisateur__get = '';
function utilisateur__get(Code_utilisateur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__utilisateur__get = ref; id_promesse__utilisateur__get = ajouter_action( "GET", "utilisateur/" + Code_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__utilisateur__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__utilisateur__get == ref ) { return promesse(id_promesse__utilisateur__get); } else { return false; } }

var id_promesse__utilisateur__get_all = 0;
var ref_promesse__utilisateur__get_all = '';
function utilisateur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__utilisateur__get_all = ref; id_promesse__utilisateur__get_all = ajouter_action( "GET", "utilisateur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__utilisateur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__utilisateur__get_all == ref ) { return promesse(id_promesse__utilisateur__get_all); } else { return false; } }

/*
  json_data = {
    utilisateur_Identifiant: …,
    utilisateur_Password: …,
    utilisateur_Email: …,
    utilisateur_Civilite_Type: …,
    utilisateur_Prenom: …,
    utilisateur_Nom: …,
    utilisateur_Adresse_1: …,
    utilisateur_Adresse_2: …,
    utilisateur_Ville: …,
    utilisateur_Code_postal: …,
    utilisateur_Date_naissance: …,
    utilisateur_Accepte_mail_publicitaire: …,
    utilisateur_Administrateur: …,
    utilisateur_Fournisseur: …,
  }
*/
var id_promesse__utilisateur__post = 0;
var ref_promesse__utilisateur__post = '';
function utilisateur__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__utilisateur__post = ref; id_promesse__utilisateur__post = ajouter_action( "POST", "utilisateur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__utilisateur__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__utilisateur__post == ref ) { return promesse(id_promesse__utilisateur__post); } else { return false; } }

/*
  json_data = {
    utilisateur_Identifiant: …,
    utilisateur_Password: …,
    utilisateur_Email: …,
    utilisateur_Civilite_Type: …,
    utilisateur_Prenom: …,
    utilisateur_Nom: …,
    utilisateur_Adresse_1: …,
    utilisateur_Adresse_2: …,
    utilisateur_Ville: …,
    utilisateur_Code_postal: …,
    utilisateur_Date_naissance: …,
    utilisateur_Accepte_mail_publicitaire: …,
    utilisateur_Administrateur: …,
    utilisateur_Fournisseur: …,
  }
*/
var id_promesse__utilisateur__put = 0;
var ref_promesse__utilisateur__put = '';
function utilisateur__put(Code_utilisateur, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__utilisateur__put = ref; id_promesse__utilisateur__put = ajouter_action( "PUT", "utilisateur/" + Code_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__utilisateur__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__utilisateur__put == ref ) { return promesse(id_promesse__utilisateur__put); } else { return false; } }

var id_promesse__utilisateur__delete = 0;
var ref_promesse__utilisateur__delete = '';
function utilisateur__delete(Code_utilisateur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__utilisateur__delete = ref; id_promesse__utilisateur__delete = ajouter_action( "DELETE", "utilisateur/" + Code_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__utilisateur__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__utilisateur__delete == ref ) { return promesse(id_promesse__utilisateur__delete); } else { return false; } }

// +---------+
// | article |
// +---------+

var id_promesse__article__get = 0;
var ref_promesse__article__get = '';
function article__get(Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__article__get = ref; id_promesse__article__get = ajouter_action( "GET", "article/" + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__article__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__article__get == ref ) { return promesse(id_promesse__article__get); } else { return false; } }

var id_promesse__article__get_all = 0;
var ref_promesse__article__get_all = '';
function article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__article__get_all = ref; id_promesse__article__get_all = ajouter_action( "GET", "article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__article__get_all == ref ) { return promesse(id_promesse__article__get_all); } else { return false; } }

/*
  json_data = {
    article_Libelle: …,
    article_Description: …,
    article_Saison_Type: …,
    article_Nom_fournisseur: …,
    article_Url: …,
    article_Reference: …,
    article_Couleur: …,
    article_Code_couleur_svg: …,
    article_Taille_Pays_Type: …,
    article_Taille: …,
    article_Matiere: …,
    article_Photo_Fichier: …,
    article_Prix: …,
    article_Actif: …,
    Code_sous_categorie_article: …,
  }
*/
var id_promesse__article__post = 0;
var ref_promesse__article__post = '';
function article__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__article__post = ref; id_promesse__article__post = ajouter_action( "POST", "article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__article__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__article__post == ref ) { return promesse(id_promesse__article__post); } else { return false; } }

/*
  json_data = {
    article_Libelle: …,
    article_Description: …,
    article_Saison_Type: …,
    article_Nom_fournisseur: …,
    article_Url: …,
    article_Reference: …,
    article_Couleur: …,
    article_Code_couleur_svg: …,
    article_Taille_Pays_Type: …,
    article_Taille: …,
    article_Matiere: …,
    article_Photo_Fichier: …,
    article_Prix: …,
    article_Actif: …,
    Code_sous_categorie_article: …,
  }
*/
var id_promesse__article__put = 0;
var ref_promesse__article__put = '';
function article__put(Code_article, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__article__put = ref; id_promesse__article__put = ajouter_action( "PUT", "article/" + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__article__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__article__put == ref ) { return promesse(id_promesse__article__put); } else { return false; } }

var id_promesse__article__delete = 0;
var ref_promesse__article__delete = '';
function article__delete(Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__article__delete = ref; id_promesse__article__delete = ajouter_action( "DELETE", "article/" + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__article__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__article__delete == ref ) { return promesse(id_promesse__article__delete); } else { return false; } }

// +----------+
// | commande |
// +----------+

var id_promesse__commande__get = 0;
var ref_promesse__commande__get = '';
function commande__get(Code_commande, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__commande__get = ref; id_promesse__commande__get = ajouter_action( "GET", "commande/" + Code_commande + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__commande__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__commande__get == ref ) { return promesse(id_promesse__commande__get); } else { return false; } }

var id_promesse__commande__get_all = 0;
var ref_promesse__commande__get_all = '';
function commande__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__commande__get_all = ref; id_promesse__commande__get_all = ajouter_action( "GET", "commande?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__commande__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__commande__get_all == ref ) { return promesse(id_promesse__commande__get_all); } else { return false; } }

/*
  json_data = {
    commande_Prix_total: …,
    commande_Date_livraison: …,
    commande_Date_creation: …,
    Code_utilisateur: …,
  }
*/
var id_promesse__commande__post = 0;
var ref_promesse__commande__post = '';
function commande__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__commande__post = ref; id_promesse__commande__post = ajouter_action( "POST", "commande?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__commande__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__commande__post == ref ) { return promesse(id_promesse__commande__post); } else { return false; } }

/*
  json_data = {
    commande_Prix_total: …,
    commande_Date_livraison: …,
    commande_Date_creation: …,
    Code_utilisateur: …,
  }
*/
var id_promesse__commande__put = 0;
var ref_promesse__commande__put = '';
function commande__put(Code_commande, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__commande__put = ref; id_promesse__commande__put = ajouter_action( "PUT", "commande/" + Code_commande + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__commande__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__commande__put == ref ) { return promesse(id_promesse__commande__put); } else { return false; } }

var id_promesse__commande__delete = 0;
var ref_promesse__commande__delete = '';
function commande__delete(Code_commande, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__commande__delete = ref; id_promesse__commande__delete = ajouter_action( "DELETE", "commande/" + Code_commande + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__commande__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__commande__delete == ref ) { return promesse(id_promesse__commande__delete); } else { return false; } }

// +-------------------+
// | categorie_article |
// +-------------------+

var id_promesse__categorie_article__get = 0;
var ref_promesse__categorie_article__get = '';
function categorie_article__get(Code_categorie_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__categorie_article__get = ref; id_promesse__categorie_article__get = ajouter_action( "GET", "categorie_article/" + Code_categorie_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__categorie_article__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__categorie_article__get == ref ) { return promesse(id_promesse__categorie_article__get); } else { return false; } }

var id_promesse__categorie_article__get_all = 0;
var ref_promesse__categorie_article__get_all = '';
function categorie_article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__categorie_article__get_all = ref; id_promesse__categorie_article__get_all = ajouter_action( "GET", "categorie_article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__categorie_article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__categorie_article__get_all == ref ) { return promesse(id_promesse__categorie_article__get_all); } else { return false; } }

/*
  json_data = {
    categorie_article_Libelle: …,
  }
*/
var id_promesse__categorie_article__post = 0;
var ref_promesse__categorie_article__post = '';
function categorie_article__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__categorie_article__post = ref; id_promesse__categorie_article__post = ajouter_action( "POST", "categorie_article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__categorie_article__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__categorie_article__post == ref ) { return promesse(id_promesse__categorie_article__post); } else { return false; } }

/*
  json_data = {
    categorie_article_Libelle: …,
  }
*/
var id_promesse__categorie_article__put = 0;
var ref_promesse__categorie_article__put = '';
function categorie_article__put(Code_categorie_article, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__categorie_article__put = ref; id_promesse__categorie_article__put = ajouter_action( "PUT", "categorie_article/" + Code_categorie_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__categorie_article__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__categorie_article__put == ref ) { return promesse(id_promesse__categorie_article__put); } else { return false; } }

var id_promesse__categorie_article__delete = 0;
var ref_promesse__categorie_article__delete = '';
function categorie_article__delete(Code_categorie_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__categorie_article__delete = ref; id_promesse__categorie_article__delete = ajouter_action( "DELETE", "categorie_article/" + Code_categorie_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__categorie_article__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__categorie_article__delete == ref ) { return promesse(id_promesse__categorie_article__delete); } else { return false; } }

// +-----------+
// | parametre |
// +-----------+

var id_promesse__parametre__get = 0;
var ref_promesse__parametre__get = '';
function parametre__get(Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__get = ref; id_promesse__parametre__get = ajouter_action( "GET", "parametre/" + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__parametre__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__get == ref ) { return promesse(id_promesse__parametre__get); } else { return false; } }

var id_promesse__parametre__get_all = 0;
var ref_promesse__parametre__get_all = '';
function parametre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__get_all = ref; id_promesse__parametre__get_all = ajouter_action( "GET", "parametre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__parametre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__get_all == ref ) { return promesse(id_promesse__parametre__get_all); } else { return false; } }

/*
  json_data = {
    parametre_Libelle: …,
  }
*/
var id_promesse__parametre__post = 0;
var ref_promesse__parametre__post = '';
function parametre__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__post = ref; id_promesse__parametre__post = ajouter_action( "POST", "parametre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__parametre__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__post == ref ) { return promesse(id_promesse__parametre__post); } else { return false; } }

/*
  json_data = {
    parametre_Libelle: …,
  }
*/
var id_promesse__parametre__put = 0;
var ref_promesse__parametre__put = '';
function parametre__put(Code_parametre, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__put = ref; id_promesse__parametre__put = ajouter_action( "PUT", "parametre/" + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__parametre__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__put == ref ) { return promesse(id_promesse__parametre__put); } else { return false; } }

var id_promesse__parametre__delete = 0;
var ref_promesse__parametre__delete = '';
function parametre__delete(Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__parametre__delete = ref; id_promesse__parametre__delete = ajouter_action( "DELETE", "parametre/" + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__parametre__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__parametre__delete == ref ) { return promesse(id_promesse__parametre__delete); } else { return false; } }

// +-----------------+
// | vue_utilisateur |
// +-----------------+

var id_promesse__vue_utilisateur__get = 0;
var ref_promesse__vue_utilisateur__get = '';
function vue_utilisateur__get(Code_vue_utilisateur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__vue_utilisateur__get = ref; id_promesse__vue_utilisateur__get = ajouter_action( "GET", "vue_utilisateur/" + Code_vue_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__vue_utilisateur__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__vue_utilisateur__get == ref ) { return promesse(id_promesse__vue_utilisateur__get); } else { return false; } }

var id_promesse__vue_utilisateur__get_all = 0;
var ref_promesse__vue_utilisateur__get_all = '';
function vue_utilisateur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__vue_utilisateur__get_all = ref; id_promesse__vue_utilisateur__get_all = ajouter_action( "GET", "vue_utilisateur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__vue_utilisateur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__vue_utilisateur__get_all == ref ) { return promesse(id_promesse__vue_utilisateur__get_all); } else { return false; } }

/*
  json_data = {
    vue_utilisateur_Recherche: …,
    vue_utilisateur_Filtre_Saison_Type: …,
    vue_utilisateur_Filtre_Couleur: …,
    vue_utilisateur_Filtre_Taille_Pays_Type: …,
    vue_utilisateur_Filtre_Taille_Max: …,
    vue_utilisateur_Filtre_Taille_Min: …,
  }
*/
var id_promesse__vue_utilisateur__post = 0;
var ref_promesse__vue_utilisateur__post = '';
function vue_utilisateur__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__vue_utilisateur__post = ref; id_promesse__vue_utilisateur__post = ajouter_action( "POST", "vue_utilisateur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__vue_utilisateur__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__vue_utilisateur__post == ref ) { return promesse(id_promesse__vue_utilisateur__post); } else { return false; } }

/*
  json_data = {
    vue_utilisateur_Recherche: …,
    vue_utilisateur_Filtre_Saison_Type: …,
    vue_utilisateur_Filtre_Couleur: …,
    vue_utilisateur_Filtre_Taille_Pays_Type: …,
    vue_utilisateur_Filtre_Taille_Max: …,
    vue_utilisateur_Filtre_Taille_Min: …,
  }
*/
var id_promesse__vue_utilisateur__put = 0;
var ref_promesse__vue_utilisateur__put = '';
function vue_utilisateur__put(Code_vue_utilisateur, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__vue_utilisateur__put = ref; id_promesse__vue_utilisateur__put = ajouter_action( "PUT", "vue_utilisateur/" + Code_vue_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__vue_utilisateur__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__vue_utilisateur__put == ref ) { return promesse(id_promesse__vue_utilisateur__put); } else { return false; } }

var id_promesse__vue_utilisateur__delete = 0;
var ref_promesse__vue_utilisateur__delete = '';
function vue_utilisateur__delete(Code_vue_utilisateur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__vue_utilisateur__delete = ref; id_promesse__vue_utilisateur__delete = ajouter_action( "DELETE", "vue_utilisateur/" + Code_vue_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__vue_utilisateur__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__vue_utilisateur__delete == ref ) { return promesse(id_promesse__vue_utilisateur__delete); } else { return false; } }

// +------------------------+
// | sous_categorie_article |
// +------------------------+

var id_promesse__sous_categorie_article__get = 0;
var ref_promesse__sous_categorie_article__get = '';
function sous_categorie_article__get(Code_sous_categorie_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__sous_categorie_article__get = ref; id_promesse__sous_categorie_article__get = ajouter_action( "GET", "sous_categorie_article/" + Code_sous_categorie_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__sous_categorie_article__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__sous_categorie_article__get == ref ) { return promesse(id_promesse__sous_categorie_article__get); } else { return false; } }

var id_promesse__sous_categorie_article__get_all = 0;
var ref_promesse__sous_categorie_article__get_all = '';
function sous_categorie_article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__sous_categorie_article__get_all = ref; id_promesse__sous_categorie_article__get_all = ajouter_action( "GET", "sous_categorie_article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__sous_categorie_article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__sous_categorie_article__get_all == ref ) { return promesse(id_promesse__sous_categorie_article__get_all); } else { return false; } }

/*
  json_data = {
    sous_categorie_article_Libelle: …,
    Code_categorie_article: …,
  }
*/
var id_promesse__sous_categorie_article__post = 0;
var ref_promesse__sous_categorie_article__post = '';
function sous_categorie_article__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__sous_categorie_article__post = ref; id_promesse__sous_categorie_article__post = ajouter_action( "POST", "sous_categorie_article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__sous_categorie_article__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__sous_categorie_article__post == ref ) { return promesse(id_promesse__sous_categorie_article__post); } else { return false; } }

/*
  json_data = {
    sous_categorie_article_Libelle: …,
    Code_categorie_article: …,
  }
*/
var id_promesse__sous_categorie_article__put = 0;
var ref_promesse__sous_categorie_article__put = '';
function sous_categorie_article__put(Code_sous_categorie_article, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__sous_categorie_article__put = ref; id_promesse__sous_categorie_article__put = ajouter_action( "PUT", "sous_categorie_article/" + Code_sous_categorie_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__sous_categorie_article__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__sous_categorie_article__put == ref ) { return promesse(id_promesse__sous_categorie_article__put); } else { return false; } }

var id_promesse__sous_categorie_article__delete = 0;
var ref_promesse__sous_categorie_article__delete = '';
function sous_categorie_article__delete(Code_sous_categorie_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__sous_categorie_article__delete = ref; id_promesse__sous_categorie_article__delete = ajouter_action( "DELETE", "sous_categorie_article/" + Code_sous_categorie_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__sous_categorie_article__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__sous_categorie_article__delete == ref ) { return promesse(id_promesse__sous_categorie_article__delete); } else { return false; } }

// +---------+
// | conseil |
// +---------+

var id_promesse__conseil__get = 0;
var ref_promesse__conseil__get = '';
function conseil__get(Code_conseil, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__conseil__get = ref; id_promesse__conseil__get = ajouter_action( "GET", "conseil/" + Code_conseil + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__conseil__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__conseil__get == ref ) { return promesse(id_promesse__conseil__get); } else { return false; } }

var id_promesse__conseil__get_all = 0;
var ref_promesse__conseil__get_all = '';
function conseil__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__conseil__get_all = ref; id_promesse__conseil__get_all = ajouter_action( "GET", "conseil?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__conseil__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__conseil__get_all == ref ) { return promesse(id_promesse__conseil__get_all); } else { return false; } }

/*
  json_data = {
    conseil_Libelle: …,
    conseil_Description: …,
    conseil_Actif: …,
  }
*/
var id_promesse__conseil__post = 0;
var ref_promesse__conseil__post = '';
function conseil__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__conseil__post = ref; id_promesse__conseil__post = ajouter_action( "POST", "conseil?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__conseil__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__conseil__post == ref ) { return promesse(id_promesse__conseil__post); } else { return false; } }

/*
  json_data = {
    conseil_Libelle: …,
    conseil_Description: …,
    conseil_Actif: …,
  }
*/
var id_promesse__conseil__put = 0;
var ref_promesse__conseil__put = '';
function conseil__put(Code_conseil, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__conseil__put = ref; id_promesse__conseil__put = ajouter_action( "PUT", "conseil/" + Code_conseil + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__conseil__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__conseil__put == ref ) { return promesse(id_promesse__conseil__put); } else { return false; } }

var id_promesse__conseil__delete = 0;
var ref_promesse__conseil__delete = '';
function conseil__delete(Code_conseil, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__conseil__delete = ref; id_promesse__conseil__delete = ajouter_action( "DELETE", "conseil/" + Code_conseil + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__conseil__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__conseil__delete == ref ) { return promesse(id_promesse__conseil__delete); } else { return false; } }

// +--------------------+
// | a_commande_article |
// +--------------------+

var id_promesse__a_commande_article__get = 0;
var ref_promesse__a_commande_article__get = '';
function a_commande_article__get(Code_commande, Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_commande_article__get = ref; id_promesse__a_commande_article__get = ajouter_action( "GET", "a_commande_article/" + Code_commande + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_commande_article__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_commande_article__get == ref ) { return promesse(id_promesse__a_commande_article__get); } else { return false; } }

var id_promesse__a_commande_article__get_all = 0;
var ref_promesse__a_commande_article__get_all = '';
function a_commande_article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_commande_article__get_all = ref; id_promesse__a_commande_article__get_all = ajouter_action( "GET", "a_commande_article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_commande_article__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_commande_article__get_all == ref ) { return promesse(id_promesse__a_commande_article__get_all); } else { return false; } }

/*
  json_data = {
    a_commande_article_Quantite: …,
    a_commande_article_Prix_ligne: …,
    Code_commande: …,
    Code_article: …,
  }
*/
var id_promesse__a_commande_article__post = 0;
var ref_promesse__a_commande_article__post = '';
function a_commande_article__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_commande_article__post = ref; id_promesse__a_commande_article__post = ajouter_action( "POST", "a_commande_article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_commande_article__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_commande_article__post == ref ) { return promesse(id_promesse__a_commande_article__post); } else { return false; } }

/*
  json_data = {
    a_commande_article_Quantite: …,
    a_commande_article_Prix_ligne: …,
  }
*/
var id_promesse__a_commande_article__put = 0;
var ref_promesse__a_commande_article__put = '';
function a_commande_article__put(Code_commande, Code_article, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_commande_article__put = ref; id_promesse__a_commande_article__put = ajouter_action( "PUT", "a_commande_article/" + Code_commande + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_commande_article__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_commande_article__put == ref ) { return promesse(id_promesse__a_commande_article__put); } else { return false; } }

var id_promesse__a_commande_article__delete = 0;
var ref_promesse__a_commande_article__delete = '';
function a_commande_article__delete(Code_commande, Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_commande_article__delete = ref; id_promesse__a_commande_article__delete = ajouter_action( "DELETE", "a_commande_article/" + Code_commande + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_commande_article__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_commande_article__delete == ref ) { return promesse(id_promesse__a_commande_article__delete); } else { return false; } }

// +-------------------------+
// | a_parametre_utilisateur |
// +-------------------------+

var id_promesse__a_parametre_utilisateur__get = 0;
var ref_promesse__a_parametre_utilisateur__get = '';
function a_parametre_utilisateur__get(Code_utilisateur, Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_parametre_utilisateur__get = ref; id_promesse__a_parametre_utilisateur__get = ajouter_action( "GET", "a_parametre_utilisateur/" + Code_utilisateur + '-' + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_parametre_utilisateur__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_parametre_utilisateur__get == ref ) { return promesse(id_promesse__a_parametre_utilisateur__get); } else { return false; } }

var id_promesse__a_parametre_utilisateur__get_all = 0;
var ref_promesse__a_parametre_utilisateur__get_all = '';
function a_parametre_utilisateur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_parametre_utilisateur__get_all = ref; id_promesse__a_parametre_utilisateur__get_all = ajouter_action( "GET", "a_parametre_utilisateur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_parametre_utilisateur__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_parametre_utilisateur__get_all == ref ) { return promesse(id_promesse__a_parametre_utilisateur__get_all); } else { return false; } }

/*
  json_data = {
    a_parametre_utilisateur_Valeur: …,
    a_parametre_utilisateur_Actif: …,
    Code_utilisateur: …,
    Code_parametre: …,
  }
*/
var id_promesse__a_parametre_utilisateur__post = 0;
var ref_promesse__a_parametre_utilisateur__post = '';
function a_parametre_utilisateur__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_parametre_utilisateur__post = ref; id_promesse__a_parametre_utilisateur__post = ajouter_action( "POST", "a_parametre_utilisateur?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_parametre_utilisateur__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_parametre_utilisateur__post == ref ) { return promesse(id_promesse__a_parametre_utilisateur__post); } else { return false; } }

/*
  json_data = {
    a_parametre_utilisateur_Valeur: …,
    a_parametre_utilisateur_Actif: …,
  }
*/
var id_promesse__a_parametre_utilisateur__put = 0;
var ref_promesse__a_parametre_utilisateur__put = '';
function a_parametre_utilisateur__put(Code_utilisateur, Code_parametre, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_parametre_utilisateur__put = ref; id_promesse__a_parametre_utilisateur__put = ajouter_action( "PUT", "a_parametre_utilisateur/" + Code_utilisateur + '-' + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_parametre_utilisateur__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_parametre_utilisateur__put == ref ) { return promesse(id_promesse__a_parametre_utilisateur__put); } else { return false; } }

var id_promesse__a_parametre_utilisateur__delete = 0;
var ref_promesse__a_parametre_utilisateur__delete = '';
function a_parametre_utilisateur__delete(Code_utilisateur, Code_parametre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_parametre_utilisateur__delete = ref; id_promesse__a_parametre_utilisateur__delete = ajouter_action( "DELETE", "a_parametre_utilisateur/" + Code_utilisateur + '-' + Code_parametre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_parametre_utilisateur__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_parametre_utilisateur__delete == ref ) { return promesse(id_promesse__a_parametre_utilisateur__delete); } else { return false; } }

// +-----------+
// | a_filtrer |
// +-----------+

var id_promesse__a_filtrer__get = 0;
var ref_promesse__a_filtrer__get = '';
function a_filtrer__get(Code_utilisateur, Code_vue_utilisateur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtrer__get = ref; id_promesse__a_filtrer__get = ajouter_action( "GET", "a_filtrer/" + Code_utilisateur + '-' + Code_vue_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_filtrer__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtrer__get == ref ) { return promesse(id_promesse__a_filtrer__get); } else { return false; } }

var id_promesse__a_filtrer__get_all = 0;
var ref_promesse__a_filtrer__get_all = '';
function a_filtrer__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtrer__get_all = ref; id_promesse__a_filtrer__get_all = ajouter_action( "GET", "a_filtrer?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_filtrer__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtrer__get_all == ref ) { return promesse(id_promesse__a_filtrer__get_all); } else { return false; } }

/*
  json_data = {
    Code_utilisateur: …,
    Code_vue_utilisateur: …,
  }
*/
var id_promesse__a_filtrer__post = 0;
var ref_promesse__a_filtrer__post = '';
function a_filtrer__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtrer__post = ref; id_promesse__a_filtrer__post = ajouter_action( "POST", "a_filtrer?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_filtrer__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtrer__post == ref ) { return promesse(id_promesse__a_filtrer__post); } else { return false; } }

/*
  json_data = {
  }
*/
var id_promesse__a_filtrer__put = 0;
var ref_promesse__a_filtrer__put = '';
function a_filtrer__put(Code_utilisateur, Code_vue_utilisateur, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtrer__put = ref; id_promesse__a_filtrer__put = ajouter_action( "PUT", "a_filtrer/" + Code_utilisateur + '-' + Code_vue_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_filtrer__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtrer__put == ref ) { return promesse(id_promesse__a_filtrer__put); } else { return false; } }

var id_promesse__a_filtrer__delete = 0;
var ref_promesse__a_filtrer__delete = '';
function a_filtrer__delete(Code_utilisateur, Code_vue_utilisateur, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtrer__delete = ref; id_promesse__a_filtrer__delete = ajouter_action( "DELETE", "a_filtrer/" + Code_utilisateur + '-' + Code_vue_utilisateur + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_filtrer__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtrer__delete == ref ) { return promesse(id_promesse__a_filtrer__delete); } else { return false; } }

