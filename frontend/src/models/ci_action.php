<?php
declare(strict_types=1);
namespace frontend\src\models;

abstract class CI_action {
	protected $inner_name;
	protected $public_name;
  protected $role;

  abstract public function check_user (int $idcustomer, int $idexecuter, int $iduser, int $role);

  public function get_inner_name ():?string{
    return $this->inner_name;
  }

  public function get_public_name ():?string{
    return $this->public_name;
  }
	
}
