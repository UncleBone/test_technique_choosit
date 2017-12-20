<?php
class UserModel extends CoreModel
{
	/**Retourne tous les utilisateurs ainsi que leurs groupes**/
	public function selectAll(){
		$req = 'SELECT * FROM utilisateur
				INNER JOIN groupe ON g_id = u_groupe
				ORDER BY g_nom ASC';
		return $this->makeSelect($req);
	}

	public function selectOneUser($id){
		$req = 'SELECT * FROM utilisateur WHERE u_id = :id';
		$param = [ 'id' => $id ];
		return $this->makeSelect($req,$param)[0];
	}

	public function selectUsersBy($groupe,$nom){
		if(!empty($groupe) && !empty($nom)){
			$req = 'SELECT * FROM utilisateur
					INNER JOIN groupe ON g_id = u_groupe
					WHERE g_nom = :groupe AND u_nom = :nom';
			$param = [ 'groupe' => $groupe, 'nom' => $nom ];
		}elseif (!empty($groupe) && empty($nom)) {
			$req = 'SELECT * FROM utilisateur
					INNER JOIN groupe ON g_id = u_groupe
					WHERE g_nom = :groupe';
			$param = [ 'groupe' => $groupe ];
		}elseif(empty($groupe) && !empty($nom)){
			$req = 'SELECT * FROM utilisateur
					INNER JOIN groupe ON g_id = u_groupe
					WHERE u_nom = :nom';
			$param = [ 'nom' => $nom ];
		}else{
			return $this->selectAll();
		}
		return $this->makeSelect($req,$param);
	}

	public function selectAllGroupes(){
		$req = 'SELECT * FROM groupe';
		return $this->makeSelect($req);
	}

	public function saveNewUser($nom,$prenom,$email,$date,$groupe){
		$req = 'INSERT INTO utilisateur (u_nom,u_prenom,u_email,u_dateNaissance,u_groupe) VALUES (:nom,:prenom,:email,:dateA,:groupe)';
		$param = [ 'nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'dateA' => $date, 'groupe' => $groupe ];
		return $this->makeStatement($req,$param);
	}

	public function supprimer($id){
		$req = 'DELETE FROM utilisateur WHERE u_id = :id';
		$param = [ 'id' => $id ];
		return $this->makeStatement($req,$param);
	}

	public function supprimerLot($tab){
		foreach ($tab as $value) {
			$this->supprimer($value);
		}
	}
}