<?php
function create_img($xt, $yt, $x, $y){

    $fond = imagecreatefromjpeg('IMAGES/herbe.jpg'); // chargement de l'image d'herbe
    $golf = imagecreatefrompng('IMAGES/trou-golf.png'); // chargement de l'image du trou de golf (avec un fond transparent)

    imagealphablending($fond, true);// pour prendre en compte l'opacité

    if ($xt === $x && $yt === $y){ // afficher l'image du trou de golf si les coordonnées sont bonnes et avec des coordonnées aléatoires sur l'image
        imagecopy($fond, $golf, rand(0,500), rand(0,500), 0, 0, imagesx($golf), imagesy($golf));
    }

    ob_start();
    imagepng($fond); // création de la nouvelle image
    $imageData = ob_get_clean(); // récupération de l'image 
    $retour = base64_encode($imageData); // encodage de l'image pour ensuite pouvoir l'afficher dans une balise img

    return $retour;
}
?>