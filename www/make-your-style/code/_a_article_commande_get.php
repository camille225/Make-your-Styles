<?php

    // Actualisation des droits
    Hook_a_article_commande::hook_actualiser_les_droits_supprimer();

    // boutons
        if ($mf_droits_defaut['a_article_commande__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_article_commande') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_article_commande&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'', 'lien', 'bouton_supprimer_a_article_commande');
        }
        $trans['{bouton_supprimer_a_article_commande}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_article_commande', BOUTON_CLASSE_SUPPRIMER) : '';

    /* prec_et_suiv */
    if ( $table_a_article_commande->mf_compter((isset($est_charge['commande']) ? $mf_contexte['Code_commande'] : 0), (isset($est_charge['article']) ? $mf_contexte['Code_article'] : 0))<100 )
    {
        $liste_a_article_commande = $table_a_article_commande->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_article_commande, $a_article_commande['Code_commande'].'-'.$a_article_commande['Code_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_commande']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_article_commande&Code_commande='.$prec_et_suiv['prec']['Code_commande'].'&Code_article='.$prec_et_suiv['prec']['Code_article'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_article_commande', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_commande']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_article_commande&Code_commande='.$prec_et_suiv['suiv']['Code_commande'].'&Code_article='.$prec_et_suiv['suiv']['Code_article'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_article_commande', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_article_commande}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_a_article_commande}'] = '';
    }

    /* Code_commande */
        $trans['{Code_commande}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_commande'=>$a_article_commande['Code_commande'], 'Code_article'=>$a_article_commande['Code_article']) , 'DB_name' => 'Code_commande' , 'valeur_initiale' => $a_article_commande['Code_commande'] ]);

    /* Code_article */
        $trans['{Code_article}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_commande'=>$a_article_commande['Code_commande'], 'Code_article'=>$a_article_commande['Code_article']) , 'DB_name' => 'Code_article' , 'valeur_initiale' => $a_article_commande['Code_article'] ]);

