<?php

declare(strict_types=1);
namespace frontend\src\models;
use frontend\src\models\ci_action;
use frontend\src\models\task;

class Act_execute extends CI_action {
	public $inner_name = 'execute';
	public $public_name = 'Откликнуться';
    protected $role = 0;

function check_user (int $idcustomer, int $idexecuter, int $iduser, int $role){
		if($idexecuter === 0 and $role === Task::ROLE_CODE_EXECUTER){
			return true;
		} else {
			return false;
		}
	}
}
