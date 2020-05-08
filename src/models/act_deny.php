<?php
namespace task_force\models;
use task_force\models\ci_action;

class Act_deny extends CI_action {
	private $inner_name = 'deny';
	private $public_name = 'Отказаться';

	function check_user ($idcustomer, $idexecuter, $iduser){
		if($iduser == $idexecuter){
			return true;
		} else {
			return false;
		}
	}

	function get_inner_name () {
		return $this->inner_name;
	}

	function get_public_name () {
		return $this->public_name;
	}
}
