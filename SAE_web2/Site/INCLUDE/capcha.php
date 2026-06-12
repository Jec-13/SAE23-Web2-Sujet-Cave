<?php
function create_img($xt, $yt, $x, $y){

    $fond = imagecreatefromjpeg('IMAGES/herbe.jpg');
    $golf = imagecreatefrompng('IMAGES/trou-golf.png');

    imagealphablending($fond, true);

    if ($xt === $x && $yt === $y){
        imagecopy($fond, $golf, rand(0,500), rand(0,500), 0, 0, imagesx($golf), imagesy($golf));
    }

    ob_start();
    imagepng($fond);
    $imageData = ob_get_clean();
    $retour = base64_encode($imageData);

    return $retour;
}

function affiche_golf($xt, $yt){
    echo '<table>';	

    for($x = 0 ; $x < 3 ; $x++){
        echo '<tr class="tr-c">';
        for($y = 0 ; $y < 3 ; $y++){
            $img = create_img($xt, $yt, $x, $y);

            echo "<td class='td-c'><button id='case' type='button' class='boutton_capcha' name='case' value='$x$y'>";
            echo "<img id='img_golf' src='data:image/png;base64,$img' width='50'/>";
            echo "</button></td>";
        }
        echo "</tr>\n";
    }
    echo '</table>';
}

?>