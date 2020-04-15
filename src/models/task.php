<?php
namespace task_force\models;
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

	const CUSTOMER = 'costomer';
	const EXECUTER = 'executer';

	public $executer_id = 0;
	public $customer_id = 0;
	private $status = self::STATUS_NEW;

	private $status_array = [
		self::STATUS_NEW => 'Новое',
		self::STATUS_EXECUTE => 'В работе',
		self::STATUS_DONE => 'Выполнено',
		self::STATUS_FAIL => 'Провалено',
		self::STATUS_CANCEL => 'Отменено'
	];

	private $actions_array = [
		self::ACTION_EXECUTE => 'Откликнуться',
		self::ACTION_DONE => 'Завершить',
		self::ACTION_CANCEL => 'Отменить',
		self::ACTION_DENY => 'Отказаться',
	];

	private $actions_map = [
		self::CUSTOMER => array( 
			self::STATUS_NEW => self::ACTION_CANCEL,
			self::STATUS_EXECUTE => self::ACTION_DONE
		),
		self::EXECUTER => array(
			self::STATUS_NEW => array(self::ACTION_EXECUTE),
			self::STATUS_EXECUTE => array(self::ACTION_DENY)),
	];

	private $status_map = [
			self::ACTION_EXECUTE => self::STATUS_EXECUTE,
			self::ACTION_DONE => self::STATUS_DONE,
			self::ACTION_CANCEL => self::STATUS_CANCEL,
			self::ACTION_DENY => self::STATUS_FAIL
	];

	public function __construct($customer_id = null, $executer_id = null){
			$this->customer_id = $customer_id;
			$this->executer_id = $executer_id;

	}
	
	public function get_actions ($user_type) {
		if(in_array($user_type, array_keys( $this->actions_map ))) {
			
			$action = $this->actions_map[$user_type][$this->status];
			return $this->actions_array[$action];

		} else {
			return false;
		}
	}

	public function next_status ($action) {
		if(in_array($action, array_keys( $this->status_map ))){
			
			$status = $this->status_map[$action];
			return $this->status_array[$status];
		
		} else{
			return $this->status_array[$this->status];
		}
	}
}

$myTask = new Task('vasya','petya');
echo $myTask->customer_id.'<br>';
echo $myTask->get_actions('executor').'<br>';
echo $myTask->next_status('execute').'<br>';