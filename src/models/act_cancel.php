<?php
namespace task_force\models;
use task_force\models\ci_action;

class Act_cancel extends CI_action {
	protected $inner_name = 'cancel';
	protected $public_name = 'Отменить';

	function check_user ($idcustomer, $idexecuter, $iduser){
		if($iduser == $idcustomer){
			return true;
		} else {
			return false;
		}
	}
}
