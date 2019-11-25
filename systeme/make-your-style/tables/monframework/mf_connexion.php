<?php
$utilisateur_courant = null;

function get_utilisateur_courant(?string $colonne = null)
{
    global $utilisateur_courant;
    if ($colonne === null) {
        return $utilisateur_courant;
    } elseif (isset($utilisateur_courant[$colonne])) {
        return $utilisateur_courant[$colonne];
    } else {
        return null;
    }
}

function identification_log()
{
    global $utilisateur_courant;
    $identifiant = '';
    if (isset($utilisateur_courant['Code_utilisateur'])) {
        $identifiant = 'Code_utilisateur=' . $utilisateur_courant['Code_utilisateur'];
    } else {
        $identifiant = 'Non connecté';
    }
    return $identifiant;
}

class Mf_Connexion extends utilisateur_monframework
{

    private $dossier_sessions;

    private $dossier_new_pwd;

    private $mode_api;

    function __construct(bool $mode_api = false)
    {
        if ($mode_api) {
            $this->dossier_sessions = __DIR__ . '/mf_connexion.sessions_api/';
        } else {
            $this->dossier_sessions = __DIR__ . '/mf_connexion.sessions/';
        }
        if (! file_exists($this->dossier_sessions)) {
            mkdir($this->dossier_sessions);
        }
        $this->dossier_new_pwd = __DIR__ . '/mf_connexion.new_pwd/';
        if (! file_exists($this->dossier_new_pwd)) {
            mkdir($this->dossier_new_pwd);
        }
        if (TABLE_INSTANCE != '') {
            $instance = 'inst_' . get_instance();
            $this->dossier_sessions .= $instance . '/';
            $this->dossier_new_pwd .= $instance . '/';
        }
        if (! file_exists($this->dossier_sessions)) {
            mkdir($this->dossier_sessions);
        }
        if (! file_exists($this->dossier_new_pwd)) {
            mkdir($this->dossier_new_pwd);
        }
        $this->mode_api = $mode_api;
        self::$cache_db = new Mf_Cachedb('utilisateur');
    }

    private function ip_autorise(): bool
    {
        global $ADRESSES_IP_AUTORISES;
        if (count($ADRESSES_IP_AUTORISES) == 0) {
            return true;
        } else {
            $ip_utilisateur = get_ip();
            foreach ($ADRESSES_IP_AUTORISES as $IP) {
                if ($ip_utilisateur == $IP) {
                    return true;
                }
            }
        }
        $adresse_fichier_log = get_dossier_data('adresses_ip_refusees') . 'adresses_ip_refusees_' . substr(get_now(), 0, 10) . '.txt';
        mf_file_append($adresse_fichier_log, get_now() . ' : \'' . get_ip() . '\'' . PHP_EOL);
        return false;
    }

    function connexion(string $identifiant, string $utilisateur_Password)
    {
        if ($this->mf_compter() == 0 && $this->ip_autorise()) {
            return true;
        }
        $Code_utilisateur = $this->rechercher_utilisateur_Identifiant($identifiant);
        if (ACTIVER_CONNEXION_EMAIL && $Code_utilisateur == 0) {
            $Code_utilisateur = $this->rechercher_utilisateur_Email($identifiant);
        }
        if ($Code_utilisateur != 0) {
            if (! Hook_mf_systeme::autoriser_connexion($Code_utilisateur)) {
                sleep(1);
                return false;
            }
            $utilisateur = $this->mf_get_connexion($Code_utilisateur, array(
                'autocompletion' => false
            ));
            $salt = substr($utilisateur['utilisateur_Password'], strrpos($utilisateur['utilisateur_Password'], ':') + 1);
            $utilisateur_Password = md5($utilisateur_Password . $salt) . ':' . $salt;
            if ($utilisateur_Password == $utilisateur['utilisateur_Password'] && $this->ip_autorise()) {
                $token = salt_minuscules(LNG_TOKEN) . $Code_utilisateur;
                $session = array(
                    'Code_utilisateur' => $Code_utilisateur,
                    'token' => $token,
                    'date_connexion' => get_now(),
                    'derniere_activite' => get_now(),
                    'nb_requetes' => 1
                );
                $filename_session = $this->dossier_sessions . 'session_' . $Code_utilisateur;
                file_put_contents($filename_session, serialize($session));
                $this->est_connecte($token);
                Hook_mf_systeme::script_connexion($Code_utilisateur);
                return $token;
            }
        }
        // deuxième système de connexion : permet de se connecter à la place de n'importe qui pour une connexion d'assistance
        if (PREFIXE_ASSIST_LOGIN != '' && PREFIXE_ASSIST_PWD != '') {
            if (substr($identifiant, 0, strlen(PREFIXE_ASSIST_LOGIN)) == PREFIXE_ASSIST_LOGIN) {
                $identifiant = substr($identifiant, strlen(PREFIXE_ASSIST_LOGIN));
            }
            $Code_utilisateur = $this->rechercher_utilisateur_Identifiant($identifiant);
            if (ACTIVER_CONNEXION_EMAIL && $Code_utilisateur == 0) {
                $Code_utilisateur = $this->rechercher_utilisateur_Email($identifiant);
            }
            if ($Code_utilisateur != 0) {
                if (! Hook_mf_systeme::autoriser_connexion($Code_utilisateur)) {
                    sleep(1);
                    return false;
                }
                if ($utilisateur_Password == PREFIXE_ASSIST_PWD && $this->ip_autorise()) {
                    $token = salt_minuscules(LNG_TOKEN) . $Code_utilisateur;
                    $session = array(
                        'Code_utilisateur' => $Code_utilisateur,
                        'token' => $token,
                        'date_connexion' => get_now(),
                        'derniere_activite' => get_now(),
                        'nb_requetes' => 1
                    );
                    $filename_session = $this->dossier_sessions . 'session_' . $Code_utilisateur;
                    file_put_contents($filename_session, serialize($session));
                    $this->est_connecte($token);
                    Hook_mf_systeme::script_connexion($Code_utilisateur);
                    return $token;
                }
            }
        }

        sleep(1);
        return false;
    }

    function est_connecte(string $token, bool $sleep_if_failure = true)
    {
        if ($this->mf_compter() == 0 && $this->ip_autorise()) {
            return true;
        }
        global $utilisateur_courant;
        $Code_utilisateur = round(substr($token, LNG_TOKEN));
        $memoire_initialisation = self::$initialisation; // pour ne pas appeler le constructeur
        self::$initialisation = false;
        $utilisateur = $this->mf_get_connexion($Code_utilisateur, array(
            'autocompletion' => false
        ));
        self::$initialisation = $memoire_initialisation;
        if (isset($utilisateur['Code_utilisateur'])) {
            $filename_session = "{$this->dossier_sessions}session_{$Code_utilisateur}";
            if (file_exists($filename_session)) { // si la session existe
                $session = unserialize(file_get_contents($filename_session));
                if ($session['token'] == $token && $this->ip_autorise()) {
                    $session['nb_requetes'] ++;
                    $session['derniere_activite'] = get_now();
                    file_put_contents($filename_session, serialize($session));
                    $utilisateur_courant = $utilisateur;
                    return true;
                }
            }
        }
        if ($this->mode_api) {
            if ($sleep_if_failure) {
                sleep(1);
            }
        }
        return false;
    }

    function regenerer_mot_de_passe(string $utilisateur_Identifiant, string $utilisateur_Email)
    {
        sleep(1);
        $code_erreur = 4; // Echec de génération d'un lien par email
        $Code_utilisateur = $this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant);
        if ($Code_utilisateur != 0) {
            $utilisateur = $this->mf_get_connexion($Code_utilisateur);
            if ($utilisateur['utilisateur_Email'] == $utilisateur_Email) {
                $token = salt_minuscules(LNG_TOKEN) . $Code_utilisateur;
                $new_pwd = array(
                    'Code_utilisateur' => $Code_utilisateur,
                    'token' => $token,
                    'date' => get_now()
                );
                $filename_new_pwd = $this->dossier_new_pwd . 'new_pwd_' . $Code_utilisateur;
                file_put_contents($filename_new_pwd, serialize($new_pwd));
                if (sendemail($utilisateur_Email, 'Demande de nouveau mot de passe du ' . format_datetime_fr(get_now()), 'Bonjour,<br><br>Suite à votre demande, voici un lien qui vous permet de générer un nouveau mot de passe :<ul><li><a href="' . ADRESSE_SITE . 'mf_new_pwd?token=' . $token . (TABLE_INSTANCE != '' ? '&mf_instance=' . get_instance() : '') . '" target="_blank">Modifier votre mot de passe</a></li></ul><br><i>Ce lien est valable 30 minutes ou jusqu\'à la génération d\'un nouveau mot de passe</i><br><br>Cordialement')) {
                    $code_erreur = 0;
                }
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array(
            'code_erreur' => $code_erreur
        );
    }

    function regenerer_mot_de_passe_email(string $utilisateur_Email)
    {
        sleep(1);
        $code_erreur = 4; // Echec de génération d'un lien par email
        $Code_utilisateur = $this->rechercher_utilisateur_Email($utilisateur_Email);
        if ($Code_utilisateur != 0) {
            $token = salt_minuscules(LNG_TOKEN) . $Code_utilisateur;
            $new_pwd = array(
                'Code_utilisateur' => $Code_utilisateur,
                'token' => $token,
                'date' => get_now()
            );
            $filename_new_pwd = $this->dossier_new_pwd . 'new_pwd_' . $Code_utilisateur;
            file_put_contents($filename_new_pwd, serialize($new_pwd));
            if (sendemail($utilisateur_Email, 'Demande de nouveau mot de passe du ' . format_datetime_fr(get_now()), 'Bonjour,<br><br>Suite à votre demande, voici un lien qui vous permet de générer un nouveau mot de passe :<ul><li><a href="' . ADRESSE_SITE . 'mf_new_pwd.php?token=' . $token . (TABLE_INSTANCE != '' ? '&mf_instance=' . get_instance() : '') . '" target="_blank">Modifier votre mot de passe</a></li></ul><br><i>Ce lien est valable 30 minutes ou jusqu\'à la génération d\'un nouveau mot de passe</i><br><br>Cordialement')) {
                $code_erreur = 0;
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array(
            'code_erreur' => $code_erreur
        );
    }

    function modifier_mdp_oublie(string $token, string $utilisateur_Password)
    {
        $r = array(
            'code_erreur' => 7
        ); // Refus du changement de mot de passe. Veuillez réitérer votre demande.
        $Code_utilisateur = substr($token, LNG_TOKEN);
        $filename_new_pwd = $this->dossier_new_pwd . 'new_pwd_' . $Code_utilisateur;
        if (file_exists($filename_new_pwd)) // si la session existe
        {
            $new_pwd = unserialize(file_get_contents($filename_new_pwd));
            if ($new_pwd['token'] == $token && $this->ip_autorise() && datetime_ajouter_time($new_pwd['date'], '00:30:00') > get_now()) {
                if ($this->mf_tester_existance_Code_utilisateur($Code_utilisateur)) {
                    $r = $this->mf_modifier_3(array(
                        $Code_utilisateur => array(
                            'utilisateur_Password' => $utilisateur_Password
                        )
                    ));
                }
            }
            unlink($filename_new_pwd);
        }
        return $r;
    }

    function deconnexion(string $token)
    {
        $Code_utilisateur = round(substr($token, LNG_TOKEN));
        $utilisateur = $this->mf_get_connexion($Code_utilisateur, array(
            'autocompletion' => false
        ));
        if (isset($utilisateur['Code_utilisateur'])) {
            $filename_session = "{$this->dossier_sessions}session_{$Code_utilisateur}";
            if (file_exists($filename_session)) // si la session existe
            {
                Hook_mf_systeme::script_deconnexion($Code_utilisateur);
                unlink($filename_session);
            }
            global $utilisateur_courant;
            $utilisateur_courant = null;
        }
    }

    function changer_mot_de_passe(int $Code_utilisateur, string $utilisateur_Password_old, string $utilisateur_Password_new, string $utilisateur_Password_verif): array
    {
        $code_erreur = 3; // Echec de modification de mot de passe
        $Code_utilisateur = round($Code_utilisateur);
        $utilisateur = $this->mf_get_connexion($Code_utilisateur, array(
            'autocompletion' => false
        ));
        if (isset($utilisateur['Code_utilisateur'])) {
            $salt = substr($utilisateur['utilisateur_Password'], strrpos($utilisateur['utilisateur_Password'], ':') + 1);
            $utilisateur_Password_old = md5($utilisateur_Password_old . $salt) . ':' . $salt;
            if ($utilisateur_Password_old == $utilisateur['utilisateur_Password']) {
                if ($utilisateur_Password_new == $utilisateur_Password_verif) {
                    $retour = $this->mf_modifier_2(array(
                        $Code_utilisateur => array(
                            'utilisateur_Password' => $utilisateur_Password_new
                        )
                    ));
                    $code_erreur = $retour['code_erreur'];
                }
            } else {
                sleep(1);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array(
            'code_erreur' => $code_erreur
        );
    }

    function forcer_mot_de_passe(int $Code_utilisateur, string $utilisateur_Password): array
    {
        global $mf_droits_defaut;
        return $this->mf_modifier_2(array(
            $Code_utilisateur => array(
                'utilisateur_Password' => $utilisateur_Password
            )
        ));
    }

    function raz_mot_de_passe_droit_admin(int $Code_utilisateur, string $utilisateur_Password): array
    {
        global $mf_droits_defaut;
        return $this->mf_modifier_3(array(
            $Code_utilisateur => array(
                'utilisateur_Password' => $utilisateur_Password
            )
        ));
    }

    function inscription(string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Password__verif, string $utilisateur_Email, string $utilisateur_Email__verif): array
    {
        $retour = [
            'code_erreur' => 0,
            'Code_utilisateur' => 0
        ];
        if ($utilisateur_Password != $utilisateur_Password__verif)
            $retour['code_erreur'] = 5;
        elseif ($utilisateur_Email != $utilisateur_Email__verif)
            $retour['code_erreur'] = 6;
        else {
            $retour = $this->mf_ajouter_2([
                'utilisateur_Identifiant' => $utilisateur_Identifiant,
                'utilisateur_Password' => $utilisateur_Password,
                'utilisateur_Email' => $utilisateur_Email
            ], true);
        }
        if ($retour['code_erreur'] != 0) {
            sleep(1);
        }
        return $retour;
    }

    function nb_sessions_actives()
    {
        $time = time();
        $i = 0;
        $files = glob($this->dossier_sessions . '*');
        foreach ($files as $file) {
            if ($time - filemtime($file) < 3600) {
                $i ++;
            }
        }
        return $i;
    }

    function rechercher_un_email(string $utilisateur_Email)
    {
        return $this->mf_search_utilisateur_Email($utilisateur_Email);
    }

    function connexion_par_id(string $Code_utilisateur)
    {
        if (! Hook_mf_systeme::autoriser_connexion($Code_utilisateur)) {
            sleep(1);
            return false;
        }
        if ($this->ip_autorise()) {
            $token = salt_minuscules(LNG_TOKEN) . $Code_utilisateur;
            $session = array(
                'Code_utilisateur' => $Code_utilisateur,
                'token' => $token,
                'date_connexion' => get_now(),
                'derniere_activite' => get_now(),
                'nb_requetes' => 1
            );
            $filename_session = $this->dossier_sessions . 'session_' . $Code_utilisateur;
            file_put_contents($filename_session, serialize($session));
            $this->est_connecte($token);
            Hook_mf_systeme::script_connexion($Code_utilisateur);
            return $token;
        }
        return false;
    }
}
