<?php
namespace task_force\models;
use task_force\models\ci_action;

class Act_execute extends CI_action {
	protected $inner_name = 'execute';
	protected $public_name = 'Откликнуться';

	function check_user ($idcustomer, $idexecuter, $iduser){
		if($iduser == $idexecuter){
			return true;
		} else {
			return false;
		}
	}
}