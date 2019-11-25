
// Paramètres

var API_ADDRESS = "";
var l = "" + window.location;
if (l.indexOf("localhost")>-1) { API_ADDRESS = "http://localhost/make-your-style/www/make-your-style/api.rest/"; }
else { API_ADDRESS = "..."; }
const PERIODE_EXECUTION = 100; // (en millisecondes)
var mf_instance = 0; // instance
var auth = "main"; // utilisation de l'instance courante du navigateur.

// Algorithme

function execution_passe() {
    // ici le code
}

// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------

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
        success: function (data) {
            collection_promesses[num_promesse] = data;
            nb_requetes_en_cours--;
        },
        error: function(){
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
    utilisateur_Administrateur: …,
    utilisateur_Developpeur: …,
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
    utilisateur_Administrateur: …,
    utilisateur_Developpeur: …,
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
    article_Photo_Fichier: …,
    article_Prix: …,
    article_Actif: …,
    Code_type_produit: …,
  }
*/
var id_promesse__article__post = 0;
var ref_promesse__article__post = '';
function article__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__article__post = ref; id_promesse__article__post = ajouter_action( "POST", "article?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__article__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__article__post == ref ) { return promesse(id_promesse__article__post); } else { return false; } }

/*
  json_data = {
    article_Libelle: …,
    article_Photo_Fichier: …,
    article_Prix: …,
    article_Actif: …,
    Code_type_produit: …,
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

// +--------------+
// | type_produit |
// +--------------+

var id_promesse__type_produit__get = 0;
var ref_promesse__type_produit__get = '';
function type_produit__get(Code_type_produit, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type_produit__get = ref; id_promesse__type_produit__get = ajouter_action( "GET", "type_produit/" + Code_type_produit + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__type_produit__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type_produit__get == ref ) { return promesse(id_promesse__type_produit__get); } else { return false; } }

var id_promesse__type_produit__get_all = 0;
var ref_promesse__type_produit__get_all = '';
function type_produit__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type_produit__get_all = ref; id_promesse__type_produit__get_all = ajouter_action( "GET", "type_produit?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__type_produit__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type_produit__get_all == ref ) { return promesse(id_promesse__type_produit__get_all); } else { return false; } }

/*
  json_data = {
    type_produit_Libelle: …,
  }
*/
var id_promesse__type_produit__post = 0;
var ref_promesse__type_produit__post = '';
function type_produit__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type_produit__post = ref; id_promesse__type_produit__post = ajouter_action( "POST", "type_produit?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__type_produit__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type_produit__post == ref ) { return promesse(id_promesse__type_produit__post); } else { return false; } }

/*
  json_data = {
    type_produit_Libelle: …,
  }
*/
var id_promesse__type_produit__put = 0;
var ref_promesse__type_produit__put = '';
function type_produit__put(Code_type_produit, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type_produit__put = ref; id_promesse__type_produit__put = ajouter_action( "PUT", "type_produit/" + Code_type_produit + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__type_produit__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type_produit__put == ref ) { return promesse(id_promesse__type_produit__put); } else { return false; } }

var id_promesse__type_produit__delete = 0;
var ref_promesse__type_produit__delete = '';
function type_produit__delete(Code_type_produit, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__type_produit__delete = ref; id_promesse__type_produit__delete = ajouter_action( "DELETE", "type_produit/" + Code_type_produit + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__type_produit__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__type_produit__delete == ref ) { return promesse(id_promesse__type_produit__delete); } else { return false; } }

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

// +--------+
// | filtre |
// +--------+

var id_promesse__filtre__get = 0;
var ref_promesse__filtre__get = '';
function filtre__get(Code_filtre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__filtre__get = ref; id_promesse__filtre__get = ajouter_action( "GET", "filtre/" + Code_filtre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__filtre__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__filtre__get == ref ) { return promesse(id_promesse__filtre__get); } else { return false; } }

var id_promesse__filtre__get_all = 0;
var ref_promesse__filtre__get_all = '';
function filtre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__filtre__get_all = ref; id_promesse__filtre__get_all = ajouter_action( "GET", "filtre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__filtre__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__filtre__get_all == ref ) { return promesse(id_promesse__filtre__get_all); } else { return false; } }

/*
  json_data = {
    filtre_Libelle: …,
  }
*/
var id_promesse__filtre__post = 0;
var ref_promesse__filtre__post = '';
function filtre__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__filtre__post = ref; id_promesse__filtre__post = ajouter_action( "POST", "filtre?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__filtre__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__filtre__post == ref ) { return promesse(id_promesse__filtre__post); } else { return false; } }

/*
  json_data = {
    filtre_Libelle: …,
  }
*/
var id_promesse__filtre__put = 0;
var ref_promesse__filtre__put = '';
function filtre__put(Code_filtre, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__filtre__put = ref; id_promesse__filtre__put = ajouter_action( "PUT", "filtre/" + Code_filtre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__filtre__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__filtre__put == ref ) { return promesse(id_promesse__filtre__put); } else { return false; } }

var id_promesse__filtre__delete = 0;
var ref_promesse__filtre__delete = '';
function filtre__delete(Code_filtre, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__filtre__delete = ref; id_promesse__filtre__delete = ajouter_action( "DELETE", "filtre/" + Code_filtre + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__filtre__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__filtre__delete == ref ) { return promesse(id_promesse__filtre__delete); } else { return false; } }

// +--------------------+
// | a_article_commande |
// +--------------------+

var id_promesse__a_article_commande__get = 0;
var ref_promesse__a_article_commande__get = '';
function a_article_commande__get(Code_commande, Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_article_commande__get = ref; id_promesse__a_article_commande__get = ajouter_action( "GET", "a_article_commande/" + Code_commande + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_article_commande__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_article_commande__get == ref ) { return promesse(id_promesse__a_article_commande__get); } else { return false; } }

var id_promesse__a_article_commande__get_all = 0;
var ref_promesse__a_article_commande__get_all = '';
function a_article_commande__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_article_commande__get_all = ref; id_promesse__a_article_commande__get_all = ajouter_action( "GET", "a_article_commande?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_article_commande__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_article_commande__get_all == ref ) { return promesse(id_promesse__a_article_commande__get_all); } else { return false; } }

/*
  json_data = {
    Code_commande: …,
    Code_article: …,
  }
*/
var id_promesse__a_article_commande__post = 0;
var ref_promesse__a_article_commande__post = '';
function a_article_commande__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_article_commande__post = ref; id_promesse__a_article_commande__post = ajouter_action( "POST", "a_article_commande?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_article_commande__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_article_commande__post == ref ) { return promesse(id_promesse__a_article_commande__post); } else { return false; } }

/*
  json_data = {
  }
*/
var id_promesse__a_article_commande__put = 0;
var ref_promesse__a_article_commande__put = '';
function a_article_commande__put(Code_commande, Code_article, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_article_commande__put = ref; id_promesse__a_article_commande__put = ajouter_action( "PUT", "a_article_commande/" + Code_commande + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_article_commande__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_article_commande__put == ref ) { return promesse(id_promesse__a_article_commande__put); } else { return false; } }

var id_promesse__a_article_commande__delete = 0;
var ref_promesse__a_article_commande__delete = '';
function a_article_commande__delete(Code_commande, Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_article_commande__delete = ref; id_promesse__a_article_commande__delete = ajouter_action( "DELETE", "a_article_commande/" + Code_commande + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_article_commande__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_article_commande__delete == ref ) { return promesse(id_promesse__a_article_commande__delete); } else { return false; } }

// +------------------+
// | a_filtre_produit |
// +------------------+

var id_promesse__a_filtre_produit__get = 0;
var ref_promesse__a_filtre_produit__get = '';
function a_filtre_produit__get(Code_filtre, Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtre_produit__get = ref; id_promesse__a_filtre_produit__get = ajouter_action( "GET", "a_filtre_produit/" + Code_filtre + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_filtre_produit__get(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtre_produit__get == ref ) { return promesse(id_promesse__a_filtre_produit__get); } else { return false; } }

var id_promesse__a_filtre_produit__get_all = 0;
var ref_promesse__a_filtre_produit__get_all = '';
function a_filtre_produit__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtre_produit__get_all = ref; id_promesse__a_filtre_produit__get_all = ajouter_action( "GET", "a_filtre_produit?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, "" ); }
function r__a_filtre_produit__get_all(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtre_produit__get_all == ref ) { return promesse(id_promesse__a_filtre_produit__get_all); } else { return false; } }

/*
  json_data = {
    a_filtre_produit_Actif: …,
    Code_filtre: …,
    Code_article: …,
  }
*/
var id_promesse__a_filtre_produit__post = 0;
var ref_promesse__a_filtre_produit__post = '';
function a_filtre_produit__post(json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtre_produit__post = ref; id_promesse__a_filtre_produit__post = ajouter_action( "POST", "a_filtre_produit?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_filtre_produit__post(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtre_produit__post == ref ) { return promesse(id_promesse__a_filtre_produit__post); } else { return false; } }

/*
  json_data = {
    a_filtre_produit_Actif: …,
  }
*/
var id_promesse__a_filtre_produit__put = 0;
var ref_promesse__a_filtre_produit__put = '';
function a_filtre_produit__put(Code_filtre, Code_article, json_data, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtre_produit__put = ref; id_promesse__a_filtre_produit__put = ajouter_action( "PUT", "a_filtre_produit/" + Code_filtre + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth, JSON.stringify(json_data) ); }
function r__a_filtre_produit__put(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtre_produit__put == ref ) { return promesse(id_promesse__a_filtre_produit__put); } else { return false; } }

var id_promesse__a_filtre_produit__delete = 0;
var ref_promesse__a_filtre_produit__delete = '';
function a_filtre_produit__delete(Code_filtre, Code_article, ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; ref_promesse__a_filtre_produit__delete = ref; id_promesse__a_filtre_produit__delete = ajouter_action( "DELETE", "a_filtre_produit/" + Code_filtre + '-' + Code_article + "?mf_instance=" + mf_instance + "&mf_token=" + mf_token + "&auth=" + auth ); }
function r__a_filtre_produit__delete(ref) { var ref = (typeof ref !== 'undefined') ? ref : ''; if ( ref_promesse__a_filtre_produit__delete == ref ) { return promesse(id_promesse__a_filtre_produit__delete); } else { return false; } }

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

