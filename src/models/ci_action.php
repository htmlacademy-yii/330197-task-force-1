<?php
namespace task_force\models;

abstract class CI_action {
	protected $inner_name;
	protected $public_name;

	abstract public function check_user ($idcustomer, $idexecuter, $iduser);
	
	public function get_inner_name (){
		return $this->inner_name;
	}

	public function get_public_name (){
		return $this->public_name;
	}
	
}