<?php
include 'INCLUDE/functions.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Index Cave</title>
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
<body>
    <main class="rect">
        <h2 class="title_co">Veuillez vous connecter pour accèder au site :</h2>
        <article class="input_fields">
            <form id="form1" method="POST" onsubmit="return isEmailValid(document.getElementById('id_mail').value)">
                <div class='champ'>
                <label class="id" for="id_mail">Adresse Mail : </label>
                <input class="id" type="text" name="mail" id="id_mail" placeholder="@mail" required><br>
                <p id="noemail" class="noemail"> Votre email n'existe pas</p>
                <p id="formatemail" class="formatemail"> Votre email n'a pas le bon format</p>
                </div>
                
                <div class='champ'>
                <label class="id" for="id_pass">Mot de passe : </label>
                <input class="id" type="password" name="pass" id="id_pass" placeholder="Mot de passe" required><br>
                <p id="nopass" class="nopass"> Le mot de pass est incorrecte</p>
                </div>
                
                <div class='champ'>
                <input class="btn" type="submit" name="btnco" value="Connection" />
                <p id="erch" class="erch"> Tout les champs doivent être remplie</p>
                </div>
            </form>
        </article>
    </main>
    <?php 
    session_start();

    $_SESSION["xt"] = -1;
    $_SESSION["yt"] = -1;

    if (!empty($_SESSION['EMAIL'])){
        header('Location: index.php');
        exit();
    }
    if (!empty($_POST)){
        if (isset($_POST["mail"]) && isset($_POST["pass"]) && $_POST["mail"]!="" && $_POST["pass"]!="")	{	

            $str = test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') == "ok" ? 'true' : 'false';
            $line = date('d/m/Y H:i:s').'|'.$_POST["mail"].'|'.$_POST["pass"].'|'.$_SERVER['REMOTE_ADDR'].'|'.$str."\n";
            
            file_put_contents('LOG/connexion.log', $line, FILE_APPEND);
            
            if ( test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') == "ok" ){
                $_SESSION['EMAIL'] = $_POST["mail"];
                if (is_admin($_SESSION['EMAIL'], 'BDD/comptes.sqlite')){
                    $_SESSION['ADMIN'] = true;
                }
                else{
                    $_SESSION['ADMIN'] = false;
                }
                header('Location: index.php');
                exit();
            }
            elseif (test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') == "nopass"){
                echo "<script>ChangeDisplay('nopass');</script>";
            }
            else {
                echo "<script>ChangeDisplay('noemail');</script>";
            }
        } else {
            echo "<script>ChangeDisplay('erch');</script>";
        }
    }
    ?>
</body>
</html>
