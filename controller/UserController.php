<?php
class UserController extends CoreController
{
	public function display(){
		$bdd = new UserModel();
		$data = $bdd->selectAll();

		require(VIEWS_PATH . DS . 'view.php');
	}
}