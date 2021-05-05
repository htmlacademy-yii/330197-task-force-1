<?php
declare(strict_types=1);
namespace frontend\src\models;
use frontend\src\models\act_done;
use frontend\src\models\act_execute;
use frontend\src\models\act_cancel;
use frontend\src\models\act_deny;
use frontend\src\ex\CallNameException;

error_reporting(E_ALL);

class Task{
	const STATUS_NEW = 'new';
	const STATUS_EXECUTE = 'in_progress';
	const STATUS_DONE = 'done';
	const STATUS_FAIL = 'failed';
	const STATUS_CANCEL = 'canceled';

	const ACTION_EXECUTE = 'execute';
	const ACTION_DONE = 'done';
	const ACTION_CANCEL = 'cancel';
	const ACTION_DENY = 'deny';

	const ROLE_CODE_CUSTUMER = 1;
	const ROLE_CODE_EXECUTER = 2;
	const ROLE_NAME_CUSTUMER = 'заказчик';
	const ROLE_NAME_EXECUTER = 'исполнитель';

	private $executer_id;
	private $customer_id;
	private $status = self::STATUS_NEW;

	private $status_array = [
		self::STATUS_NEW => 'Новое',
		self::STATUS_EXECUTE => 'В работе',
		self::STATUS_DONE => 'Выполнено',
		self::STATUS_FAIL => 'Провалено',
		self::STATUS_CANCEL => 'Отменено'
	];

	private $status_map = [
		self::ACTION_EXECUTE => self::STATUS_EXECUTE,
		self::ACTION_DONE => self::STATUS_DONE,
		self::ACTION_CANCEL => self::STATUS_CANCEL,
		self::ACTION_DENY => self::STATUS_FAIL
	];

	public $role_map = [
		self::ROLE_CODE_CUSTUMER => self::ROLE_NAME_CUSTUMER,
		self::ROLE_CODE_EXECUTER => self::ROLE_NAME_EXECUTER,
	];

	public function __construct($customer_id = null, $executer_id = null){
		$this->customer_id = $customer_id;
		$this->executer_id = $executer_id;

	}

public function get_actions(string $status, int $idcustomer, int $idexecuter, int $iduser, int $role){
		$array = [self::STATUS_NEW => [new Act_execute(), new Act_cancel()],
				  self::STATUS_EXECUTE => [new Act_done(), new Act_deny()],
				  self::STATUS_DONE => [],
				  self::STATUS_FAIL => [],
				  self::STATUS_CANCEL => [],
				];

		if(!in_array($status, array_keys($array))) {
			throw new CallNameException("Given status does not exist.");
		} 
		$actions = $array[$status];

		foreach($actions as $action){
			if($action->check_user($idcustomer, $idexecuter, $iduser, $role)){
				return $action;
			} 
		}
		return false;
	}

	public function next_status (string $action):string {

		if(!in_array($action, array_keys( $this->status_map ))){
			throw new CallNameException("Given action does not exist.");
		}

		$stmap = $this->status_map[$action];
		return $this->status_array[$stmap];
	}

	public function get_status(){
		return $this->status;
	}

	public function get_customer(){
		return $this->customer_id;
	}

	public function get_executer(){
		return $this->executer_id;
	}
}
