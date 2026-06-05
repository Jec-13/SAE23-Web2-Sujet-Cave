<?php
function from_modif($name){
    
    ?>
    <nav class="rect">
    <h3 class="title_co">Vous modifier l'élément : <?php echo $name ?></h3>
    <div class="input_fields">
    <form id='form1' method='POST' onsubmit="return isEmailValid(document.getElementById('id_mail').value)">
            <div class='champ'>
            <label class='id' for='".$colonne."'></label>
            <input class='id' type='text' name='".$colonne."' id='".$colonne."' value='".$valeur."' required><br>
            </div>
        <div class='champ'>
        <input class='btn' type='submit' name='btnco' value='Changer' />
        <p id='erch' class='erch'> Tout les champs doivent être remplie</p>
        </div>
    </form>
    </div>
    </nav>
    <?php
    if (isset($_POST['noV'])){
        afficheTableau($tab);
    }
    ?>
    <?php
}
?>