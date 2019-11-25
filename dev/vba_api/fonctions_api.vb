Option Explicit

Dim mf_token As String

Function connexion(ByVal mf_login As String, ByVal mf_pwd As String) As Boolean
    requete.nettoyage
    mf_login = requete.convert_encode_url(mf_login)
    mf_pwd = requete.convert_encode_url(mf_pwd)
    requete.requete_serveur "connexion.php?mf_login=" & mf_login & "&mf_pwd=" & mf_pwd & "&vue=tableau"
    requete.vider_le_cache
    connexion = requete.retour_ok()
    If connexion Then
        mf_token = requete.Cells(2, 2)
    End If
End Function

Function deconnexion() As Boolean
    Code_utilisateur = parametres.get_Code_utilisateur
    utilisateur_cle_de_connexion = parametres.get_utilisateur_cle_de_connexion()
    requete.requete_serveur "deconnexion.php?mf_token=" & mf_token & "&vue=tableau"
    requete.vider_le_cache
    requete.nettoyage
End Function

'   +-------------+
'   | utilisateur |
'   +-------------+

Function utilisateur__ajouter(ByVal utilisateur_Identifiant As String, ByVal utilisateur_Password As String, ByVal utilisateur_Email As String, ByVal utilisateur_Administrateur As String, ByVal utilisateur_Developpeur As String) As Long
    utilisateur_Identifiant = requete.convert_encode_url(utilisateur_Identifiant)
    utilisateur_Password = requete.convert_encode_url(utilisateur_Password)
    utilisateur_Email = requete.convert_encode_url(utilisateur_Email)
    utilisateur_Administrateur = requete.convert_encode_url(utilisateur_Administrateur)
    utilisateur_Developpeur = requete.convert_encode_url(utilisateur_Developpeur)
    requete.requete_serveur "utilisateur/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&utilisateur_Identifiant=" & utilisateur_Identifiant & "&utilisateur_Password=" & utilisateur_Password & "&utilisateur_Email=" & utilisateur_Email & "&utilisateur_Administrateur=" & utilisateur_Administrateur & "&utilisateur_Developpeur=" & utilisateur_Developpeur
    utilisateur__ajouter = requete.retour_ok()
End Function

Function utilisateur__modifier(ByVal Code_utilisateur As String, ByVal utilisateur_Identifiant As String, ByVal utilisateur_Password As String, ByVal utilisateur_Email As String, ByVal utilisateur_Administrateur As String, ByVal utilisateur_Developpeur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Identifiant = requete.convert_encode_url(utilisateur_Identifiant)
    utilisateur_Password = requete.convert_encode_url(utilisateur_Password)
    utilisateur_Email = requete.convert_encode_url(utilisateur_Email)
    utilisateur_Administrateur = requete.convert_encode_url(utilisateur_Administrateur)
    utilisateur_Developpeur = requete.convert_encode_url(utilisateur_Developpeur)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Identifiant=" & utilisateur_Identifiant & "&utilisateur_Password=" & utilisateur_Password & "&utilisateur_Email=" & utilisateur_Email & "&utilisateur_Administrateur=" & utilisateur_Administrateur & "&utilisateur_Developpeur=" & utilisateur_Developpeur
    utilisateur__modifier = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Identifiant(ByVal Code_utilisateur As String, ByVal utilisateur_Identifiant As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Identifiant = requete.convert_encode_url(utilisateur_Identifiant)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Identifiant=" & utilisateur_Identifiant
    utilisateur__modifier__utilisateur_Identifiant = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Password(ByVal Code_utilisateur As String, ByVal utilisateur_Password As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Password = requete.convert_encode_url(utilisateur_Password)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Password=" & utilisateur_Password
    utilisateur__modifier__utilisateur_Password = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Email(ByVal Code_utilisateur As String, ByVal utilisateur_Email As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Email = requete.convert_encode_url(utilisateur_Email)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Email=" & utilisateur_Email
    utilisateur__modifier__utilisateur_Email = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Administrateur(ByVal Code_utilisateur As String, ByVal utilisateur_Administrateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Administrateur = requete.convert_encode_url(utilisateur_Administrateur)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Administrateur=" & utilisateur_Administrateur
    utilisateur__modifier__utilisateur_Administrateur = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Developpeur(ByVal Code_utilisateur As String, ByVal utilisateur_Developpeur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Developpeur = requete.convert_encode_url(utilisateur_Developpeur)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Developpeur=" & utilisateur_Developpeur
    utilisateur__modifier__utilisateur_Developpeur = requete.retour_ok()
End Function

Function utilisateur__supprimer(ByVal Code_utilisateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    requete.requete_serveur "utilisateur/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur
    utilisateur__supprimer = requete.retour_ok()
End Function

Function utilisateur__lister() As Long
    requete.requete_serveur "utilisateur/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    utilisateur__lister = requete.retour_ok()
End Function

'   +---------+
'   | article |
'   +---------+

Function article__ajouter(ByVal Code_type_produit As String, ByVal article_Libelle As String, ByVal article_Photo_Fichier As String, ByVal article_Prix As String, ByVal article_Actif As String) As Long
    article_Libelle = requete.convert_encode_url(article_Libelle)
    article_Photo_Fichier = requete.convert_encode_url(article_Photo_Fichier)
    article_Prix = requete.convert_encode_url(article_Prix)
    article_Actif = requete.convert_encode_url(article_Actif)
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    requete.requete_serveur "article/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type_produit=" & Code_type_produit & "&article_Libelle=" & article_Libelle & "&article_Photo_Fichier=" & article_Photo_Fichier & "&article_Prix=" & article_Prix & "&article_Actif=" & article_Actif
    article__ajouter = requete.retour_ok()
End Function

Function article__modifier(ByVal Code_article As String, ByVal Code_type_produit As String, ByVal article_Libelle As String, ByVal article_Photo_Fichier As String, ByVal article_Prix As String, ByVal article_Actif As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Libelle = requete.convert_encode_url(article_Libelle)
    article_Photo_Fichier = requete.convert_encode_url(article_Photo_Fichier)
    article_Prix = requete.convert_encode_url(article_Prix)
    article_Actif = requete.convert_encode_url(article_Actif)
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&Code_type_produit=" & Code_type_produit & "&article_Libelle=" & article_Libelle & "&article_Photo_Fichier=" & article_Photo_Fichier & "&article_Prix=" & article_Prix & "&article_Actif=" & article_Actif
    article__modifier = requete.retour_ok()
End Function

Function article__modifier__article_Libelle(ByVal Code_article As String, ByVal article_Libelle As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Libelle = requete.convert_encode_url(article_Libelle)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Libelle=" & article_Libelle
    article__modifier__article_Libelle = requete.retour_ok()
End Function

Function article__modifier__article_Photo_Fichier(ByVal Code_article As String, ByVal article_Photo_Fichier As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Photo_Fichier = requete.convert_encode_url(article_Photo_Fichier)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Photo_Fichier=" & article_Photo_Fichier
    article__modifier__article_Photo_Fichier = requete.retour_ok()
End Function

Function article__modifier__article_Prix(ByVal Code_article As String, ByVal article_Prix As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Prix = requete.convert_encode_url(article_Prix)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Prix=" & article_Prix
    article__modifier__article_Prix = requete.retour_ok()
End Function

Function article__modifier__article_Actif(ByVal Code_article As String, ByVal article_Actif As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Actif = requete.convert_encode_url(article_Actif)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Actif=" & article_Actif
    article__modifier__article_Actif = requete.retour_ok()
End Function

Function article__modifier__Code_type_produit(ByVal Code_article As String, ByVal Code_type_produit As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&Code_type_produit=" & Code_type_produit
    article__modifier__article_Libelle = requete.retour_ok()
End Function

Function article__supprimer(ByVal Code_article As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "article/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article
    article__supprimer = requete.retour_ok()
End Function

Function article__lister(ByVal Code_type_produit As String) As Long
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    requete.requete_serveur "article/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type_produit=" & Code_type_produit
    article__lister = requete.retour_ok()
End Function

'   +----------+
'   | commande |
'   +----------+

Function commande__ajouter(ByVal Code_utilisateur As String, ByVal commande_Prix_total As String, ByVal commande_Date_livraison As String, ByVal commande_Date_creation As String) As Long
    commande_Prix_total = requete.convert_encode_url(commande_Prix_total)
    commande_Date_livraison = requete.convert_encode_url(commande_Date_livraison)
    commande_Date_creation = requete.convert_encode_url(commande_Date_creation)
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    requete.requete_serveur "commande/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&commande_Prix_total=" & commande_Prix_total & "&commande_Date_livraison=" & commande_Date_livraison & "&commande_Date_creation=" & commande_Date_creation
    commande__ajouter = requete.retour_ok()
End Function

Function commande__modifier(ByVal Code_commande As String, ByVal Code_utilisateur As String, ByVal commande_Prix_total As String, ByVal commande_Date_livraison As String, ByVal commande_Date_creation As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    commande_Prix_total = requete.convert_encode_url(commande_Prix_total)
    commande_Date_livraison = requete.convert_encode_url(commande_Date_livraison)
    commande_Date_creation = requete.convert_encode_url(commande_Date_creation)
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    requete.requete_serveur "commande/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_utilisateur=" & Code_utilisateur & "&commande_Prix_total=" & commande_Prix_total & "&commande_Date_livraison=" & commande_Date_livraison & "&commande_Date_creation=" & commande_Date_creation
    commande__modifier = requete.retour_ok()
End Function

Function commande__modifier__commande_Prix_total(ByVal Code_commande As String, ByVal commande_Prix_total As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    commande_Prix_total = requete.convert_encode_url(commande_Prix_total)
    requete.requete_serveur "commande/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&commande_Prix_total=" & commande_Prix_total
    commande__modifier__commande_Prix_total = requete.retour_ok()
End Function

Function commande__modifier__commande_Date_livraison(ByVal Code_commande As String, ByVal commande_Date_livraison As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    commande_Date_livraison = requete.convert_encode_url(commande_Date_livraison)
    requete.requete_serveur "commande/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&commande_Date_livraison=" & commande_Date_livraison
    commande__modifier__commande_Date_livraison = requete.retour_ok()
End Function

Function commande__modifier__commande_Date_creation(ByVal Code_commande As String, ByVal commande_Date_creation As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    commande_Date_creation = requete.convert_encode_url(commande_Date_creation)
    requete.requete_serveur "commande/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&commande_Date_creation=" & commande_Date_creation
    commande__modifier__commande_Date_creation = requete.retour_ok()
End Function

Function commande__modifier__Code_utilisateur(ByVal Code_commande As String, ByVal Code_utilisateur As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    requete.requete_serveur "commande/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_utilisateur=" & Code_utilisateur
    commande__modifier__commande_Prix_total = requete.retour_ok()
End Function

Function commande__supprimer(ByVal Code_commande As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    requete.requete_serveur "commande/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande
    commande__supprimer = requete.retour_ok()
End Function

Function commande__lister(ByVal Code_utilisateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    requete.requete_serveur "commande/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur
    commande__lister = requete.retour_ok()
End Function

'   +--------------+
'   | type_produit |
'   +--------------+

Function type_produit__ajouter(ByVal type_produit_Libelle As String) As Long
    type_produit_Libelle = requete.convert_encode_url(type_produit_Libelle)
    requete.requete_serveur "type_produit/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&type_produit_Libelle=" & type_produit_Libelle
    type_produit__ajouter = requete.retour_ok()
End Function

Function type_produit__modifier(ByVal Code_type_produit As String, ByVal type_produit_Libelle As String) As Long
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    type_produit_Libelle = requete.convert_encode_url(type_produit_Libelle)
    requete.requete_serveur "type_produit/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type_produit=" & Code_type_produit & "&type_produit_Libelle=" & type_produit_Libelle
    type_produit__modifier = requete.retour_ok()
End Function

Function type_produit__modifier__type_produit_Libelle(ByVal Code_type_produit As String, ByVal type_produit_Libelle As String) As Long
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    type_produit_Libelle = requete.convert_encode_url(type_produit_Libelle)
    requete.requete_serveur "type_produit/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type_produit=" & Code_type_produit & "&type_produit_Libelle=" & type_produit_Libelle
    type_produit__modifier__type_produit_Libelle = requete.retour_ok()
End Function

Function type_produit__supprimer(ByVal Code_type_produit As String) As Long
    Code_type_produit = requete.convert_encode_url(Code_type_produit)
    requete.requete_serveur "type_produit/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_type_produit=" & Code_type_produit
    type_produit__supprimer = requete.retour_ok()
End Function

Function type_produit__lister() As Long
    requete.requete_serveur "type_produit/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    type_produit__lister = requete.retour_ok()
End Function

'   +-----------+
'   | parametre |
'   +-----------+

Function parametre__ajouter(ByVal parametre_Libelle As String) As Long
    parametre_Libelle = requete.convert_encode_url(parametre_Libelle)
    requete.requete_serveur "parametre/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&parametre_Libelle=" & parametre_Libelle
    parametre__ajouter = requete.retour_ok()
End Function

Function parametre__modifier(ByVal Code_parametre As String, ByVal parametre_Libelle As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Libelle = requete.convert_encode_url(parametre_Libelle)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Libelle=" & parametre_Libelle
    parametre__modifier = requete.retour_ok()
End Function

Function parametre__modifier__parametre_Libelle(ByVal Code_parametre As String, ByVal parametre_Libelle As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    parametre_Libelle = requete.convert_encode_url(parametre_Libelle)
    requete.requete_serveur "parametre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre & "&parametre_Libelle=" & parametre_Libelle
    parametre__modifier__parametre_Libelle = requete.retour_ok()
End Function

Function parametre__supprimer(ByVal Code_parametre As String) As Long
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "parametre/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_parametre=" & Code_parametre
    parametre__supprimer = requete.retour_ok()
End Function

Function parametre__lister() As Long
    requete.requete_serveur "parametre/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    parametre__lister = requete.retour_ok()
End Function

'   +--------+
'   | filtre |
'   +--------+

Function filtre__ajouter(ByVal filtre_Libelle As String) As Long
    filtre_Libelle = requete.convert_encode_url(filtre_Libelle)
    requete.requete_serveur "filtre/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&filtre_Libelle=" & filtre_Libelle
    filtre__ajouter = requete.retour_ok()
End Function

Function filtre__modifier(ByVal Code_filtre As String, ByVal filtre_Libelle As String) As Long
    Code_filtre = requete.convert_encode_url(Code_filtre)
    filtre_Libelle = requete.convert_encode_url(filtre_Libelle)
    requete.requete_serveur "filtre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&filtre_Libelle=" & filtre_Libelle
    filtre__modifier = requete.retour_ok()
End Function

Function filtre__modifier__filtre_Libelle(ByVal Code_filtre As String, ByVal filtre_Libelle As String) As Long
    Code_filtre = requete.convert_encode_url(Code_filtre)
    filtre_Libelle = requete.convert_encode_url(filtre_Libelle)
    requete.requete_serveur "filtre/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&filtre_Libelle=" & filtre_Libelle
    filtre__modifier__filtre_Libelle = requete.retour_ok()
End Function

Function filtre__supprimer(ByVal Code_filtre As String) As Long
    Code_filtre = requete.convert_encode_url(Code_filtre)
    requete.requete_serveur "filtre/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre
    filtre__supprimer = requete.retour_ok()
End Function

Function filtre__lister() As Long
    requete.requete_serveur "filtre/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    filtre__lister = requete.retour_ok()
End Function

'   +--------------------+
'   | a_article_commande |
'   +--------------------+

Function a_article_commande__ajouter(ByVal Code_commande As String, ByVal Code_article As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_article_commande/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article
    a_article_commande__ajouter = requete.retour_ok()
End Function

Function a_article_commande__modifier(ByVal Code_commande As String, ByVal Code_article As String) As Long
    Code_a_article_commande = requete.convert_encode_url(Code_a_article_commande)
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_article_commande/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article
    a_article_commande__modifier = requete.retour_ok()
End Function

Function a_article_commande__supprimer(ByVal Code_commande As String, ByVal Code_article As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_article_commande/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article
    a_article_commande__supprimer = requete.retour_ok()
End Function

Function a_article_commande__lister(ByVal Code_commande As String, ByVal Code_article As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_article_commande/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article
    a_article_commande__lister = requete.retour_ok()
End Function

'   +------------------+
'   | a_filtre_produit |
'   +------------------+

Function a_filtre_produit__ajouter(ByVal Code_filtre As String, ByVal Code_article As String, ByVal a_filtre_produit_Actif As String) As Long
    a_filtre_produit_Actif = requete.convert_encode_url(a_filtre_produit_Actif)
    Code_filtre = requete.convert_encode_url(Code_filtre)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_filtre_produit/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&Code_article=" & Code_article & "&a_filtre_produit_Actif=" & a_filtre_produit_Actif
    a_filtre_produit__ajouter = requete.retour_ok()
End Function

Function a_filtre_produit__modifier(ByVal Code_filtre As String, ByVal Code_article As String, ByVal a_filtre_produit_Actif As String) As Long
    Code_a_filtre_produit = requete.convert_encode_url(Code_a_filtre_produit)
    a_filtre_produit_Actif = requete.convert_encode_url(a_filtre_produit_Actif)
    Code_filtre = requete.convert_encode_url(Code_filtre)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_filtre_produit/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&Code_article=" & Code_article & "&a_filtre_produit_Actif=" & a_filtre_produit_Actif
    a_filtre_produit__modifier = requete.retour_ok()
End Function

Function a_filtre_produit__modifier__a_filtre_produit_Actif(ByVal Code_filtre As String, ByVal Code_article As String, ByVal a_filtre_produit_Actif As String) As Long
    Code_filtre = requete.convert_encode_url(Code_filtre)
    Code_article = requete.convert_encode_url(Code_article)
    a_filtre_produit_Actif = requete.convert_encode_url(a_filtre_produit_Actif)
    requete.requete_serveur "a_filtre_produit/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&Code_article=" & Code_article & "&a_filtre_produit_Actif=" & a_filtre_produit_Actif
    a_filtre_produit__modifier__a_filtre_produit_Actif = requete.retour_ok()
End Function

Function a_filtre_produit__supprimer(ByVal Code_filtre As String, ByVal Code_article As String) As Long
    Code_filtre = requete.convert_encode_url(Code_filtre)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_filtre_produit/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&Code_article=" & Code_article
    a_filtre_produit__supprimer = requete.retour_ok()
End Function

Function a_filtre_produit__lister(ByVal Code_filtre As String, ByVal Code_article As String) As Long
    Code_filtre = requete.convert_encode_url(Code_filtre)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_filtre_produit/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_filtre=" & Code_filtre & "&Code_article=" & Code_article
    a_filtre_produit__lister = requete.retour_ok()
End Function

'   +-------------------------+
'   | a_parametre_utilisateur |
'   +-------------------------+

Function a_parametre_utilisateur__ajouter(ByVal Code_utilisateur As String, ByVal Code_parametre As String, ByVal a_parametre_utilisateur_Valeur As String, ByVal a_parametre_utilisateur_Actif As String) As Long
    a_parametre_utilisateur_Valeur = requete.convert_encode_url(a_parametre_utilisateur_Valeur)
    a_parametre_utilisateur_Actif = requete.convert_encode_url(a_parametre_utilisateur_Actif)
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_parametre_utilisateur/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_parametre=" & Code_parametre & "&a_parametre_utilisateur_Valeur=" & a_parametre_utilisateur_Valeur & "&a_parametre_utilisateur_Actif=" & a_parametre_utilisateur_Actif
    a_parametre_utilisateur__ajouter = requete.retour_ok()
End Function

Function a_parametre_utilisateur__modifier(ByVal Code_utilisateur As String, ByVal Code_parametre As String, ByVal a_parametre_utilisateur_Valeur As String, ByVal a_parametre_utilisateur_Actif As String) As Long
    Code_a_parametre_utilisateur = requete.convert_encode_url(Code_a_parametre_utilisateur)
    a_parametre_utilisateur_Valeur = requete.convert_encode_url(a_parametre_utilisateur_Valeur)
    a_parametre_utilisateur_Actif = requete.convert_encode_url(a_parametre_utilisateur_Actif)
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_parametre_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_parametre=" & Code_parametre & "&a_parametre_utilisateur_Valeur=" & a_parametre_utilisateur_Valeur & "&a_parametre_utilisateur_Actif=" & a_parametre_utilisateur_Actif
    a_parametre_utilisateur__modifier = requete.retour_ok()
End Function

Function a_parametre_utilisateur__modifier__a_parametre_utilisateur_Valeur(ByVal Code_utilisateur As String, ByVal Code_parametre As String, ByVal a_parametre_utilisateur_Valeur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    a_parametre_utilisateur_Valeur = requete.convert_encode_url(a_parametre_utilisateur_Valeur)
    requete.requete_serveur "a_parametre_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_parametre=" & Code_parametre & "&a_parametre_utilisateur_Valeur=" & a_parametre_utilisateur_Valeur
    a_parametre_utilisateur__modifier__a_parametre_utilisateur_Valeur = requete.retour_ok()
End Function

Function a_parametre_utilisateur__modifier__a_parametre_utilisateur_Actif(ByVal Code_utilisateur As String, ByVal Code_parametre As String, ByVal a_parametre_utilisateur_Actif As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    a_parametre_utilisateur_Actif = requete.convert_encode_url(a_parametre_utilisateur_Actif)
    requete.requete_serveur "a_parametre_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_parametre=" & Code_parametre & "&a_parametre_utilisateur_Actif=" & a_parametre_utilisateur_Actif
    a_parametre_utilisateur__modifier__a_parametre_utilisateur_Actif = requete.retour_ok()
End Function

Function a_parametre_utilisateur__supprimer(ByVal Code_utilisateur As String, ByVal Code_parametre As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_parametre_utilisateur/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_parametre=" & Code_parametre
    a_parametre_utilisateur__supprimer = requete.retour_ok()
End Function

Function a_parametre_utilisateur__lister(ByVal Code_utilisateur As String, ByVal Code_parametre As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_parametre = requete.convert_encode_url(Code_parametre)
    requete.requete_serveur "a_parametre_utilisateur/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_parametre=" & Code_parametre
    a_parametre_utilisateur__lister = requete.retour_ok()
End Function

