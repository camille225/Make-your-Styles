<?php declare(strict_types=1);

class Hook_commande
{

    public static function initialisation() // première instanciation
    {
        // ici le code
    }

    public static function actualisation() // à chaque instanciation
    {
        // ici le code
    }

    public static function pre_controller(?float &$commande_Prix_total, string &$commande_Date_livraison, string &$commande_Date_creation, int &$Code_utilisateur, ?int $Code_commande = null)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_ajouter(?int $Code_utilisateur = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['commande__AJOUTER'] = false;
        // actualisation uniquement pour l'affichage
        $mf_droits_defaut['commande__CREER'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_ajout(?float $commande_Prix_total, string $commande_Date_livraison, string $commande_Date_creation, int $Code_utilisateur)
    {
        return true;
    }

    public static function data_controller(?float &$commande_Prix_total, string &$commande_Date_livraison, string &$commande_Date_creation, int &$Code_utilisateur, ?int $Code_commande = null)
    {
        // ici le code
    }

    public static function calcul_signature(?float $commande_Prix_total, string $commande_Date_livraison, string $commande_Date_creation, int $Code_utilisateur): string
    {
        return md5("$commande_Prix_total-$commande_Date_livraison-$commande_Date_creation-$Code_utilisateur");
    }

    public static function calcul_cle_unique(?float $commande_Prix_total, string $commande_Date_livraison, string $commande_Date_creation, int $Code_utilisateur): string
    {
        // La méthode POST de l'API REST utilise cette fonction pour en déduire l'unicité de la données. Dans le cas contraire, la données est alors mise à jour
        // Attention au risque de collision
        return "$Code_utilisateur".sha1("$commande_Prix_total-$commande_Date_livraison-$commande_Date_creation");
    }

    public static function ajouter(int $Code_commande)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_modifier(?int $Code_commande = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['commande__MODIFIER'] = false;
        $mf_droits_defaut['api_modifier__commande_Prix_total'] = false;
        $mf_droits_defaut['api_modifier__commande_Date_livraison'] = false;
        $mf_droits_defaut['api_modifier__commande_Date_creation'] = false;
        $mf_droits_defaut['api_modifier_ref__commande__Code_utilisateur'] = false;
        // Mise à jour des droits
        // ici le code
    }

    public static function autorisation_modification(int $Code_commande, ?float $commande_Prix_total__new, string $commande_Date_livraison__new, string $commande_Date_creation__new, int $Code_utilisateur__new)
    {
        return true;
    }

    public static function data_controller__commande_Prix_total(?float $old, ?float &$new, int $Code_commande)
    {
        // ici le code
    }

    public static function data_controller__commande_Date_livraison(string $old, string &$new, int $Code_commande)
    {
        // ici le code
    }

    public static function data_controller__commande_Date_creation(string $old, string &$new, int $Code_commande)
    {
        // ici le code
    }

    public static function data_controller__Code_utilisateur(int $old, int &$new, int $Code_commande)
    {
        // ici le code
    }

    /*
     * modifier : $Code_commande permet de se référer à la données modifiée
     * les autres paramètres booléens ($modif...) permettent d'identifier les champs qui ont été modifiés
     */
    public static function modifier(int $Code_commande, bool $bool__commande_Prix_total, bool $bool__commande_Date_livraison, bool $bool__commande_Date_creation, bool $bool__Code_utilisateur)
    {
        // ici le code
    }

    public static function hook_actualiser_les_droits_supprimer(?int $Code_commande = null)
    {
        global $mf_droits_defaut;
        // Initialisation des droits
        $mf_droits_defaut['commande__SUPPRIMER'] = false;
        // Mise à jour des droits
        // Ici le code
    }

    public static function autorisation_suppression(int $Code_commande)
    {
        return true;
    }

    public static function supprimer(array $copie__commande)
    {
        // ici le code
    }

    public static function supprimer_2(array $copie__liste_commande)
    {
        foreach ($copie__liste_commande as &$copie__commande) {
            self::supprimer($copie__commande);
        }
        unset($copie__commande);
    }

    public static function est_a_jour(array &$donnees)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_commande']
         * $donnees['Code_utilisateur']
         * $donnees['commande_Prix_total']
         * $donnees['commande_Date_livraison']
         * $donnees['commande_Date_creation']
         */
        return true;
    }

    public static function mettre_a_jour(array $liste_commande)
    {
        // ici le code
    }

    public static function completion(array &$donnees, int $recursive_level)
    {
        /*
         * Balises disponibles :
         * $donnees['Code_commande']
         * $donnees['Code_utilisateur']
         * $donnees['commande_Prix_total']
         * $donnees['commande_Date_livraison']
         * $donnees['commande_Date_creation']
         */
        // ici le code
    }

    // API callbacks
    // -------------------
    public static function callback_post(int $Code_commande)
    {
        return null;
    }

    public static function callback_put(int $Code_commande)
    {
        return null;
    }
}
