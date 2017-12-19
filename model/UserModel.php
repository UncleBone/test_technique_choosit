<?php
class UserModel extends CoreModel
{
	public function selectAll(){
		$req = 'SELECT * FROM utilisateur
				INNER JOIN groupe ON g_id = u_groupe
				ORDER BY g_nom ASC';
		return $this->makeSelect($req);
	}
}