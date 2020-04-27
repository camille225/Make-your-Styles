<?php declare(strict_types=1);

include __DIR__ . '/../../systeme/make-your-style/espace_publique.php';

function mf_documentation_matrice_workflow(string $colonne)
{
    global $lang_standard, $mf_dictionnaire_db;
    // Activation de la fonction ?
    $activation = false;
    foreach ($lang_standard["{$colonne}_"] as $key_1 => $val_1) {
        foreach ($lang_standard["{$colonne}_"] as $key_2 => $val_2) {
            $ok = false;
            eval('$ok = in_array(' . $key_2 . ', Hook_' . $mf_dictionnaire_db[$colonne]['entite'] . '::workflow__' . $colonne . '(' . $key_1 . '));');
            if (! $ok) {
                $activation = true;
            }
        }
    }

    if ($activation) {
        echo '<hr>';
        echo '<div style="background-color: #ffffff;"><table class="table table-bordered" style="font-size: 0.85em;">';
        // première ligne
        echo '<tr>';
        echo '<td style="text-align: center; vertical-align: middle; font-weight: bold;">' . htmlspecialchars($colonne) . '</td>';
        foreach ($lang_standard["{$colonne}_"] as $val) {
            echo '<td style="text-align: center;">' . htmlspecialchars($val) . '</td>';
        }
        echo '</tr>';
        // les lignes suivantes
        foreach ($lang_standard["{$colonne}_"] as $key_1 => $val_1) {
            echo '<tr><td>' . htmlspecialchars($val_1) . '</td>';
            foreach ($lang_standard["{$colonne}_"] as $key_2 => $val_2) {
                if ($key_1 == $key_2) {
                    echo '<td style="background-color: #000000;"></td>';
                }
                else {
                    $ok = false;
                    eval('$ok = in_array(' . $key_2 . ', Hook_' . $mf_dictionnaire_db[$colonne]['entite'] . '::workflow__' . $colonne . '(' . $key_1 . '));');
                    if ($ok) {
                        echo '<td style="text-align: center; vertical-align: middle; background-color: lightgreen; color: black;">x</td>';
                    } else {
                        echo '<td></td>';
                    }
                }
            }
            echo '</tr>';
        }
        echo '</table></div>';
    }
}

function get_colonnes_autocompletees(string $table)
{
    global $lang_standard, $mf_dictionnaire_db;
    $lang_standard_tmp = $lang_standard;
    $lang_standard = [];
    eval('Hook_' . $table . '::initialisation();');
    foreach ($lang_standard as $nom_colonne => $libelle_langue) {
        $type = $mf_dictionnaire_db[$nom_colonne]['type'];
        echo '<tr scope="row" class="bg-info"><td>' . htmlspecialchars($libelle_langue) . '</td><td>' . $type . '</td><td><i class="small">AUTO</i></td><td><small>' . $nom_colonne . '</small></td></tr>';
    }
    $lang_standard = $lang_standard_tmp;
}

?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Dictionnaire d'information API</title>
<style>
    .table td { border-color: #B0B0B0; }
    .table .bg-primary th { color: black; }
</style>
</head>
<body style="background-color: #dddddd;">
<div class="jumbotron jumbotron-fluid">
<div class="container-fluid">
<h1 class="display-4">Dictionnaire des données du projet make-your-style</h1>
<p class="lead">Date : 24/04/2020 19:09:36</p>
</div>
</div>
<div class="container-fluid">
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "UTILISATEUR"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : utilisateur</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_utilisateur</small></th></tr>
<tr scope="row"><td>utilisateur_Identifiant</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Identifiant</small></td></tr>
<tr scope="row"><td>utilisateur_Password</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Password</small></td></tr>
<tr scope="row"><td>utilisateur_Email</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Email</small></td></tr>
<tr scope="row"><td>utilisateur_Civilite_Type</td><td>Nombre entier<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"]</span></td><td>1</td><td><small>utilisateur_Civilite_Type</small></td></tr>
<tr scope="row"><td>utilisateur_Prenom</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Prenom</small></td></tr>
<tr scope="row"><td>utilisateur_Nom</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Nom</small></td></tr>
<tr scope="row"><td>utilisateur_Adresse_1</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Adresse_1</small></td></tr>
<tr scope="row"><td>utilisateur_Adresse_2</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Adresse_2</small></td></tr>
<tr scope="row"><td>utilisateur_Ville</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Ville</small></td></tr>
<tr scope="row"><td>utilisateur_Code_postal</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>utilisateur_Code_postal</small></td></tr>
<tr scope="row"><td>utilisateur_Date_naissance</td><td>Date (sans l'heure)</td><td>''</td><td><small>utilisateur_Date_naissance</small></td></tr>
<tr scope="row"><td>utilisateur_Accepte_mail_publicitaire</td><td>Booléen (oui/non)<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Oui", 0 => "Non"]</span></td><td>0</td><td><small>utilisateur_Accepte_mail_publicitaire</small></td></tr>
<tr scope="row"><td>utilisateur_Administrateur</td><td>Booléen (oui/non)<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Oui", 0 => "Non"]</span></td><td>0</td><td><small>utilisateur_Administrateur</small></td></tr>
<tr scope="row"><td>utilisateur_Fournisseur</td><td>Booléen (oui/non)<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Oui", 0 => "Non"]</span></td><td>0</td><td><small>utilisateur_Fournisseur</small></td></tr>
<?php get_colonnes_autocompletees('utilisateur');?>
</tbody>
</table>
<?php mf_documentation_matrice_workflow('utilisateur_Civilite_Type');?>
<hr>
<ul>
<li>Nom des valeurs : {utilisateur_Identifiant}</li>
<li>Tri des données par défaut : ['utilisateur_Identifiant' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "ARTICLE"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : article</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_article</small></th></tr>
<tr scope="row"><td>article_Libelle</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Libelle</small></td></tr>
<tr scope="row"><td>article_Description</td><td>Texte sur plusieurs lignes</td><td>''</td><td><small>article_Description</small></td></tr>
<tr scope="row"><td>article_Saison_Type</td><td>Nombre entier<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"]</span></td><td>1</td><td><small>article_Saison_Type</small></td></tr>
<tr scope="row"><td>article_Nom_fournisseur</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Nom_fournisseur</small></td></tr>
<tr scope="row"><td>article_Url</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Url</small></td></tr>
<tr scope="row"><td>article_Reference</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Reference</small></td></tr>
<tr scope="row"><td>article_Couleur</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Couleur</small></td></tr>
<tr scope="row"><td>article_Code_couleur_svg</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Code_couleur_svg</small></td></tr>
<tr scope="row"><td>article_Taille_Pays_Type</td><td>Nombre entier<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"]</span></td><td>1</td><td><small>article_Taille_Pays_Type</small></td></tr>
<tr scope="row"><td>article_Taille</td><td>Nombre entier</td><td>null</td><td><small>article_Taille</small></td></tr>
<tr scope="row"><td>article_Matiere</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>article_Matiere</small></td></tr>
<tr scope="row"><td>article_Photo_Fichier</td><td>Fichier</td><td>''</td><td><small>article_Photo_Fichier</small></td></tr>
<tr scope="row"><td>article_Prix</td><td>FLOAT</td><td>null</td><td><small>article_Prix</small></td></tr>
<tr scope="row"><td>article_Actif</td><td>Booléen (oui/non)<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Oui", 0 => "Non"]</span></td><td>0</td><td><small>article_Actif</small></td></tr>
<tr scope="row" class="bg-warning" style="font-style: italic;"><td>Lien vers l'entité : SOUS_CATEGORIE_ARTICLE</td><td>Référence</td><td></td><td><small>Code_sous_categorie_article</small></td></tr>
<?php get_colonnes_autocompletees('article');?>
</tbody>
</table>
<?php mf_documentation_matrice_workflow('article_Saison_Type');?>
<?php mf_documentation_matrice_workflow('article_Taille_Pays_Type');?>
<hr>
<ul>
<li>Nom des valeurs : {article_Libelle}</li>
<li>Tri des données par défaut : ['article_Libelle' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "COMMANDE"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : commande</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_commande</small></th></tr>
<tr scope="row"><td>commande_Prix_total</td><td>FLOAT</td><td>null</td><td><small>commande_Prix_total</small></td></tr>
<tr scope="row"><td>commande_Date_livraison</td><td>Date (sans l'heure)</td><td>''</td><td><small>commande_Date_livraison</small></td></tr>
<tr scope="row"><td>commande_Date_creation</td><td>Date (sans l'heure)</td><td>''</td><td><small>commande_Date_creation</small></td></tr>
<tr scope="row" class="bg-warning" style="font-style: italic;"><td>Lien vers l'entité : UTILISATEUR</td><td>Référence</td><td></td><td><small>Code_utilisateur</small></td></tr>
<?php get_colonnes_autocompletees('commande');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {commande_Prix_total}</li>
<li>Tri des données par défaut : ['commande_Prix_total' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "CATEGORIE_ARTICLE"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : categorie_article</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_categorie_article</small></th></tr>
<tr scope="row"><td>categorie_article_Libelle</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>categorie_article_Libelle</small></td></tr>
<?php get_colonnes_autocompletees('categorie_article');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {categorie_article_Libelle}</li>
<li>Tri des données par défaut : ['categorie_article_Libelle' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "PARAMETRE"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : parametre</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_parametre</small></th></tr>
<tr scope="row"><td>parametre_Libelle</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>parametre_Libelle</small></td></tr>
<?php get_colonnes_autocompletees('parametre');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {parametre_Libelle}</li>
<li>Tri des données par défaut : ['parametre_Libelle' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "VUE_UTILISATEUR"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : vue_utilisateur</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_vue_utilisateur</small></th></tr>
<tr scope="row"><td>vue_utilisateur_Recherche</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>vue_utilisateur_Recherche</small></td></tr>
<tr scope="row"><td>vue_utilisateur_Filtre_Saison_Type</td><td>Nombre entier<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"]</span></td><td>1</td><td><small>vue_utilisateur_Filtre_Saison_Type</small></td></tr>
<tr scope="row"><td>vue_utilisateur_Filtre_Couleur</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>vue_utilisateur_Filtre_Couleur</small></td></tr>
<tr scope="row"><td>vue_utilisateur_Filtre_Taille_Pays_Type</td><td>Nombre entier<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"]</span></td><td>1</td><td><small>vue_utilisateur_Filtre_Taille_Pays_Type</small></td></tr>
<tr scope="row"><td>vue_utilisateur_Filtre_Taille_Max</td><td>Nombre entier</td><td>null</td><td><small>vue_utilisateur_Filtre_Taille_Max</small></td></tr>
<tr scope="row"><td>vue_utilisateur_Filtre_Taille_Min</td><td>Nombre entier</td><td>null</td><td><small>vue_utilisateur_Filtre_Taille_Min</small></td></tr>
<?php get_colonnes_autocompletees('vue_utilisateur');?>
</tbody>
</table>
<?php mf_documentation_matrice_workflow('vue_utilisateur_Filtre_Saison_Type');?>
<?php mf_documentation_matrice_workflow('vue_utilisateur_Filtre_Taille_Pays_Type');?>
<hr>
<ul>
<li>Nom des valeurs : {vue_utilisateur_Recherche}</li>
<li>Tri des données par défaut : ['vue_utilisateur_Recherche' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "SOUS_CATEGORIE_ARTICLE"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : sous_categorie_article</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_sous_categorie_article</small></th></tr>
<tr scope="row"><td>sous_categorie_article_Libelle</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>sous_categorie_article_Libelle</small></td></tr>
<tr scope="row" class="bg-warning" style="font-style: italic;"><td>Lien vers l'entité : CATEGORIE_ARTICLE</td><td>Référence</td><td></td><td><small>Code_categorie_article</small></td></tr>
<?php get_colonnes_autocompletees('sous_categorie_article');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {sous_categorie_article_Libelle}</li>
<li>Tri des données par défaut : ['sous_categorie_article_Libelle' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Entité "CONSEIL"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-primary" style="color: white;"><th style="width: 25%;">Identifiant : conseil</th><th style="width: 40%;">Entier naturel</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_conseil</small></th></tr>
<tr scope="row"><td>conseil_Libelle</td><td>Chaine jusqu'à 255 caractères</td><td>''</td><td><small>conseil_Libelle</small></td></tr>
<tr scope="row"><td>conseil_Description</td><td>Texte sur plusieurs lignes</td><td>''</td><td><small>conseil_Description</small></td></tr>
<tr scope="row"><td>conseil_Actif</td><td>Booléen (oui/non)<br><span style="font-size: 0.85em; font-style: italic;">[1 => "Oui", 0 => "Non"]</span></td><td>0</td><td><small>conseil_Actif</small></td></tr>
<?php get_colonnes_autocompletees('conseil');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {conseil_Libelle}</li>
<li>Tri des données par défaut : ['conseil_Libelle' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-secondary" role="alert">
<h4 class="alert-heading">Association "A_COMMANDE_ARTICLE"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-warning" style="font-style: italic;"><th style="width: 25%;">Lien vers l'entité : COMMANDE</th><th style="width: 40%;">Référence</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_commande</small></th></tr>
<tr scope="row" class="bg-warning" style="font-style: italic;"><th style="width: 25%;">Lien vers l'entité : ARTICLE</th><th style="width: 40%;">Référence</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_article</small></th></tr>
<tr scope="row"><td>a_commande_article_Quantite</td><td>Nombre entier</td><td>null</td><td><small>a_commande_article_Quantite</small></td></tr>
<tr scope="row"><td>a_commande_article_Prix_ligne</td><td>FLOAT</td><td>null</td><td><small>a_commande_article_Prix_ligne</small></td></tr>
<?php get_colonnes_autocompletees('a_commande_article');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {Code_commande} - {Code_article}</li>
<li>Tri des données par défaut : ['a_commande_article_Quantite' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-secondary" role="alert">
<h4 class="alert-heading">Association "A_PARAMETRE_UTILISATEUR"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-warning" style="font-style: italic;"><th style="width: 25%;">Lien vers l'entité : UTILISATEUR</th><th style="width: 40%;">Référence</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_utilisateur</small></th></tr>
<tr scope="row" class="bg-warning" style="font-style: italic;"><th style="width: 25%;">Lien vers l'entité : PARAMETRE</th><th style="width: 40%;">Référence</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_parametre</small></th></tr>
<tr scope="row"><td>a_parametre_utilisateur_Valeur</td><td>Nombre entier</td><td>null</td><td><small>a_parametre_utilisateur_Valeur</small></td></tr>
<tr scope="row"><td>a_parametre_utilisateur_Actif</td><td>Nombre entier</td><td>null</td><td><small>a_parametre_utilisateur_Actif</small></td></tr>
<?php get_colonnes_autocompletees('a_parametre_utilisateur');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {Code_utilisateur} - {Code_parametre}</li>
<li>Tri des données par défaut : ['a_parametre_utilisateur_Valeur' => 'ASC']</li>
</ul>
</div>

</div>
<div style="page-break-inside: avoid;">
<div class="alert alert-secondary" role="alert">
<h4 class="alert-heading">Association "A_FILTRER"</h4>
<hr>
<table class="table table-sm">
<thead><tr><th>Description</th><th>Type de donnée</th><th>Par défaut</th><th>Nom de la colonne (BD)</th></tr></thead>
<tbody>
<tr scope="row" class="bg-warning" style="font-style: italic;"><th style="width: 25%;">Lien vers l'entité : UTILISATEUR</th><th style="width: 40%;">Référence</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_utilisateur</small></th></tr>
<tr scope="row" class="bg-warning" style="font-style: italic;"><th style="width: 25%;">Lien vers l'entité : VUE_UTILISATEUR</th><th style="width: 40%;">Référence</th><th style="width: 10%;"></th><th style="width: 25%;"><small>Code_vue_utilisateur</small></th></tr>
<?php get_colonnes_autocompletees('a_filtrer');?>
</tbody>
</table>
<hr>
<ul>
<li>Nom des valeurs : {Code_utilisateur} - {Code_vue_utilisateur}</li>
<li>Tri des données par défaut : </li>
</ul>
</div>

</div>
<hr><footer><p>© My Framework 2020</p></footer>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
