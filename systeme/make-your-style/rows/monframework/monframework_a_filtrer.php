<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
 */

class monframework_a_filtrer
{

    // Key
    private $Code_utilisateur;
    private $Code_vue_utilisateur;

    /**
     * a_filtrer constructor.
     * @param int|null $Code_utilisateur
     * @param int|null $Code_vue_utilisateur
     */
    function __construct(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null)
    {
        if ($Code_utilisateur !== null && $Code_vue_utilisateur !== null) {
            $this->read_from_db($Code_utilisateur, $Code_vue_utilisateur);
        }
    }

    // Read
    public function read_from_db(int $Code_utilisateur, int $Code_vue_utilisateur): bool
    {
        $db = new DB();
        $a_filtrer = $db->a_filtrer()->mf_get_2($Code_utilisateur, $Code_vue_utilisateur);
        if (isset($a_filtrer['Code_utilisateur'])) {
            $this->Code_utilisateur = $a_filtrer['Code_utilisateur'];
            $this->Code_vue_utilisateur = $a_filtrer['Code_vue_utilisateur'];
            return true;
        } else {
            return false;
        }
    }


    // Getters & setters

    // Key
    // Code_utilisateur
    public function get_Code_utilisateur(): int { return $this->Code_utilisateur; }
    // Code_vue_utilisateur
    public function get_Code_vue_utilisateur(): int { return $this->Code_vue_utilisateur; }

}
