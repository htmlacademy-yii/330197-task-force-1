<?php
namespace task_force\models;
use task_force\models\ci_action;

class Act_deny extends CI_action {
	protected $inner_name = 'deny';
	protected $public_name = 'Отказаться';

	function check_user ($idcustomer, $idexecuter, $iduser){
		if($iduser == $idexecuter){
			return true;
		} else {
			return false;
		}
	}
}
