<?php declare(strict_types=1);

class Hook_utilisateur
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(string &$utilisateur_Identifiant, string &$utilisateur_Password, string &$utilisateur_Email, ?int &$utilisateur_Civilite_Type, string &$utilisateur_Prenom, string &$utilisateur_Nom, string &$utilisateur_Adresse_1, string &$utilisateur_Adresse_2, string &$utilisateur_Ville, string &$utilisateur_Code_postal, string &$utilisateur_Date_naissance, bool &$utilisateur_Accepte_mail_publicitaire, bool &$utilisateur_Administrateur, bool &$utilisateur_Fournisseur, ?int $Code_utilisateur = null)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['utilisateur__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['utilisateur__CREER'] = false;
        // Mise à jour des droits
        $db = new DB();
        if ($db->utilisateur()->mf_compter() == 0 || est_administrateur()) {
            $mf_droits_defaut['utilisateur__AJOUTER'] = true;
        }
    }

    public static function autorisation_ajout(string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Email, ?int $utilisateur_Civilite_Type, string $utilisateur_Prenom, string $utilisateur_Nom, string $utilisateur_Adresse_1, string $utilisateur_Adresse_2, string $utilisateur_Ville, string $utilisateur_Code_postal, string $utilisateur_Date_naissance, bool $utilisateur_Accepte_mail_publicitaire, bool $utilisateur_Administrateur, bool $utilisateur_Fournisseur)
    {
        return true;
    }

    public static function data_controller(string &$utilisateur_Identifiant, string &$utilisateur_Password, string &$utilisateur_Email, ?int &$utilisateur_Civilite_Type, string &$utilisateur_Prenom, string &$utilisateur_Nom, string &$utilisateur_Adresse_1, string &$utilisateur_Adresse_2, string &$utilisateur_Ville, string &$utilisateur_Code_postal, string &$utilisateur_Date_naissance, bool &$utilisateur_Accepte_mail_publicitaire, bool &$utilisateur_Administrateur, bool &$utilisateur_Fournisseur, ?int $Code_utilisateur = null)
    {
        // ici le code
    }

    public static function calcul_signature(string $utilisateur_Identifiant, string $utilisateur_Email, ?int $utilisateur_Civilite_Type, string $utilisateur_Prenom, string $utilisateur_Nom, string $utilisateur_Adresse_1, string $utilisateur_Adresse_2, string $utilisateur_Ville, string $utilisateur_Code_postal, string $utilisateur_Date_naissance, bool $utilisateur_Accepte_mail_publicitaire, bool $utilisateur_Administrateur, bool $utilisateur_Fournisseur): string
    {
        return md5("$utilisateur_Identifiant-$utilisateur_Email-$utilisateur_Civilite_Type-$utilisateur_Prenom-$utilisateur_Nom-$utilisateur_Adresse_1-$utilisateur_Adresse_2-$utilisateur_Ville-$utilisateur_Code_postal-$utilisateur_Date_naissance-$utilisateur_Accepte_mail_publicitaire-$utilisateur_Administrateur-$utilisateur_Fournisseur");
    }

    public static function calcul_cle_unique(string $utilisateur_Identifiant, string $utilisateur_Email, ?int $utilisateur_Civilite_Type, string $utilisateur_Prenom, string $utilisateur_Nom, string $utilisateur_Adresse_1, string $utilisateur_Adresse_2, string $utilisateur_Ville, string $utilisateur_Code_postal, string $utilisateur_Date_naissance, bool $utilisateur_Accepte_mail_publicitaire, bool $utilisateur_Administrateur, bool $utilisateur_Fournisseur): string
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1("$utilisateur_Identifiant-$utilisateur_Email-$utilisateur_Civilite_Type-$utilisateur_Prenom-$utilisateur_Nom-$utilisateur_Adresse_1-$utilisateur_Adresse_2-$utilisateur_Ville-$utilisateur_Code_postal-$utilisateur_Date_naissance-$utilisateur_Accepte_mail_publicitaire-$utilisateur_Administrateur-$utilisateur_Fournisseur");
    }

    public static function ajouter(int $Code_utilisateur)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['utilisateur__MODIFIER'] = false;
        $mf_droits_defaut['utilisateur__MODIFIER_PWD'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Identifiant'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Password'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Email'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Civilite_Type'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Prenom'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Nom'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Adresse_1'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Adresse_2'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Ville'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Code_postal'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Date_naissance'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Accepte_mail_publicitaire'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Administrateur'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Fournisseur'] = false;
        // Mise à jour des droits
        if (est_administrateur() && get_utilisateur_courant(MF_UTILISATEUR__ID) != $Code_utilisateur) {
            $mf_droits_defaut['api_modifier__utilisateur_Administrateur'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Fournisseur'] = true;
        }
        if (get_utilisateur_courant(MF_UTILISATEUR__ID) == $Code_utilisateur) {
            $mf_droits_defaut['utilisateur__MODIFIER_PWD'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Identifiant'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Email'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Prenom'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Nom'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Adresse_1'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Adresse_2'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Ville'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Code_postal'] = true;
            $mf_droits_defaut['api_modifier__utilisateur_Accepte_mail_publicitaire'] = true;
        }
    }

    public static function autorisation_modification(int $Code_utilisateur, string $utilisateur_Identifiant__new, string $utilisateur_Password__new, string $utilisateur_Email__new, ?int $utilisateur_Civilite_Type__new, string $utilisateur_Prenom__new, string $utilisateur_Nom__new, string $utilisateur_Adresse_1__new, string $utilisateur_Adresse_2__new, string $utilisateur_Ville__new, string $utilisateur_Code_postal__new, string $utilisateur_Date_naissance__new, bool $utilisateur_Accepte_mail_publicitaire__new, bool $utilisateur_Administrateur__new, bool $utilisateur_Fournisseur__new)
    {
        return true;
    }

    /**
     * A partir de la valeur $utilisateur_Civilite_Type, liste des états autorisés
     * Cette opéraion est effectuée en ammont.
     * @param int $utilisateur_Civilite_Type
     * @return array
     */
    public static function workflow__utilisateur_Civilite_Type(int $utilisateur_Civilite_Type): array
    {
        // Par défaut, l'ensemble des choix sont permi
        global $lang_standard;
        return lister_cles($lang_standard['utilisateur_Civilite_Type_']);
    }

    public static function data_controller__utilisateur_Identifiant(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Email(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Civilite_Type(?int $old, ?int &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Prenom(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Nom(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Adresse_1(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Adresse_2(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Ville(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Code_postal(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Date_naissance(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Accepte_mail_publicitaire(bool $old, bool &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Administrateur(bool $old, bool &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    public static function data_controller__utilisateur_Fournisseur(bool $old, bool &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_utilisateur permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_utilisateur, bool $bool__utilisateur_Identifiant, bool $bool__utilisateur_Password, bool $bool__utilisateur_Email, bool $bool__utilisateur_Civilite_Type, bool $bool__utilisateur_Prenom, bool $bool__utilisateur_Nom, bool $bool__utilisateur_Adresse_1, bool $bool__utilisateur_Adresse_2, bool $bool__utilisateur_Ville, bool $bool__utilisateur_Code_postal, bool $bool__utilisateur_Date_naissance, bool $bool__utilisateur_Accepte_mail_publicitaire, bool $bool__utilisateur_Administrateur, bool $bool__utilisateur_Fournisseur)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['utilisateur__SUPPRIMER'] = false;
        // Mise à jour des droits
        if (est_administrateur() && get_utilisateur_courant(MF_UTILISATEUR__ID) != $Code_utilisateur) {
            $mf_droits_defaut['utilisateur__SUPPRIMER'] = true;
        }
        if ($Code_utilisateur != 0 && $mf_droits_defaut['utilisateur__SUPPRIMER']) {
            $db = new DB();
            $mf_droits_defaut['utilisateur__SUPPRIMER'] = $db->commande()->mfi_compter(['Code_utilisateur' => $Code_utilisateur]) == 0;
        }
    }

    public static function autorisation_suppression(int $Code_utilisateur)
    {
        return true;
    }

    public static function supprimer(array $copie__utilisateur)
    {
        // ici le code
    }

    public static function supprimer_2(array $copie__liste_utilisateur)
    {
        foreach ($copie__liste_utilisateur as &$copie__utilisateur) {
            self::supprimer($copie__utilisateur);
        }
        unset($copie__utilisateur);
    }

    public static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_utilisateur']
         * $donnees['utilisateur_Identifiant']
         * $donnees['utilisateur_Password']
         * $donnees['utilisateur_Email']
         * $donnees['utilisateur_Civilite_Type']
         * $donnees['utilisateur_Prenom']
         * $donnees['utilisateur_Nom']
         * $donnees['utilisateur_Adresse_1']
         * $donnees['utilisateur_Adresse_2']
         * $donnees['utilisateur_Ville']
         * $donnees['utilisateur_Code_postal']
         * $donnees['utilisateur_Date_naissance']
         * $donnees['utilisateur_Accepte_mail_publicitaire']
         * $donnees['utilisateur_Administrateur']
         * $donnees['utilisateur_Fournisseur']
         */
        return true;
    }

    public static function mettre_a_jour(array $liste_utilisateur)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_utilisateur']
         * $donnees['utilisateur_Identifiant']
         * $donnees['utilisateur_Password']
         * $donnees['utilisateur_Email']
         * $donnees['utilisateur_Civilite_Type']
         * $donnees['utilisateur_Prenom']
         * $donnees['utilisateur_Nom']
         * $donnees['utilisateur_Adresse_1']
         * $donnees['utilisateur_Adresse_2']
         * $donnees['utilisateur_Ville']
         * $donnees['utilisateur_Code_postal']
         * $donnees['utilisateur_Date_naissance']
         * $donnees['utilisateur_Accepte_mail_publicitaire']
         * $donnees['utilisateur_Administrateur']
         * $donnees['utilisateur_Fournisseur']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_utilisateur)
    {
        return null;
    }

    public static function callback_put(int $Code_utilisateur)
    {
        return null;
    }
}
