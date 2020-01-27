<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{titre_page}</title>

    <link href="css/compte_utilisateur.css" rel="stylesheet">
    </head>
    <body>
        <div id="page">
            <div id="containeur">
                <section id="section1">
                    <h1>Informations</h1>
                    <form>
                        <label for="Nom"><input type="text" class="infos" name="nom" placeholder="Nom" /></label>
                        <label for="Prenom"><input type="text" class="infos" name="prenom" placeholder="Prénom" /></label>
                        <label for="Taille"><input type="text" class="infos" name="taille" placeholder="Taille" /></label>
                        <label for="Date"><input type="date" class="infos" name="date" placeholder="Date de naissance" /></label>
                        <label for="email"><input type="email" class="infos" name="email" placeholder="Email" /></label>
                        <label for="pass"><input type="password" class="infos" name="password" minlength="8" placeholder="Mot de passe" required></label>
                        <input type="button" value="Modifier" id="bouton"/>
                    </form>
                </section>
                <div id="separateur"></div>
                <section id="section2">
                    <img src="IMG/Logo_Make_Your_Style_2.png">
                    <h2>Question 1</h2>
                    <p>Réponse de la première question</p>
                    <h2>Question 2</h2>
                    <p>Réponse de la deuxième question</p>
                    <h2>Question 3</h2>
                    <p>Réponse de la troisième question</p>
                </section>
            </div>
        </div>
    </body>
</html>
