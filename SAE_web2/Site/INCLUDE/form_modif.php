<?php
function from_modif($name, $path){
    ?>
    <nav class="rect">
    <h3 class="title_co">Vous modifier l'élément : <?php echo $name["CRU"] ?> de <?php echo $name["NOM"] ?></h3>
    <div class="input_fields">
    <form id='form1' method='POST' onsubmit="return isEmailValid(document.getElementById('id_mail').value)">
            <div class='champ'>
                <?php
                echo "<label class='id' for='Nb_bouteilles'>Nombre de bouteilles en stock :</label>";
                echo "<input class='id' type='number' name='Nb_bouteilles' id='Nb_bouteilles' value='".$name["NB_BOUTEILLES"]."' required><br>";
                ?>
            </div>
        <div class='champ'>
        <input class='btn' type='submit' name='btnco' value='Changer' />
        <p id='erch' class='erch'> Le nombre doit être différents de celui actuelle</p>
        </div>
    </form>
    </div>
    </nav>
    <?php
    if (isset($_POST['Nb_bouteilles'])){
        if ($_POST['Nb_bouteilles'] == $name["NB_BOUTEILLES"]){
            echo "<script>ChangeDisplay('erch');</script>";
        } else{
            modif_element($path, $_POST['Nb_bouteilles'], $name["CRU"], $name["NOM"]);
            afficheTableau(get_liste_vins($path));
        }
    }
    ?>
    <?php
}
?>