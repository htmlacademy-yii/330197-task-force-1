<?php
declare(strict_types=1);
namespace task_force\models;
use task_force\models\ci_action;

class Act_done extends CI_action {
	protected $inner_name = 'done';
	protected $public_name = 'Завершить';

function check_user (int $idcustomer, int $idexecuter, int $iduser){
		if($iduser == $idcustomer){
			return true;
		} else {
			return false;
		}
	}
}
