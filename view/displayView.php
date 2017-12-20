
	<a href=".?controller=user&action=creation"><button>Créer un nouvel utilisateur</button></a>
<?php 
createForm();
createTable($data); 
if(!is_null($detailsId)){
	createDetails($details);
}


function createForm(){
	echo '<form action="." method="GET">';
	echo '<label>Filtrer par:</label>';
	echo '<input type="hidden" name="controller" value="user">';
	echo '<input type="hidden" name="action" value="display">';
	echo '<input type="text" name="rechGroupe" placeholder="Nom de groupe">';
	echo '<input type="text" name="rechNom" placeholder="Nom d\'utilisateur">';
	echo '<input type="submit" value="Valider">';
	echo '<a href="."><button type="button" class="cancel">Annuler</button></a>';
	echo '</form>';
}

function createTable($data){
	echo '<table>';
	echo '<thead>';
	echo '<th>Groupe</th><th>Utilisateur</th><th>Email</th>';
	echo '</thead>';
	foreach($data as $value){
		echo '<tr>';
		echo '<td>'.$value['g_nom'].'</td><td>'.strtoupper($value['u_nom']).' '.$value['u_prenom'].'</td><td>'.$value['u_email'].'</td>';
		echo '<td><a href=".?controller=user&action=display&details='.$value['u_id'].'"><button>Détails</button></a></td>';
		echo '</tr>';
	}
	echo '</table>';
}

function createDetails($details){
	echo '<div class="details">';
	echo '<p>Nom : '.$details['u_nom'].'</p>';
	echo '<p>Prenom : '.$details['u_prenom'].'</p>';
	echo '<p>Age : '.$details['age'].' ans</p>';
	echo '<a href="." title="Fermer"><p>&#x2327</p></a>';
	echo '</div>';
}