<?php
declare(strict_types=1);
namespace frontend\src\models;
use frontend\src\models\ci_action;

class Act_deny extends CI_action {
	public $inner_name = 'deny';
	public $public_name = 'Отказаться';
    protected $role = 0;

function check_user (int $idcustomer, int $idexecuter, int $iduser, int $role){
		if($iduser == $idexecuter){
			return true;
		} else {
			return false;
		}
	}
}
