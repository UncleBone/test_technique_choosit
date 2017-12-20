<?php
class UserController extends CoreController
{
	public function display(){
		$bdd = new UserModel();

		$detailsId = $this->parameters['details'] ?? null;
		if(!is_null($detailsId)){
			$details = $bdd->selectOneUser($detailsId);
			$details['age'] = $this->calculAge($details['u_dateAnniversaire']);
		}

		if(empty($this->parameters['rechGroupe']) && empty($this->parameters['rechNom'])){
			$data = $bdd->selectAll();
		}else{
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

	public function creation($message = ''){
		$bdd = new UserModel();
		$groupes = $bdd->selectAllGroupes();

		ob_start();
		require(VIEWS_PATH . DS . 'creationView.php');
		$view = ob_get_contents();
		ob_clean();
		require(VIEWS_PATH . DS . 'layout.php');
	}

	public function traitementCreation(){
		if(!empty($this->parameters['nom']) && !empty($this->parameters['prenom']) && 
			!empty($this->parameters['email']) && !empty($this->parameters['date']) && !empty($this->parameters['groupe'])){
			$nom = htmlentities($this->parameters['nom']);
			$prenom = htmlentities($this->parameters['prenom']);
			$email = htmlentities($this->parameters['email']);
			$date = htmlentities($this->parameters['date']);
			$groupe = htmlentities($this->parameters['groupe']);
			if(preg_match('#^[a-zA-Z\s]*$#',$nom) && preg_match('#^[a-zA-Z\s]*$#',$prenom) && 
				filter_var($email, FILTER_VALIDATE_EMAIL) && $this->validerDate($date)){
				$bdd = new UserModel();
				if($bdd->saveNewUser($nom,$prenom,$email,$date,$groupe)){
					$message = 'Nouvel utilisateur enregistré!';
				}else{
					$message = 'Erreur d\'écriture dans la BDD';
				}
			}else{
				$message = 'Erreur';
			}
		}else{
			$message = 'Erreur: un des champs est vide';
		}
		$this->creation($message);
	}

	public function validerDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
}