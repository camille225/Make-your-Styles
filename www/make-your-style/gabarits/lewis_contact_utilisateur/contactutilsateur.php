<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{titre_page}</title>

    <link href="template/docs/css/app.css" rel="stylesheet">

    <!--     <link rel="stylesheet" href="css/style.css"> -->
    
    <link rel="stylesheet" href="css/contactutilisateur.css">

    {css}

</head>

<body>
         <h1>Nous contacter</h1>
            <p class="desciptionarea">Nous vous répondrons avec plaisir et dans les plus brefs délais </p>
            <form method="POST">
                <div>
                    <input type =text name = nom placeholder ="nom(s)" required/>

                    <input type =text name = prenoms placeholder ="prénom(s)" required/><br/>
                </div>
                
                <input type =email id="email "name = "email" placeholder ="Email" required/><br/>

                <select name="motif" id="motif">
                    <option value="motif" selected disabled>Motif du contact</option>
                    <option value="informations">Informations</option>
                    <option value="retour">Retour d'un ou plusieurs articles</option>
                    <option value="rembourselent">Remboursement</option>
                    <option value="autre">Autre</option>
                </select>
                <input type =text name = autre placeholder ="Si le motif du contact n'est pas présernt dans les choix, indiquez-le"/>

                <textarea id = "message" name= "message"  placeholder ="Votre message" required></textarea><br/>
                <input id="soumission" type = "submit" name="envoie" id="envoie" value = "Envoyer votre message"/>
                {msg-retour}
            </form>
    </body>

</html>
