<?php
namespace task_force\models;

abstract class CI_action {

	abstract public function check_user ($idcustomer, $idexecuter, $iduser);
	abstract public function get_inner_name ();
	abstract public function get_public_name ();
	
}