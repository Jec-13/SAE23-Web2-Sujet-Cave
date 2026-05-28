<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Index Cave</title>
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
    <main class="connexion_rect">
        <h2 class="title_co">Veuillez vous connecter pour accèder au site :</h2>
        <article class="connexion_fields">
            <form id="form1" action="verif_login_POST.php" method="POST">
                <label for="id_mail">Adresse Mail : </label>
                <input class="id_mail" type="email" name="mail" id="id_mail" placeholder="@mail" required><br>

                <label for="id_pass">Mot de passe : </label>
                <input class="id_pass" type="password" name="mdp" id="id_pass" placeholder="Mot de passe" required><br>

                <input class="btn-dark" type="submit" name="btnco" value="Connection" />
            </form>
        </article>
    </main>
    <?php 
    
    ?>
</body>
</html>