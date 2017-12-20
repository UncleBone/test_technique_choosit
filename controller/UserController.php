<?php
class UserController extends CoreController
{
	/**Affichage du tableau d'utilisateur et éventuellement des détails d'un utilisateur**/
	public function display(){
		$bdd = new UserModel();

		/**Si les détails d'un utilisateur sont demandés, on charge les données**/
		$detailsId = $this->parameters['details'] ?? null;
		if(!is_null($detailsId)){
			$details = $bdd->selectOneUser($detailsId);
			$details['age'] = $this->calculAge($details['u_dateNaissance']);
		}

		/**Si aucun paramètre de filtrage, on sélectionne tout**/
		if(empty($this->parameters['rechGroupe']) && empty($this->parameters['rechNom'])){
			$data = $bdd->selectAll();
		}else{	/**Sinon on ne sélectionne que les utilisateurs filtrés**/
			$rechNom = htmlentities($this->parameters['rechNom']) ?? null;
			$rechGroupe = htmlentities($this->parameters['rechGroupe']) ?? null;
			$data = $bdd->selectUsersBy($rechGroupe,$rechNom);
		}
		
		ob_start();
		require(VIEWS_PATH . DS . 'displayView.php');
		$view = ob_get_contents();
		ob_clean();
		require(VIEWS_PATH . DS . 'layout.php');
	}

	public function calculAge($date){
		$anniversaire = new DateTime($date);
		$currentTime = new DateTime();
		return $anniversaire->diff($currentTime)->y;
	}

	/**Affichage du formulaire de création de nouveaux utilisateurs**/
	public function creation($message = ''){
		$bdd = new UserModel();
		$groupes = $bdd->selectAllGroupes();

		ob_start();
		require(VIEWS_PATH . DS . 'creationView.php');
		$view = ob_get_contents();
		ob_clean();
		require(VIEWS_PATH . DS . 'layout.php');
	}

	/**Traitement du formulaire de création de nouveax utilisateurs**/
	public function traitementCreation(){
		if(!empty($this->parameters['nom']) && !empty($this->parameters['prenom']) && 
			!empty($this->parameters['email']) && !empty($this->parameters['date']) && !empty($this->parameters['groupe'])){
			$nom = htmlentities($this->parameters['nom']);
			$prenom = htmlentities($this->parameters['prenom']);
			$email = htmlentities($this->parameters['email']);
			$date = htmlentities($this->parameters['date']);
			$groupe = htmlentities($this->parameters['groupe']);
			if(filter_var($email, FILTER_VALIDATE_EMAIL) && $this->validerDate($date)){
				$bdd = new UserModel();
				if($bdd->saveNewUser($nom,$prenom,$email,$date,$groupe)){
					$message = 'Nouvel utilisateur enregistré!';
				}else{
					$message = 'Erreur d\'écriture dans la BDD';
				}
			}else{
				$message = 'Erreur dans l\'un des champs';
			}
		}else{
			$message = 'Erreur: un des champs est vide';
		}
		$this->creation($message);
	}

	/**Vérification de la validité d'un date**/
	public function validerDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}

	/**Suppression d'un utilisateur**/
	public function supprimer()
	{
		if(!empty($this->parameters['id'])){
			$id = $this->parameters['id'];
			$bdd = new UserModel();
			$bdd->supprimer($id);
		}
		header('Location:.');		
	}

	/**Suppression de plusieurs utilisateurs**/
	public function suppressionLot(){
		foreach ($this->parameters as $key => $value) {
			if(is_int($key) && $value == 'supprimer'){
				$tab[] = $key;
			}
		}
		$bdd = new UserModel();
		$bdd->supprimerLot($tab);

		header('Location:.');
	}
}