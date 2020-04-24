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

Function utilisateur__ajouter(ByVal utilisateur_Identifiant As String, ByVal utilisateur_Password As String, ByVal utilisateur_Email As String, ByVal utilisateur_Civilite_Type As String, ByVal utilisateur_Prenom As String, ByVal utilisateur_Nom As String, ByVal utilisateur_Adresse_1 As String, ByVal utilisateur_Adresse_2 As String, ByVal utilisateur_Ville As String, ByVal utilisateur_Code_postal As String, ByVal utilisateur_Date_naissance As String, ByVal utilisateur_Accepte_mail_publicitaire As String, ByVal utilisateur_Administrateur As String, ByVal utilisateur_Fournisseur As String) As Long
    utilisateur_Identifiant = requete.convert_encode_url(utilisateur_Identifiant)
    utilisateur_Password = requete.convert_encode_url(utilisateur_Password)
    utilisateur_Email = requete.convert_encode_url(utilisateur_Email)
    utilisateur_Civilite_Type = requete.convert_encode_url(utilisateur_Civilite_Type)
    utilisateur_Prenom = requete.convert_encode_url(utilisateur_Prenom)
    utilisateur_Nom = requete.convert_encode_url(utilisateur_Nom)
    utilisateur_Adresse_1 = requete.convert_encode_url(utilisateur_Adresse_1)
    utilisateur_Adresse_2 = requete.convert_encode_url(utilisateur_Adresse_2)
    utilisateur_Ville = requete.convert_encode_url(utilisateur_Ville)
    utilisateur_Code_postal = requete.convert_encode_url(utilisateur_Code_postal)
    utilisateur_Date_naissance = requete.convert_encode_url(utilisateur_Date_naissance)
    utilisateur_Accepte_mail_publicitaire = requete.convert_encode_url(utilisateur_Accepte_mail_publicitaire)
    utilisateur_Administrateur = requete.convert_encode_url(utilisateur_Administrateur)
    utilisateur_Fournisseur = requete.convert_encode_url(utilisateur_Fournisseur)
    requete.requete_serveur "utilisateur/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&utilisateur_Identifiant=" & utilisateur_Identifiant & "&utilisateur_Password=" & utilisateur_Password & "&utilisateur_Email=" & utilisateur_Email & "&utilisateur_Civilite_Type=" & utilisateur_Civilite_Type & "&utilisateur_Prenom=" & utilisateur_Prenom & "&utilisateur_Nom=" & utilisateur_Nom & "&utilisateur_Adresse_1=" & utilisateur_Adresse_1 & "&utilisateur_Adresse_2=" & utilisateur_Adresse_2 & "&utilisateur_Ville=" & utilisateur_Ville & "&utilisateur_Code_postal=" & utilisateur_Code_postal & "&utilisateur_Date_naissance=" & utilisateur_Date_naissance & "&utilisateur_Accepte_mail_publicitaire=" & utilisateur_Accepte_mail_publicitaire & "&utilisateur_Administrateur=" & utilisateur_Administrateur & "&utilisateur_Fournisseur=" & utilisateur_Fournisseur
    utilisateur__ajouter = requete.retour_ok()
End Function

Function utilisateur__modifier(ByVal Code_utilisateur As String, ByVal utilisateur_Identifiant As String, ByVal utilisateur_Password As String, ByVal utilisateur_Email As String, ByVal utilisateur_Civilite_Type As String, ByVal utilisateur_Prenom As String, ByVal utilisateur_Nom As String, ByVal utilisateur_Adresse_1 As String, ByVal utilisateur_Adresse_2 As String, ByVal utilisateur_Ville As String, ByVal utilisateur_Code_postal As String, ByVal utilisateur_Date_naissance As String, ByVal utilisateur_Accepte_mail_publicitaire As String, ByVal utilisateur_Administrateur As String, ByVal utilisateur_Fournisseur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Identifiant = requete.convert_encode_url(utilisateur_Identifiant)
    utilisateur_Password = requete.convert_encode_url(utilisateur_Password)
    utilisateur_Email = requete.convert_encode_url(utilisateur_Email)
    utilisateur_Civilite_Type = requete.convert_encode_url(utilisateur_Civilite_Type)
    utilisateur_Prenom = requete.convert_encode_url(utilisateur_Prenom)
    utilisateur_Nom = requete.convert_encode_url(utilisateur_Nom)
    utilisateur_Adresse_1 = requete.convert_encode_url(utilisateur_Adresse_1)
    utilisateur_Adresse_2 = requete.convert_encode_url(utilisateur_Adresse_2)
    utilisateur_Ville = requete.convert_encode_url(utilisateur_Ville)
    utilisateur_Code_postal = requete.convert_encode_url(utilisateur_Code_postal)
    utilisateur_Date_naissance = requete.convert_encode_url(utilisateur_Date_naissance)
    utilisateur_Accepte_mail_publicitaire = requete.convert_encode_url(utilisateur_Accepte_mail_publicitaire)
    utilisateur_Administrateur = requete.convert_encode_url(utilisateur_Administrateur)
    utilisateur_Fournisseur = requete.convert_encode_url(utilisateur_Fournisseur)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Identifiant=" & utilisateur_Identifiant & "&utilisateur_Password=" & utilisateur_Password & "&utilisateur_Email=" & utilisateur_Email & "&utilisateur_Civilite_Type=" & utilisateur_Civilite_Type & "&utilisateur_Prenom=" & utilisateur_Prenom & "&utilisateur_Nom=" & utilisateur_Nom & "&utilisateur_Adresse_1=" & utilisateur_Adresse_1 & "&utilisateur_Adresse_2=" & utilisateur_Adresse_2 & "&utilisateur_Ville=" & utilisateur_Ville & "&utilisateur_Code_postal=" & utilisateur_Code_postal & "&utilisateur_Date_naissance=" & utilisateur_Date_naissance & "&utilisateur_Accepte_mail_publicitaire=" & utilisateur_Accepte_mail_publicitaire & "&utilisateur_Administrateur=" & utilisateur_Administrateur & "&utilisateur_Fournisseur=" & utilisateur_Fournisseur
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

Function utilisateur__modifier__utilisateur_Civilite_Type(ByVal Code_utilisateur As String, ByVal utilisateur_Civilite_Type As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Civilite_Type = requete.convert_encode_url(utilisateur_Civilite_Type)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Civilite_Type=" & utilisateur_Civilite_Type
    utilisateur__modifier__utilisateur_Civilite_Type = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Prenom(ByVal Code_utilisateur As String, ByVal utilisateur_Prenom As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Prenom = requete.convert_encode_url(utilisateur_Prenom)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Prenom=" & utilisateur_Prenom
    utilisateur__modifier__utilisateur_Prenom = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Nom(ByVal Code_utilisateur As String, ByVal utilisateur_Nom As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Nom = requete.convert_encode_url(utilisateur_Nom)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Nom=" & utilisateur_Nom
    utilisateur__modifier__utilisateur_Nom = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Adresse_1(ByVal Code_utilisateur As String, ByVal utilisateur_Adresse_1 As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Adresse_1 = requete.convert_encode_url(utilisateur_Adresse_1)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Adresse_1=" & utilisateur_Adresse_1
    utilisateur__modifier__utilisateur_Adresse_1 = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Adresse_2(ByVal Code_utilisateur As String, ByVal utilisateur_Adresse_2 As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Adresse_2 = requete.convert_encode_url(utilisateur_Adresse_2)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Adresse_2=" & utilisateur_Adresse_2
    utilisateur__modifier__utilisateur_Adresse_2 = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Ville(ByVal Code_utilisateur As String, ByVal utilisateur_Ville As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Ville = requete.convert_encode_url(utilisateur_Ville)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Ville=" & utilisateur_Ville
    utilisateur__modifier__utilisateur_Ville = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Code_postal(ByVal Code_utilisateur As String, ByVal utilisateur_Code_postal As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Code_postal = requete.convert_encode_url(utilisateur_Code_postal)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Code_postal=" & utilisateur_Code_postal
    utilisateur__modifier__utilisateur_Code_postal = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Date_naissance(ByVal Code_utilisateur As String, ByVal utilisateur_Date_naissance As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Date_naissance = requete.convert_encode_url(utilisateur_Date_naissance)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Date_naissance=" & utilisateur_Date_naissance
    utilisateur__modifier__utilisateur_Date_naissance = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Accepte_mail_publicitaire(ByVal Code_utilisateur As String, ByVal utilisateur_Accepte_mail_publicitaire As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Accepte_mail_publicitaire = requete.convert_encode_url(utilisateur_Accepte_mail_publicitaire)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Accepte_mail_publicitaire=" & utilisateur_Accepte_mail_publicitaire
    utilisateur__modifier__utilisateur_Accepte_mail_publicitaire = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Administrateur(ByVal Code_utilisateur As String, ByVal utilisateur_Administrateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Administrateur = requete.convert_encode_url(utilisateur_Administrateur)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Administrateur=" & utilisateur_Administrateur
    utilisateur__modifier__utilisateur_Administrateur = requete.retour_ok()
End Function

Function utilisateur__modifier__utilisateur_Fournisseur(ByVal Code_utilisateur As String, ByVal utilisateur_Fournisseur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    utilisateur_Fournisseur = requete.convert_encode_url(utilisateur_Fournisseur)
    requete.requete_serveur "utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&utilisateur_Fournisseur=" & utilisateur_Fournisseur
    utilisateur__modifier__utilisateur_Fournisseur = requete.retour_ok()
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

Function article__ajouter(ByVal Code_sous_categorie_article As String, ByVal article_Libelle As String, ByVal article_Description As String, ByVal article_Saison_Type As String, ByVal article_Nom_fournisseur As String, ByVal article_Url As String, ByVal article_Reference As String, ByVal article_Couleur As String, ByVal article_Code_couleur_svg As String, ByVal article_Taille_Pays_Type As String, ByVal article_Taille As String, ByVal article_Matiere As String, ByVal article_Photo_Fichier As String, ByVal article_Prix As String, ByVal article_Actif As String) As Long
    article_Libelle = requete.convert_encode_url(article_Libelle)
    article_Description = requete.convert_encode_url(article_Description)
    article_Saison_Type = requete.convert_encode_url(article_Saison_Type)
    article_Nom_fournisseur = requete.convert_encode_url(article_Nom_fournisseur)
    article_Url = requete.convert_encode_url(article_Url)
    article_Reference = requete.convert_encode_url(article_Reference)
    article_Couleur = requete.convert_encode_url(article_Couleur)
    article_Code_couleur_svg = requete.convert_encode_url(article_Code_couleur_svg)
    article_Taille_Pays_Type = requete.convert_encode_url(article_Taille_Pays_Type)
    article_Taille = requete.convert_encode_url(article_Taille)
    article_Matiere = requete.convert_encode_url(article_Matiere)
    article_Photo_Fichier = requete.convert_encode_url(article_Photo_Fichier)
    article_Prix = requete.convert_encode_url(article_Prix)
    article_Actif = requete.convert_encode_url(article_Actif)
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    requete.requete_serveur "article/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_sous_categorie_article=" & Code_sous_categorie_article & "&article_Libelle=" & article_Libelle & "&article_Description=" & article_Description & "&article_Saison_Type=" & article_Saison_Type & "&article_Nom_fournisseur=" & article_Nom_fournisseur & "&article_Url=" & article_Url & "&article_Reference=" & article_Reference & "&article_Couleur=" & article_Couleur & "&article_Code_couleur_svg=" & article_Code_couleur_svg & "&article_Taille_Pays_Type=" & article_Taille_Pays_Type & "&article_Taille=" & article_Taille & "&article_Matiere=" & article_Matiere & "&article_Photo_Fichier=" & article_Photo_Fichier & "&article_Prix=" & article_Prix & "&article_Actif=" & article_Actif
    article__ajouter = requete.retour_ok()
End Function

Function article__modifier(ByVal Code_article As String, ByVal Code_sous_categorie_article As String, ByVal article_Libelle As String, ByVal article_Description As String, ByVal article_Saison_Type As String, ByVal article_Nom_fournisseur As String, ByVal article_Url As String, ByVal article_Reference As String, ByVal article_Couleur As String, ByVal article_Code_couleur_svg As String, ByVal article_Taille_Pays_Type As String, ByVal article_Taille As String, ByVal article_Matiere As String, ByVal article_Photo_Fichier As String, ByVal article_Prix As String, ByVal article_Actif As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Libelle = requete.convert_encode_url(article_Libelle)
    article_Description = requete.convert_encode_url(article_Description)
    article_Saison_Type = requete.convert_encode_url(article_Saison_Type)
    article_Nom_fournisseur = requete.convert_encode_url(article_Nom_fournisseur)
    article_Url = requete.convert_encode_url(article_Url)
    article_Reference = requete.convert_encode_url(article_Reference)
    article_Couleur = requete.convert_encode_url(article_Couleur)
    article_Code_couleur_svg = requete.convert_encode_url(article_Code_couleur_svg)
    article_Taille_Pays_Type = requete.convert_encode_url(article_Taille_Pays_Type)
    article_Taille = requete.convert_encode_url(article_Taille)
    article_Matiere = requete.convert_encode_url(article_Matiere)
    article_Photo_Fichier = requete.convert_encode_url(article_Photo_Fichier)
    article_Prix = requete.convert_encode_url(article_Prix)
    article_Actif = requete.convert_encode_url(article_Actif)
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&Code_sous_categorie_article=" & Code_sous_categorie_article & "&article_Libelle=" & article_Libelle & "&article_Description=" & article_Description & "&article_Saison_Type=" & article_Saison_Type & "&article_Nom_fournisseur=" & article_Nom_fournisseur & "&article_Url=" & article_Url & "&article_Reference=" & article_Reference & "&article_Couleur=" & article_Couleur & "&article_Code_couleur_svg=" & article_Code_couleur_svg & "&article_Taille_Pays_Type=" & article_Taille_Pays_Type & "&article_Taille=" & article_Taille & "&article_Matiere=" & article_Matiere & "&article_Photo_Fichier=" & article_Photo_Fichier & "&article_Prix=" & article_Prix & "&article_Actif=" & article_Actif
    article__modifier = requete.retour_ok()
End Function

Function article__modifier__article_Libelle(ByVal Code_article As String, ByVal article_Libelle As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Libelle = requete.convert_encode_url(article_Libelle)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Libelle=" & article_Libelle
    article__modifier__article_Libelle = requete.retour_ok()
End Function

Function article__modifier__article_Description(ByVal Code_article As String, ByVal article_Description As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Description = requete.convert_encode_url(article_Description)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Description=" & article_Description
    article__modifier__article_Description = requete.retour_ok()
End Function

Function article__modifier__article_Saison_Type(ByVal Code_article As String, ByVal article_Saison_Type As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Saison_Type = requete.convert_encode_url(article_Saison_Type)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Saison_Type=" & article_Saison_Type
    article__modifier__article_Saison_Type = requete.retour_ok()
End Function

Function article__modifier__article_Nom_fournisseur(ByVal Code_article As String, ByVal article_Nom_fournisseur As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Nom_fournisseur = requete.convert_encode_url(article_Nom_fournisseur)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Nom_fournisseur=" & article_Nom_fournisseur
    article__modifier__article_Nom_fournisseur = requete.retour_ok()
End Function

Function article__modifier__article_Url(ByVal Code_article As String, ByVal article_Url As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Url = requete.convert_encode_url(article_Url)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Url=" & article_Url
    article__modifier__article_Url = requete.retour_ok()
End Function

Function article__modifier__article_Reference(ByVal Code_article As String, ByVal article_Reference As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Reference = requete.convert_encode_url(article_Reference)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Reference=" & article_Reference
    article__modifier__article_Reference = requete.retour_ok()
End Function

Function article__modifier__article_Couleur(ByVal Code_article As String, ByVal article_Couleur As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Couleur = requete.convert_encode_url(article_Couleur)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Couleur=" & article_Couleur
    article__modifier__article_Couleur = requete.retour_ok()
End Function

Function article__modifier__article_Code_couleur_svg(ByVal Code_article As String, ByVal article_Code_couleur_svg As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Code_couleur_svg = requete.convert_encode_url(article_Code_couleur_svg)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Code_couleur_svg=" & article_Code_couleur_svg
    article__modifier__article_Code_couleur_svg = requete.retour_ok()
End Function

Function article__modifier__article_Taille_Pays_Type(ByVal Code_article As String, ByVal article_Taille_Pays_Type As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Taille_Pays_Type = requete.convert_encode_url(article_Taille_Pays_Type)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Taille_Pays_Type=" & article_Taille_Pays_Type
    article__modifier__article_Taille_Pays_Type = requete.retour_ok()
End Function

Function article__modifier__article_Taille(ByVal Code_article As String, ByVal article_Taille As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Taille = requete.convert_encode_url(article_Taille)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Taille=" & article_Taille
    article__modifier__article_Taille = requete.retour_ok()
End Function

Function article__modifier__article_Matiere(ByVal Code_article As String, ByVal article_Matiere As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    article_Matiere = requete.convert_encode_url(article_Matiere)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&article_Matiere=" & article_Matiere
    article__modifier__article_Matiere = requete.retour_ok()
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

Function article__modifier__Code_sous_categorie_article(ByVal Code_article As String, ByVal Code_sous_categorie_article As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    requete.requete_serveur "article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article & "&Code_sous_categorie_article=" & Code_sous_categorie_article
    article__modifier__article_Libelle = requete.retour_ok()
End Function

Function article__supprimer(ByVal Code_article As String) As Long
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "article/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_article=" & Code_article
    article__supprimer = requete.retour_ok()
End Function

Function article__lister(ByVal Code_sous_categorie_article As String) As Long
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    requete.requete_serveur "article/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_sous_categorie_article=" & Code_sous_categorie_article
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

'   +-------------------+
'   | categorie_article |
'   +-------------------+

Function categorie_article__ajouter(ByVal categorie_article_Libelle As String) As Long
    categorie_article_Libelle = requete.convert_encode_url(categorie_article_Libelle)
    requete.requete_serveur "categorie_article/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&categorie_article_Libelle=" & categorie_article_Libelle
    categorie_article__ajouter = requete.retour_ok()
End Function

Function categorie_article__modifier(ByVal Code_categorie_article As String, ByVal categorie_article_Libelle As String) As Long
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    categorie_article_Libelle = requete.convert_encode_url(categorie_article_Libelle)
    requete.requete_serveur "categorie_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_categorie_article=" & Code_categorie_article & "&categorie_article_Libelle=" & categorie_article_Libelle
    categorie_article__modifier = requete.retour_ok()
End Function

Function categorie_article__modifier__categorie_article_Libelle(ByVal Code_categorie_article As String, ByVal categorie_article_Libelle As String) As Long
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    categorie_article_Libelle = requete.convert_encode_url(categorie_article_Libelle)
    requete.requete_serveur "categorie_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_categorie_article=" & Code_categorie_article & "&categorie_article_Libelle=" & categorie_article_Libelle
    categorie_article__modifier__categorie_article_Libelle = requete.retour_ok()
End Function

Function categorie_article__supprimer(ByVal Code_categorie_article As String) As Long
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    requete.requete_serveur "categorie_article/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_categorie_article=" & Code_categorie_article
    categorie_article__supprimer = requete.retour_ok()
End Function

Function categorie_article__lister() As Long
    requete.requete_serveur "categorie_article/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    categorie_article__lister = requete.retour_ok()
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

'   +-----------------+
'   | vue_utilisateur |
'   +-----------------+

Function vue_utilisateur__ajouter(ByVal vue_utilisateur_Recherche As String, ByVal vue_utilisateur_Filtre_Saison_Type As String, ByVal vue_utilisateur_Filtre_Couleur As String, ByVal vue_utilisateur_Filtre_Taille_Pays_Type As String, ByVal vue_utilisateur_Filtre_Taille_Max As String, ByVal vue_utilisateur_Filtre_Taille_Min As String) As Long
    vue_utilisateur_Recherche = requete.convert_encode_url(vue_utilisateur_Recherche)
    vue_utilisateur_Filtre_Saison_Type = requete.convert_encode_url(vue_utilisateur_Filtre_Saison_Type)
    vue_utilisateur_Filtre_Couleur = requete.convert_encode_url(vue_utilisateur_Filtre_Couleur)
    vue_utilisateur_Filtre_Taille_Pays_Type = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Pays_Type)
    vue_utilisateur_Filtre_Taille_Max = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Max)
    vue_utilisateur_Filtre_Taille_Min = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Min)
    requete.requete_serveur "vue_utilisateur/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&vue_utilisateur_Recherche=" & vue_utilisateur_Recherche & "&vue_utilisateur_Filtre_Saison_Type=" & vue_utilisateur_Filtre_Saison_Type & "&vue_utilisateur_Filtre_Couleur=" & vue_utilisateur_Filtre_Couleur & "&vue_utilisateur_Filtre_Taille_Pays_Type=" & vue_utilisateur_Filtre_Taille_Pays_Type & "&vue_utilisateur_Filtre_Taille_Max=" & vue_utilisateur_Filtre_Taille_Max & "&vue_utilisateur_Filtre_Taille_Min=" & vue_utilisateur_Filtre_Taille_Min
    vue_utilisateur__ajouter = requete.retour_ok()
End Function

Function vue_utilisateur__modifier(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Recherche As String, ByVal vue_utilisateur_Filtre_Saison_Type As String, ByVal vue_utilisateur_Filtre_Couleur As String, ByVal vue_utilisateur_Filtre_Taille_Pays_Type As String, ByVal vue_utilisateur_Filtre_Taille_Max As String, ByVal vue_utilisateur_Filtre_Taille_Min As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Recherche = requete.convert_encode_url(vue_utilisateur_Recherche)
    vue_utilisateur_Filtre_Saison_Type = requete.convert_encode_url(vue_utilisateur_Filtre_Saison_Type)
    vue_utilisateur_Filtre_Couleur = requete.convert_encode_url(vue_utilisateur_Filtre_Couleur)
    vue_utilisateur_Filtre_Taille_Pays_Type = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Pays_Type)
    vue_utilisateur_Filtre_Taille_Max = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Max)
    vue_utilisateur_Filtre_Taille_Min = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Min)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Recherche=" & vue_utilisateur_Recherche & "&vue_utilisateur_Filtre_Saison_Type=" & vue_utilisateur_Filtre_Saison_Type & "&vue_utilisateur_Filtre_Couleur=" & vue_utilisateur_Filtre_Couleur & "&vue_utilisateur_Filtre_Taille_Pays_Type=" & vue_utilisateur_Filtre_Taille_Pays_Type & "&vue_utilisateur_Filtre_Taille_Max=" & vue_utilisateur_Filtre_Taille_Max & "&vue_utilisateur_Filtre_Taille_Min=" & vue_utilisateur_Filtre_Taille_Min
    vue_utilisateur__modifier = requete.retour_ok()
End Function

Function vue_utilisateur__modifier__vue_utilisateur_Recherche(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Recherche As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Recherche = requete.convert_encode_url(vue_utilisateur_Recherche)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Recherche=" & vue_utilisateur_Recherche
    vue_utilisateur__modifier__vue_utilisateur_Recherche = requete.retour_ok()
End Function

Function vue_utilisateur__modifier__vue_utilisateur_Filtre_Saison_Type(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Filtre_Saison_Type As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Filtre_Saison_Type = requete.convert_encode_url(vue_utilisateur_Filtre_Saison_Type)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Filtre_Saison_Type=" & vue_utilisateur_Filtre_Saison_Type
    vue_utilisateur__modifier__vue_utilisateur_Filtre_Saison_Type = requete.retour_ok()
End Function

Function vue_utilisateur__modifier__vue_utilisateur_Filtre_Couleur(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Filtre_Couleur As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Filtre_Couleur = requete.convert_encode_url(vue_utilisateur_Filtre_Couleur)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Filtre_Couleur=" & vue_utilisateur_Filtre_Couleur
    vue_utilisateur__modifier__vue_utilisateur_Filtre_Couleur = requete.retour_ok()
End Function

Function vue_utilisateur__modifier__vue_utilisateur_Filtre_Taille_Pays_Type(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Filtre_Taille_Pays_Type As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Filtre_Taille_Pays_Type = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Pays_Type)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Filtre_Taille_Pays_Type=" & vue_utilisateur_Filtre_Taille_Pays_Type
    vue_utilisateur__modifier__vue_utilisateur_Filtre_Taille_Pays_Type = requete.retour_ok()
End Function

Function vue_utilisateur__modifier__vue_utilisateur_Filtre_Taille_Max(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Filtre_Taille_Max As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Filtre_Taille_Max = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Max)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Filtre_Taille_Max=" & vue_utilisateur_Filtre_Taille_Max
    vue_utilisateur__modifier__vue_utilisateur_Filtre_Taille_Max = requete.retour_ok()
End Function

Function vue_utilisateur__modifier__vue_utilisateur_Filtre_Taille_Min(ByVal Code_vue_utilisateur As String, ByVal vue_utilisateur_Filtre_Taille_Min As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    vue_utilisateur_Filtre_Taille_Min = requete.convert_encode_url(vue_utilisateur_Filtre_Taille_Min)
    requete.requete_serveur "vue_utilisateur/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur & "&vue_utilisateur_Filtre_Taille_Min=" & vue_utilisateur_Filtre_Taille_Min
    vue_utilisateur__modifier__vue_utilisateur_Filtre_Taille_Min = requete.retour_ok()
End Function

Function vue_utilisateur__supprimer(ByVal Code_vue_utilisateur As String) As Long
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    requete.requete_serveur "vue_utilisateur/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_vue_utilisateur=" & Code_vue_utilisateur
    vue_utilisateur__supprimer = requete.retour_ok()
End Function

Function vue_utilisateur__lister() As Long
    requete.requete_serveur "vue_utilisateur/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    vue_utilisateur__lister = requete.retour_ok()
End Function

'   +------------------------+
'   | sous_categorie_article |
'   +------------------------+

Function sous_categorie_article__ajouter(ByVal Code_categorie_article As String, ByVal sous_categorie_article_Libelle As String) As Long
    sous_categorie_article_Libelle = requete.convert_encode_url(sous_categorie_article_Libelle)
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    requete.requete_serveur "sous_categorie_article/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_categorie_article=" & Code_categorie_article & "&sous_categorie_article_Libelle=" & sous_categorie_article_Libelle
    sous_categorie_article__ajouter = requete.retour_ok()
End Function

Function sous_categorie_article__modifier(ByVal Code_sous_categorie_article As String, ByVal Code_categorie_article As String, ByVal sous_categorie_article_Libelle As String) As Long
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    sous_categorie_article_Libelle = requete.convert_encode_url(sous_categorie_article_Libelle)
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    requete.requete_serveur "sous_categorie_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_sous_categorie_article=" & Code_sous_categorie_article & "&Code_categorie_article=" & Code_categorie_article & "&sous_categorie_article_Libelle=" & sous_categorie_article_Libelle
    sous_categorie_article__modifier = requete.retour_ok()
End Function

Function sous_categorie_article__modifier__sous_categorie_article_Libelle(ByVal Code_sous_categorie_article As String, ByVal sous_categorie_article_Libelle As String) As Long
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    sous_categorie_article_Libelle = requete.convert_encode_url(sous_categorie_article_Libelle)
    requete.requete_serveur "sous_categorie_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_sous_categorie_article=" & Code_sous_categorie_article & "&sous_categorie_article_Libelle=" & sous_categorie_article_Libelle
    sous_categorie_article__modifier__sous_categorie_article_Libelle = requete.retour_ok()
End Function

Function sous_categorie_article__modifier__Code_categorie_article(ByVal Code_sous_categorie_article As String, ByVal Code_categorie_article As String) As Long
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    requete.requete_serveur "sous_categorie_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_sous_categorie_article=" & Code_sous_categorie_article & "&Code_categorie_article=" & Code_categorie_article
    sous_categorie_article__modifier__sous_categorie_article_Libelle = requete.retour_ok()
End Function

Function sous_categorie_article__supprimer(ByVal Code_sous_categorie_article As String) As Long
    Code_sous_categorie_article = requete.convert_encode_url(Code_sous_categorie_article)
    requete.requete_serveur "sous_categorie_article/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_sous_categorie_article=" & Code_sous_categorie_article
    sous_categorie_article__supprimer = requete.retour_ok()
End Function

Function sous_categorie_article__lister(ByVal Code_categorie_article As String) As Long
    Code_categorie_article = requete.convert_encode_url(Code_categorie_article)
    requete.requete_serveur "sous_categorie_article/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_categorie_article=" & Code_categorie_article
    sous_categorie_article__lister = requete.retour_ok()
End Function

'   +---------+
'   | conseil |
'   +---------+

Function conseil__ajouter(ByVal conseil_Libelle As String, ByVal conseil_Description As String, ByVal conseil_Actif As String) As Long
    conseil_Libelle = requete.convert_encode_url(conseil_Libelle)
    conseil_Description = requete.convert_encode_url(conseil_Description)
    conseil_Actif = requete.convert_encode_url(conseil_Actif)
    requete.requete_serveur "conseil/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&conseil_Libelle=" & conseil_Libelle & "&conseil_Description=" & conseil_Description & "&conseil_Actif=" & conseil_Actif
    conseil__ajouter = requete.retour_ok()
End Function

Function conseil__modifier(ByVal Code_conseil As String, ByVal conseil_Libelle As String, ByVal conseil_Description As String, ByVal conseil_Actif As String) As Long
    Code_conseil = requete.convert_encode_url(Code_conseil)
    conseil_Libelle = requete.convert_encode_url(conseil_Libelle)
    conseil_Description = requete.convert_encode_url(conseil_Description)
    conseil_Actif = requete.convert_encode_url(conseil_Actif)
    requete.requete_serveur "conseil/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_conseil=" & Code_conseil & "&conseil_Libelle=" & conseil_Libelle & "&conseil_Description=" & conseil_Description & "&conseil_Actif=" & conseil_Actif
    conseil__modifier = requete.retour_ok()
End Function

Function conseil__modifier__conseil_Libelle(ByVal Code_conseil As String, ByVal conseil_Libelle As String) As Long
    Code_conseil = requete.convert_encode_url(Code_conseil)
    conseil_Libelle = requete.convert_encode_url(conseil_Libelle)
    requete.requete_serveur "conseil/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_conseil=" & Code_conseil & "&conseil_Libelle=" & conseil_Libelle
    conseil__modifier__conseil_Libelle = requete.retour_ok()
End Function

Function conseil__modifier__conseil_Description(ByVal Code_conseil As String, ByVal conseil_Description As String) As Long
    Code_conseil = requete.convert_encode_url(Code_conseil)
    conseil_Description = requete.convert_encode_url(conseil_Description)
    requete.requete_serveur "conseil/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_conseil=" & Code_conseil & "&conseil_Description=" & conseil_Description
    conseil__modifier__conseil_Description = requete.retour_ok()
End Function

Function conseil__modifier__conseil_Actif(ByVal Code_conseil As String, ByVal conseil_Actif As String) As Long
    Code_conseil = requete.convert_encode_url(Code_conseil)
    conseil_Actif = requete.convert_encode_url(conseil_Actif)
    requete.requete_serveur "conseil/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_conseil=" & Code_conseil & "&conseil_Actif=" & conseil_Actif
    conseil__modifier__conseil_Actif = requete.retour_ok()
End Function

Function conseil__supprimer(ByVal Code_conseil As String) As Long
    Code_conseil = requete.convert_encode_url(Code_conseil)
    requete.requete_serveur "conseil/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_conseil=" & Code_conseil
    conseil__supprimer = requete.retour_ok()
End Function

Function conseil__lister() As Long
    requete.requete_serveur "conseil/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token
    conseil__lister = requete.retour_ok()
End Function

'   +--------------------+
'   | a_commande_article |
'   +--------------------+

Function a_commande_article__ajouter(ByVal Code_commande As String, ByVal Code_article As String, ByVal a_commande_article_Quantite As String, ByVal a_commande_article_Prix_ligne As String) As Long
    a_commande_article_Quantite = requete.convert_encode_url(a_commande_article_Quantite)
    a_commande_article_Prix_ligne = requete.convert_encode_url(a_commande_article_Prix_ligne)
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_commande_article/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article & "&a_commande_article_Quantite=" & a_commande_article_Quantite & "&a_commande_article_Prix_ligne=" & a_commande_article_Prix_ligne
    a_commande_article__ajouter = requete.retour_ok()
End Function

Function a_commande_article__modifier(ByVal Code_commande As String, ByVal Code_article As String, ByVal a_commande_article_Quantite As String, ByVal a_commande_article_Prix_ligne As String) As Long
    Code_a_commande_article = requete.convert_encode_url(Code_a_commande_article)
    a_commande_article_Quantite = requete.convert_encode_url(a_commande_article_Quantite)
    a_commande_article_Prix_ligne = requete.convert_encode_url(a_commande_article_Prix_ligne)
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_commande_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article & "&a_commande_article_Quantite=" & a_commande_article_Quantite & "&a_commande_article_Prix_ligne=" & a_commande_article_Prix_ligne
    a_commande_article__modifier = requete.retour_ok()
End Function

Function a_commande_article__modifier__a_commande_article_Quantite(ByVal Code_commande As String, ByVal Code_article As String, ByVal a_commande_article_Quantite As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    a_commande_article_Quantite = requete.convert_encode_url(a_commande_article_Quantite)
    requete.requete_serveur "a_commande_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article & "&a_commande_article_Quantite=" & a_commande_article_Quantite
    a_commande_article__modifier__a_commande_article_Quantite = requete.retour_ok()
End Function

Function a_commande_article__modifier__a_commande_article_Prix_ligne(ByVal Code_commande As String, ByVal Code_article As String, ByVal a_commande_article_Prix_ligne As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    a_commande_article_Prix_ligne = requete.convert_encode_url(a_commande_article_Prix_ligne)
    requete.requete_serveur "a_commande_article/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article & "&a_commande_article_Prix_ligne=" & a_commande_article_Prix_ligne
    a_commande_article__modifier__a_commande_article_Prix_ligne = requete.retour_ok()
End Function

Function a_commande_article__supprimer(ByVal Code_commande As String, ByVal Code_article As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_commande_article/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article
    a_commande_article__supprimer = requete.retour_ok()
End Function

Function a_commande_article__lister(ByVal Code_commande As String, ByVal Code_article As String) As Long
    Code_commande = requete.convert_encode_url(Code_commande)
    Code_article = requete.convert_encode_url(Code_article)
    requete.requete_serveur "a_commande_article/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_commande=" & Code_commande & "&Code_article=" & Code_article
    a_commande_article__lister = requete.retour_ok()
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

'   +-----------+
'   | a_filtrer |
'   +-----------+

Function a_filtrer__ajouter(ByVal Code_utilisateur As String, ByVal Code_vue_utilisateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    requete.requete_serveur "a_filtrer/ajouter.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_vue_utilisateur=" & Code_vue_utilisateur
    a_filtrer__ajouter = requete.retour_ok()
End Function

Function a_filtrer__modifier(ByVal Code_utilisateur As String, ByVal Code_vue_utilisateur As String) As Long
    Code_a_filtrer = requete.convert_encode_url(Code_a_filtrer)
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    requete.requete_serveur "a_filtrer/modifier.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_vue_utilisateur=" & Code_vue_utilisateur
    a_filtrer__modifier = requete.retour_ok()
End Function

Function a_filtrer__supprimer(ByVal Code_utilisateur As String, ByVal Code_vue_utilisateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    requete.requete_serveur "a_filtrer/supprimer.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_vue_utilisateur=" & Code_vue_utilisateur
    a_filtrer__supprimer = requete.retour_ok()
End Function

Function a_filtrer__lister(ByVal Code_utilisateur As String, ByVal Code_vue_utilisateur As String) As Long
    Code_utilisateur = requete.convert_encode_url(Code_utilisateur)
    Code_vue_utilisateur = requete.convert_encode_url(Code_vue_utilisateur)
    requete.requete_serveur "a_filtrer/lister.php?" & "vue=tableau" & "&mf_token=" & mf_token & "&Code_utilisateur=" & Code_utilisateur & "&Code_vue_utilisateur=" & Code_vue_utilisateur
    a_filtrer__lister = requete.retour_ok()
End Function

