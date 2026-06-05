<?php
function header_page($nom){
    ?>
    <header>
    <div class='header_page'>
    <?php
    $role = $_SESSION['ADMIN'] ? 'ADMIN' : 'USER';
    echo "<h1 class='Cave_Name'>Bienvenue Chez Lucas !</h1>";
    echo "<h1 class='email_title'>Connecter en tant que : ".$_SESSION['EMAIL']."</h1>";
    echo "<h2 class='page_title'>Sur la page : ".$nom."</h2>";
    echo "<p class='role_title'>Votre profile est ".$role."</p>";
    ?>
    <p><a class="btn-deconnexion" href='INCLUDE/deco.php'>se déconecter</a></p>
    </div>
    <?php
}

function menu_page(){
    
    ?>
    <div class='menu_page'>
    <ul class="liste_Page">
    <li  class='liste_Page' ><a class="btn-menu" href='index.php'>Page principale</a></li>
    <?php 
    if ($_SESSION['ADMIN']){
        echo "<li class='liste_Page' ><a class='btn-menu' href='Insertion.php'>Page d'insertion</a></li>";
        echo "<li class='liste_Page' ><a class='btn-menu' href='Modification.php'>Page de modification</a></li>";
        echo "<li class='liste_Page' ><a class='btn-menu' href='Suppression.php'>Page de suppression</a></li>";
        echo "<li class='liste_Page' ><a class='btn-menu' href='Mohamed.php'>Page de Mohamed</a></li>";
    }
    ?>
    </ul>
    </div>
    </header>
    <?php
}
?>