<?php
//namespace task_force\models;
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

	const CUSTOMER = 'customer';
	const EXECUTER = 'executer';

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
			self::STATUS_EXECUTE => array(self::ACTION_DENY)
		)
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
			
			$stmap = $this->status_map[$action];
			return $this->status_array[$stmap];
		
		} else{
			return $this->status_array[$this->status];
		}
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

$myTask = new Task('vasya','petya');
echo $myTask->next_status('execute').'<br/>';
echo $myTask->get_status().'<br/>';
echo $myTask->get_actions('customer').'<br/>';
echo $myTask->get_customer().'<br/>';

try {
    assert($myTask->next_status('execute') === 'В работе');
    assert($myTask->get_actions('customer') == 'Отменить'); 
    assert($myTask->get_customer() == 'vasya');
} catch (AssertionError $e) {
    echo $e->getMessage();
}