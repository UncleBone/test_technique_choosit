<?php
class groupe
{
	private $nom;

	public save(){
		$bdd = new BDD();
		$req = 'INSERT INTO groupe (g_nom) VALUES (:nom)';
		$param = [ 'nom' => $this->nom ];
		return $bdd->makeStatement($req,$param);
	}
}