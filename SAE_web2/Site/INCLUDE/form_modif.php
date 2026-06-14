<?php
include "capcha.php";
function from_modif($name){
    // $name est un tableau contenant les informations de l'élément choisi
    ?>
    <div id="tableau">
    <nav class="rect">
    <!-- affichage de l'élément modifié -->
    <h3 class="title_co">Vous modifiez l'élément : <?php echo $name["CRU"] ?> <?php echo $name["COULEUR"] ?> de <?php echo $name["NOM"] ?></h3>
    <div class="input_fields">
    <form id='form' method='POST' onsubmit='return false'>
            <div class='champ'>
                <?php
                 // demande à l'utilisateur de changer le nombre de bouteilles
                echo "<label class='id' for='Nb_bouteilles'>Nombre de bouteilles en stock :</label>";
                echo "<input class='id' type='number' name='Nb_bouteilles' id='Nb_bouteilles' value='".$name["NB_BOUTEILLES"]."' required><br>";
                ?>
            </div>
            <?php
            // affichage du captcha
            // choix de coordonnées aléatoires sur lesquelles se trouvera l'image avec le drapeau
            $xt = rand(0,2);
            $yt = rand(0,2);

            echo '<table>';	

            for($x = 0 ; $x < 3 ; $x++){
                echo '<tr class="tr-c">';
                for($y = 0 ; $y < 3 ; $y++){
                    // création de l'image dans un tableau
                    $img = create_img($xt, $yt, $x, $y);

                    // Utilisation d'un bouton radio pour pouvoir facilement récupérer la valeur choisie par l'utilisateur
                    echo "<td class='td-c'><input type='radio' name='case' value='$x$y'/>";
                    echo "<img id='img_golf' src='data:image/png;base64,$img' width='50'/>";
                    echo "</td>";
                }
                echo "</tr>\n";
            }
            echo '</table>';
            ?>
        <div class='champ'>
        <!-- Envoi du formulaire à fetch pour faire les vérifications -->
        <input class='btn' type='button' value='Changer' onclick='modifier(this.form, "<?php echo $name["NOM"] ?>", "<?php echo $name["CRU"] ?>", "<?php echo $xt.$yt ?>", "<?php echo $name["NB_BOUTEILLES"] ?>")' />
        <!-- Gestion des warnings sur une entrée de champ différente -->
        <p id='erch' class='erch'> Le nombre doit être différent de celui actuel</p>
        <p id='remp' class='remp'> Le champ doit être rempli</p>
        <p id='ercap' class='ercap'> Le captcha doit être résolu</p>
        <p id='succes' class='succes'> La modification a bien été faite !</p>
        </div>
    </form>
    </div>
    </nav>
    </div>
    <div id='resultat'></div>
    <?php
}
?>
