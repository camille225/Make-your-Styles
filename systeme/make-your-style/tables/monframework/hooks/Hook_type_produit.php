<?php

class Hook_type_produit
{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$type_produit_Libelle, ?int $Code_type_produit = null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['type_produit__AJOUTER'] = false;
        $mf_droits_defaut['type_produit__CREER'] = false; // actualisation uniquement pour l'affichage
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_ajout(string $type_produit_Libelle)
    {
        return true;
    }

    static function data_controller(string &$type_produit_Libelle, ?int $Code_type_produit = null)
    {
        // ici le code
    }

    static function calcul_signature(string $type_produit_Libelle)
    {
        return md5($type_produit_Libelle);
    }

    static function calcul_cle_unique(string $type_produit_Libelle)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($type_produit_Libelle);
    }

    static function ajouter(int $Code_type_produit)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_type_produit = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['type_produit__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__type_produit_Libelle'] = false;
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_modification(int $Code_type_produit, string $type_produit_Libelle__new)
    {
        return true;
    }

    static function data_controller__type_produit_Libelle(string $old, string &$new, int $Code_type_produit)
    {
        // ici le code
    }

    /*
     * modifier : $Code_type_produit permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_type_produit, bool $bool__type_produit_Libelle)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_type_produit = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['type_produit__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($Code_type_produit != 0 && $mf_droits_defaut['type_produit__SUPPRIMER']) {
            $table_article = new article();
            $mf_droits_defaut['type_produit__SUPPRIMER'] = $table_article->mfi_compter(array('Code_type_produit'=>$Code_type_produit))==0;
        }
    }

    static function autorisation_suppression(int $Code_type_produit)
    {
        return true;
    }

    static function supprimer(array $copie__type_produit)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_type_produit)
    {
        foreach ($copie__liste_type_produit as &$copie__type_produit) {
            self::supprimer($copie__type_produit);
        }
        unset($copie__type_produit);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_type_produit']
         * $donnees['type_produit_Libelle']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_type_produit)
    {
        // ici le code
    }

    static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_type_produit']
         * $donnees['type_produit_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    static function callback_post(int $Code_type_produit)
    {
        return null;
    }

    static function callback_put(int $Code_type_produit)
    {
        return null;
    }
}
