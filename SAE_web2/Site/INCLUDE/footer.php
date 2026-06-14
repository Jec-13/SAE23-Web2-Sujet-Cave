<?php
// fonction pour le footer des pages du site
function footer(){
    
    ?>
    <footer>
        <div class="main-footer">
            <p class="merci">Merci pour votre visite sur le site de la meilleure cave à vins "Chez Lucas" !</p>
            <div class="second-footer">
    <?php
    echo "<p class=ip>votre ip est : <b>".$_SERVER['REMOTE_ADDR']."</b></p>"; // récupération de l'adresse ip
    ?>
            <a class="btn-menu" href='index.php'>Page principale</a>
            </div>
        </div>
    </footer>
    <?php

}
?>