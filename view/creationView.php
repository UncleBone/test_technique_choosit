<form id="creation" method="GET" action=".">
	<label>Créer un nouvel utilisateur</label>
	<input type="hidden" name="controller" value="user">
	<input type="hidden" name="action" value="traitementCreation">
	<input type="text" name="nom" placeholder="Nom">
	<input type="text" name="prenom" placeholder="Prénom">
	<input type="email" name="email" placeholder="Email">
	<label>Date de naissance:</label>
	<input type="date" name="date" placeholder="Date de naissance">
	<?php
	createSelectGroupe($groupes);
	?>
	<input type="submit" value="Valider">
</form>
<a id="retour" href="."><button type="button">Retour</button></a>

<?php
if(!empty($message)){
	echo '<div class="error">'.$message.'</div>';
}


function createSelectGroupe($groupes){
	echo '<select name="groupe">';
	foreach ($groupes as $groupe) {
		echo '<option value='.$groupe['g_id'].'>'.$groupe['g_nom'].'</option>';
	}
	echo '</select>';
}