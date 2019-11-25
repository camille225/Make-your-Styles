<?php

$mf_dictionnaire_db['Code_utilisateur']=array('type'=>'INT', 'entite'=>'utilisateur');
$mf_dictionnaire_db['utilisateur_Identifiant']=array('type'=>'VARCHAR', 'entite'=>'utilisateur');
$mf_dictionnaire_db['utilisateur_Password']=array('type'=>'PASSWORD', 'entite'=>'utilisateur');
$mf_dictionnaire_db['utilisateur_Email']=array('type'=>'VARCHAR', 'entite'=>'utilisateur');
$mf_dictionnaire_db['utilisateur_Administrateur']=array('type'=>'BOOL', 'entite'=>'utilisateur');
$mf_dictionnaire_db['utilisateur_Developpeur']=array('type'=>'BOOL', 'entite'=>'utilisateur');
$mf_dictionnaire_db['Code_article']=array('type'=>'INT', 'entite'=>'article');
$mf_dictionnaire_db['article_Libelle']=array('type'=>'VARCHAR', 'entite'=>'article');
$mf_dictionnaire_db['article_Photo_Fichier']=array('type'=>'VARCHAR', 'entite'=>'article');
$mf_dictionnaire_db['article_Prix']=array('type'=>'FLOAT', 'entite'=>'article');
$mf_dictionnaire_db['article_Actif']=array('type'=>'BOOL', 'entite'=>'article');
$mf_dictionnaire_db['Code_commande']=array('type'=>'INT', 'entite'=>'commande');
$mf_dictionnaire_db['commande_Prix_total']=array('type'=>'FLOAT', 'entite'=>'commande');
$mf_dictionnaire_db['commande_Date_livraison']=array('type'=>'DATE', 'entite'=>'commande');
$mf_dictionnaire_db['commande_Date_creation']=array('type'=>'DATE', 'entite'=>'commande');
$mf_dictionnaire_db['Code_type_produit']=array('type'=>'INT', 'entite'=>'type_produit');
$mf_dictionnaire_db['type_produit_Libelle']=array('type'=>'VARCHAR', 'entite'=>'type_produit');
$mf_dictionnaire_db['Code_parametre']=array('type'=>'INT', 'entite'=>'parametre');
$mf_dictionnaire_db['parametre_Libelle']=array('type'=>'VARCHAR', 'entite'=>'parametre');
$mf_dictionnaire_db['Code_filtre']=array('type'=>'INT', 'entite'=>'filtre');
$mf_dictionnaire_db['filtre_Libelle']=array('type'=>'VARCHAR', 'entite'=>'filtre');
$mf_dictionnaire_db['a_filtre_produit_Actif']=array('type'=>'INT', 'entite'=>'a_filtre_produit');
$mf_dictionnaire_db['a_parametre_utilisateur_Valeur']=array('type'=>'INT', 'entite'=>'a_parametre_utilisateur');
$mf_dictionnaire_db['a_parametre_utilisateur_Actif']=array('type'=>'INT', 'entite'=>'a_parametre_utilisateur');
