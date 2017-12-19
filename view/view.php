<!DOCTYPE html>
<html>
<head>
	<title>Test Technique Choosit</title>
	<meta charset="utf-8">

</head>
<body>
<?php createTable($data); ?>
</body>
</html>

<?php

function createTable($data){
	echo '<table>';
	echo '<thead>';
	echo '<th>Groupe</th><th>Utilisateur</th><th>Email</th>';
	echo '</thead>';
	foreach($data as $value){
		echo '<tr>';
		echo '<td>'.$value['g_nom'].'</td><td>'.strtoupper($value['u_nom']).' '.$value['u_prenom'].'</td><td>'.$value['u_email'];
		echo '</tr>';
	}

}