<?php
include 'INCLUDE/functions.php';
session_start(); // démarrage de la session utilisateur 

if (!empty($_SESSION['EMAIL'])){ // vérification que l'utilisateur n'est pas déjà connecté sinon on le redirige vers index.php
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Index Cave</title>
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
</head>
<body>
    <main class="rect">
        <h1 class="title_co">Veuillez vous connecter pour accèder au site :</h1>
        <article class="input_fields">
             <!-- formulaire qui vérifie dans le onsubmit que l'email est valide grâce à la fonction JavaScript -->
            <form id="form1" method="POST" onsubmit="return isEmailValid(document.getElementById('id_mail').value)">
                <div class='champ'>

                <!-- Demande de l'adresse email -->
                <label class="id" for="id_mail">Adresse Mail : </label>
                <input class="id" type="text" name="mail" id="id_mail" placeholder="@mail" required><br>
                <p id="noemail" class="noemail"> Votre email n'existe pas</p> <!-- message d'erreur quand l'email n'est pas présente dans la base -->
                <p id="formatemail" class="formatemail"> Votre email n'a pas le bon format</p> <!-- message d'erreur quand l'email n'est pas présent dans la base -->
                </div>

                <!-- Demande du mot de passe -->
                <div class='champ'>
                <label class="id" for="id_pass">Mot de passe : </label>
                <input class="id" type="password" name="pass" id="id_pass" placeholder="Mot de passe" required><br>
                <p id="nopass" class="nopass"> Le mot de passe est incorrect</p><!-- message d'erreur quand le mot de passe ne correspond pas à l'email-->
                </div>
                
                <div class='champ'>
                <input class="btn" type="submit" name="btnco" value="Connection" />
                <p id="erch" class="erch"> Tous les champs doivent être remplis</p><!-- message d'erreur si tous les champs ne sont pas remplis-->
                </div>
            </form>
        </article>
    </main>
    <?php 

    if (!empty($_POST)){ // vérification du chargement de $_POST
        if (isset($_POST["mail"]) && isset($_POST["pass"]) && $_POST["mail"]!="" && $_POST["pass"]!="")	{	
            
            // concaténation des données de connexion avec les tests pour les écrire dans le fichier de log
            $str = test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') == "ok" ? 'true' : 'false'; // si bien connecté true sinon false
            $line = date('d/m/Y H:i:s').'|'.$_POST["mail"].'|'.$_SERVER['REMOTE_ADDR'].'|'.$str."\n";
            file_put_contents('LOG/connexion.log', $line, FILE_APPEND); // écriture dans LOG/connexion.log
            
            // vérification de connexion
            if ( test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') == "ok" ){
                $_SESSION['EMAIL'] = $_POST["mail"]; // ajout de l'email dans la session utilisateur
                if (is_admin($_SESSION['EMAIL'], 'BDD/comptes.sqlite')){ // ajout du statut de l'utilisateur
                    $_SESSION['ADMIN'] = true; 
                }
                else{
                    $_SESSION['ADMIN'] = false;
                }
                header('Location: index.php');  // redirection de l'utilisateur vers index
                exit();
            }
            elseif (test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') == "nopass"){
                echo "<script>ChangeDisplay('nopass');</script>"; // affichage de l'erreur de mot de passe
            }
            else {
                echo "<script>ChangeDisplay('noemail');</script>"; // affichage de l'erreur si l'email n'existe pas
            }
        } else {
            echo "<script>ChangeDisplay('erch');</script>"; // affichage de l'erreur si tous les champs ne sont pas remplis
        }
    }
    ?>
</body>
</html>
