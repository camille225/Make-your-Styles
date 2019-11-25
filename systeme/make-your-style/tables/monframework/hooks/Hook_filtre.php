<?php

class Hook_filtre
{

    static function initialisation() // première instanciation
    {
        // ici le code
    }

    static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    static function pre_controller(string &$filtre_Libelle, ?int $Code_filtre = null)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['filtre__AJOUTER'] = false;
        $mf_droits_defaut['filtre__CREER'] = false; // actualisation uniquement pour l'affichage
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_ajout(string $filtre_Libelle)
    {
        return true;
    }

    static function data_controller(string &$filtre_Libelle, ?int $Code_filtre = null)
    {
        // ici le code
    }

    static function calcul_signature(string $filtre_Libelle)
    {
        return md5($filtre_Libelle);
    }

    static function calcul_cle_unique(string $filtre_Libelle)
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1($filtre_Libelle);
    }

    static function ajouter(int $Code_filtre)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_modifier(?int $Code_filtre = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['filtre__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__filtre_Libelle'] = false;
        // Mise à jour des droits
        // ici le code
    }

    static function autorisation_modification(int $Code_filtre, string $filtre_Libelle__new)
    {
        return true;
    }

    static function data_controller__filtre_Libelle(string $old, string &$new, int $Code_filtre)
    {
        // ici le code
    }

    /*
     * modifier : $Code_filtre permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    static function modifier(int $Code_filtre, bool $bool__filtre_Libelle)
    {
        // ici le code
    }

    static function hook_actualiser_les_droits_supprimer(?int $Code_filtre = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['filtre__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
        if ($Code_filtre != 0 && $mf_droits_defaut['filtre__SUPPRIMER']) {
            // Ici le code
        }
    }

    static function autorisation_suppression(int $Code_filtre)
    {
        return true;
    }

    static function supprimer(array $copie__filtre)
    {
        // ici le code
    }

    static function supprimer_2(array $copie__liste_filtre)
    {
        foreach ($copie__liste_filtre as &$copie__filtre) {
            self::supprimer($copie__filtre);
        }
        unset($copie__filtre);
    }

    static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_filtre']
         * $donnees['filtre_Libelle']
         */
        return true;
    }

    static function mettre_a_jour(array $liste_filtre)
    {
        // ici le code
    }

    static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_filtre']
         * $donnees['filtre_Libelle']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    static function callback_post(int $Code_filtre)
    {
        return null;
    }

    static function callback_put(int $Code_filtre)
    {
        return null;
    }
}
