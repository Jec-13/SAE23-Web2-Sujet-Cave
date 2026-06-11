<?php
function create_img($xt, $yt, $x, $y){

    $fond = imagecreatefromjpeg('IMAGES/herbe.jpg');
    $golf = imagecreatefrompng('IMAGES/trou-golf.png');

    imagealphablending($fond, true);

    if ($xt === $x && $yt === $y){
        imagecopy($fond, $golf, 400, 300, 0, 0, imagesx($golf), imagesy($golf));
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
        echo '<tr>';
        for($y = 0 ; $y < 3 ; $y++){
            $img = create_img($xt, $yt, $x, $y);

            echo "<td><button type='submit' class='boutton_capcha' name='case' value='$x$y'>";
            echo "<img id='img_golf' src='data:image/png;base64,$img' width='50'/>";
            echo "</button></td>";
        }
        echo "</tr>\n";
    }
    echo '</table>';
}
function capcha(){
    $xt = rand(0,2);
    $yt = rand(0,2);

    ?>
    <form method='POST'>
    <label class="title_capcha">Faites un <b>ALL IN ONE</b></label>
    <?php
    affiche_golf($xt, $yt);
    ?>
    </form>
    <?php
    if (!empty($_POST) && isset($_POST['case'])){
        if ($_POST['case'] == $_SESSION["xt"].$_SESSION["yt"]){
            var_dump("gagner !");
        } else {
            var_dump("perdu");
        }
    }
    $_SESSION["xt"] = $xt;
    $_SESSION["yt"] = $yt;
}
?>