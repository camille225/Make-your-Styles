<?php

class Hook_utilisateur
{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$utilisateur_Identifiant, string &$utilisateur_Password, string &$utilisateur_Email, bool &$utilisateur_Administrateur, bool &$utilisateur_Developpeur, ?int $Code_utilisateur = null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['utilisateur__AJOUTER'] = false;
        $mf_droits_defaut['utilisateur__CREER'] = false; // actualisation uniquement pour l'affichage
        // Mise à jour des droits
        $db = new DB();
        if ($db->utilisateur()->mf_compter() == 0) {
            $mf_droits_defaut['utilisateur__AJOUTER'] = true;
        }
    }

    static function autorisation_ajout(string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Email, bool $utilisateur_Administrateur, bool $utilisateur_Developpeur)
    {
        return true;
    }

    static function data_controller(string &$utilisateur_Identifiant, string &$utilisateur_Password, string &$utilisateur_Email, bool &$utilisateur_Administrateur, bool &$utilisateur_Developpeur, ?int $Code_utilisateur = null)
    {
        // ici le code
    }

    static function calcul_signature(string $utilisateur_Identifiant, string $utilisateur_Email, bool $utilisateur_Administrateur, bool $utilisateur_Developpeur)
    {
        return md5($utilisateur_Identifiant . '-' . $utilisateur_Email . '-' . $utilisateur_Administrateur . '-' . $utilisateur_Developpeur);
    }

    static function calcul_cle_unique(string $utilisateur_Identifiant, string $utilisateur_Email, bool $utilisateur_Administrateur, bool $utilisateur_Developpeur)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($utilisateur_Identifiant . '.' . $utilisateur_Email . '.' . $utilisateur_Administrateur . '.' . $utilisateur_Developpeur);
    }

    static function ajouter(int $Code_utilisateur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['utilisateur__MODIFIER'] = false;
        $mf_droits_defaut['utilisateur__MODIFIER_PWD'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Identifiant'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Password'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Email'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Administrateur'] = false;
        $mf_droits_defaut['api_modifier__utilisateur_Developpeur'] = false;
        // Mise à jour des droits
        // ici le code
        $mf_droits_defaut['api_modifier__utilisateur_Email'] = true;
        $mf_droits_defaut['utilisateur__MODIFIER_PWD'] = true;
    }

    static function autorisation_modification(int $Code_utilisateur, string $utilisateur_Identifiant__new, string $utilisateur_Password__new, string $utilisateur_Email__new, bool $utilisateur_Administrateur__new, bool $utilisateur_Developpeur__new)
    {
        return true;
    }

    static function data_controller__utilisateur_Identifiant(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    static function data_controller__utilisateur_Email(string $old, string &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    static function data_controller__utilisateur_Administrateur(bool $old, bool &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    static function data_controller__utilisateur_Developpeur(bool $old, bool &$new, int $Code_utilisateur)
    {
        // ici le code
    }

    /*
     * modifier : $Code_utilisateur permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_utilisateur, bool $bool__utilisateur_Identifiant, bool $bool__utilisateur_Password, bool $bool__utilisateur_Email, bool $bool__utilisateur_Administrateur, bool $bool__utilisateur_Developpeur)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['utilisateur__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($Code_utilisateur != 0 && $mf_droits_defaut['utilisateur__SUPPRIMER']) {
            $table_commande = new commande();
            $mf_droits_defaut['utilisateur__SUPPRIMER'] = $table_commande->mfi_compter(array('Code_utilisateur'=>$Code_utilisateur))==0;
        }
    }

    static function autorisation_suppression(int $Code_utilisateur)
    {
        return true;
    }

    static function supprimer(array $copie__utilisateur)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_utilisateur)
    {
        foreach ($copie__liste_utilisateur as &$copie__utilisateur) {
            self::supprimer($copie__utilisateur);
        }
        unset($copie__utilisateur);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_utilisateur']
         * $donnees['utilisateur_Identifiant']
         * $donnees['utilisateur_Password']
         * $donnees['utilisateur_Email']
         * $donnees['utilisateur_Administrateur']
         * $donnees['utilisateur_Developpeur']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_utilisateur)
    {
        // ici le code
    }

    static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_utilisateur']
         * $donnees['utilisateur_Identifiant']
         * $donnees['utilisateur_Password']
         * $donnees['utilisateur_Email']
         * $donnees['utilisateur_Administrateur']
         * $donnees['utilisateur_Developpeur']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    static function callback_post(int $Code_utilisateur)
    {
        return null;
    }

    static function callback_put(int $Code_utilisateur)
    {
        return null;
    }
}
