<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

if ($Code_utilisateur == 0 && $Code_commande != 0 && isset($table_commande)) $Code_utilisateur = $table_commande->mf_convertir_Code_commande_vers_Code_utilisateur($Code_commande);
if ($Code_type_produit == 0 && $Code_article != 0 && isset($table_article)) $Code_type_produit = $table_article->mf_convertir_Code_article_vers_Code_type_produit($Code_article);

$mf_contexte = array();
$mf_contexte['Code_utilisateur'] = $Code_utilisateur;
$mf_contexte['Code_article'] = $Code_article;
$mf_contexte['Code_commande'] = $Code_commande;
$mf_contexte['Code_type_produit'] = $Code_type_produit;
$mf_contexte['Code_parametre'] = $Code_parametre;
$mf_contexte['Code_filtre'] = $Code_filtre;
