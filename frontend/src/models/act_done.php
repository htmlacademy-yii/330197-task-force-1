<?php
declare(strict_types=1);
namespace frontend\src\models;
use frontend\src\models\ci_action;

class Act_done extends CI_action {
	public $inner_name = 'done';
	public $public_name = 'Завершить';
    protected $role = 0;

function check_user (int $idcustomer, int $idexecuter, int $iduser, int $role){
		if($iduser == $idcustomer){
			return true;
		} else {
			return false;
		}
	}
}
