<?php
// page de déconnexion qui supprime $_SESSION et redirige vers la page de connexion
session_start();
session_destroy(); 
header('Location: ../Connexion.php');
exit();
?>