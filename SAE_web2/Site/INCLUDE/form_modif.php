<?php
include "capcha.php";
function from_modif($name){
    ?>
    <div id="tableau">
    <nav class="rect">
    <h3 class="title_co">Vous modifier l'élément : <?php echo $name["CRU"] ?> de <?php echo $name["NOM"] ?></h3>
    <div class="input_fields">
    <form id='form' method='POST' onsubmit='return false'>
            <div class='champ'>
                <?php
                echo "<label class='id' for='Nb_bouteilles'>Nombre de bouteilles en stock :</label>";
                echo "<input class='id' type='number' name='Nb_bouteilles' id='Nb_bouteilles' value='".$name["NB_BOUTEILLES"]."' required><br>";
                ?>
            </div>
            <?php
            $xt = rand(0,2);
            $yt = rand(0,2);

            echo '<table>';	

            for($x = 0 ; $x < 3 ; $x++){
                echo '<tr class="tr-c">';
                for($y = 0 ; $y < 3 ; $y++){
                    $img = create_img($xt, $yt, $x, $y);

                    echo "<td class='td-c'><input type='radio' name='case' value='$x$y'/>";
                    echo "<img id='img_golf' src='data:image/png;base64,$img' width='50'/>";
                    echo "</button></td>";
                }
                echo "</tr>\n";
            }
            echo '</table>';
            ?>
        <div class='champ'>
        <input class='btn' type='button' value='Changer' onclick='modifier(this.form, "<?php echo $name["NOM"] ?>", "<?php echo $name["CRU"] ?>", "<?php echo $xt.$yt ?>", "<?php echo $name["NB_BOUTEILLES"] ?>")' />
        <p id='erch' class='erch'> Le nombre doit être différents de celui actuelle</p>
        <p id='remp' class='remp'> Le chanmp doit être remplie !</p>
        <p id='ercap' class='ercap'> Le capcha doit être résolue !</p>
        </div>
    </form>
    </div>
    </nav>
    </div>
    <div id='resultat'></div>
    <?php
}
?>
