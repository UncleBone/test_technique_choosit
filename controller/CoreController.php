<?php
class CoreController{
	protected $parameters;// array parametres obtenu en GET par défaut

	public function __contruct(){
		$this->parameters = array();
	}

	public function setParameters(array $parameters){
		$this->parameters = $parameters;
	}
}