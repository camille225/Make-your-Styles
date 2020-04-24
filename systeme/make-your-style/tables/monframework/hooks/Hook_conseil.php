<?php declare(strict_types=1);

class Hook_conseil
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(string &$conseil_Libelle, string &$conseil_Description, bool &$conseil_Actif, ?int $Code_conseil = null)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter()
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['conseil__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['conseil__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(string $conseil_Libelle, string $conseil_Description, bool $conseil_Actif)
    {
        return true;
    }

    public static function data_controller(string &$conseil_Libelle, string &$conseil_Description, bool &$conseil_Actif, ?int $Code_conseil = null)
    {
        // ici le code
    }

    public static function calcul_signature(string $conseil_Libelle, string $conseil_Description, bool $conseil_Actif): string
    {
        return md5("$conseil_Libelle-$conseil_Description-$conseil_Actif");
    }

    public static function calcul_cle_unique(string $conseil_Libelle, string $conseil_Description, bool $conseil_Actif): string
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return sha1("$conseil_Libelle-$conseil_Description-$conseil_Actif");
    }

    public static function ajouter(int $Code_conseil)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_conseil = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['conseil__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__conseil_Libelle'] = false;
        $mf_droits_defaut['api_modifier__conseil_Description'] = false;
        $mf_droits_defaut['api_modifier__conseil_Actif'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_modification(int $Code_conseil, string $conseil_Libelle__new, string $conseil_Description__new, bool $conseil_Actif__new)
    {
        return true;
    }

    public static function data_controller__conseil_Libelle(string $old, string &$new, int $Code_conseil)
    {
        // ici le code
    }

    public static function data_controller__conseil_Description(string $old, string &$new, int $Code_conseil)
    {
        // ici le code
    }

    public static function data_controller__conseil_Actif(bool $old, bool &$new, int $Code_conseil)
    {
        // ici le code
    }

    /*
     * modifier : $Code_conseil permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_conseil, bool $bool__conseil_Libelle, bool $bool__conseil_Description, bool $bool__conseil_Actif)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_conseil = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['conseil__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
    }

    public static function autorisation_suppression(int $Code_conseil)
    {
        return true;
    }

    public static function supprimer(array $copie__conseil)
    {
        // ici le code
    }

    public static function supprimer_2(array $copie__liste_conseil)
    {
        foreach ($copie__liste_conseil as &$copie__conseil) {
            self::supprimer($copie__conseil);
        }
        unset($copie__conseil);
    }

    public static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_conseil']
         * $donnees['conseil_Libelle']
         * $donnees['conseil_Description']
         * $donnees['conseil_Actif']
         */
        return true;
    }

    public static function mettre_a_jour(array $liste_conseil)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_conseil']
         * $donnees['conseil_Libelle']
         * $donnees['conseil_Description']
         * $donnees['conseil_Actif']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_conseil)
    {
        return null;
    }

    public static function callback_put(int $Code_conseil)
    {
        return null;
    }
}
