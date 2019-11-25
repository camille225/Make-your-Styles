<?php

    // Actualisation des droits
    Hook_parametre::hook_actualiser_les_droits_ajouter();

    $table_parametre = new parametre();

    // liste
        $liste = $table_parametre->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_parametre");
        $tab->set_ligne_selectionnee('Code_parametre', mf_Code_parametre());
        $tab->modifier_code_action("apercu_parametre");
        $tab->ajouter_colonne('parametre_Libelle', false, '');
        $trans['{tableau_parametre}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['parametre__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_parametre') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_parametre', 'lien', 'bouton_ajouter_parametre');
        }
        $trans['{bouton_ajouter_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_parametre', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['parametre__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_parametre') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_parametre', 'lien', 'bouton_creer_parametre');
        }
        $trans['{bouton_creer_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_parametre', BOUTON_CLASSE_AJOUTER) : '';
