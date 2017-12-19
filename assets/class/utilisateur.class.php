<?php
class Utilisateur
{
	private $nom;
	private $prenom;
	private $email;
	private $dateAnniversaire;
	private $groupe;

	public save(){
		$bdd = new BDD();
		$req = 'INSERT INTO utilisateur (u_nom,u_prenom,u_dateAnniversaire,u_groupe) VALUES (:nom,:prenom,:dateA,:groupe)';
		$param = [ 'nom' => $this->nom, 'prenom' => $this->prenom, 'dateA' => $this->dateAnniversaire, 'groupe' => $this->groupe ];
		return $bdd->makeStatement($req,$param);
	}
}