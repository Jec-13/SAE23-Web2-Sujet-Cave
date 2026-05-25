<?php
function FormulaireAuthentification() { // fourni
	?>
	<form id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset>
			<legend>Formulaire d'authentification</legend>
			<label for="id_mail">Adresse Mail : </label><input type="email" name="login" id="id_mail" placeholder="@mail" required size="20" /><br />
			<label for="id_pass">Mot de passe : </label><input type="password" name="pass" id="id_pass" required size="10" /><br />
			<input type="submit" name="connect" value="Connexion" />
		</fieldset>
	</form>
	<?php
}
?>
