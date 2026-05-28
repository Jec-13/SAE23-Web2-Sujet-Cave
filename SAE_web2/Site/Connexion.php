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
    <main class="connexion_rect">
        <h2 class="title_co">Veuillez vous connecter pour accèder au site :</h2>
        <article class="connexion_fields">
            <form id="form1" method="POST">
                <div class='champ'>
                <label class="id_mail" for="id_mail">Adresse Mail : </label>
                <input class="id_mail" type="email" name="mail" id="id_mail" placeholder="@mail" required><br>
                </div>
                
                <div class='champ'>
                <label class="id_pass" for="id_pass">Mot de passe : </label>
                <input class="id_pass" type="password" name="pass" id="id_pass" placeholder="Mot de passe" required><br>
                </div>
                
                <div class='champ'>
                <input class="btn" type="submit" name="btnco" value="Connection" />
                </div>
            </form>
        </article>
    </main>
    <?php 
    session_start();

    if (!empty($_SESSION['EMAIL'])){
        header('Location: index.php');
        exit();
    }

    if (!empty($_POST) && isset($_POST["mail"]) && isset($_POST["pass"]) && $_POST["mail"]!="" && $_POST["pass"]!="")	{	

        $str = test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') ? 'true' : 'false';
        $line = date('d/m/Y H:i:s').'|'.$_POST["mail"].'|'.$_POST["pass"].'|'.$_SERVER['REMOTE_ADDR'].'|'.$str;
        
        file_put_contents('LOG/connexion.log', $line, FILE_APPEND);
        
        if ( test_connexion($_POST["mail"],$_POST["pass"], 'BDD/comptes.sqlite') ){
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
	// fin else	
    }
    ?>
</body>
</html>
