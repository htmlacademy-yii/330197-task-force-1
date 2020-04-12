<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
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
	const ACTION_MESSAGE = 'write_message';

	const CUSTOMER = 'costomer';
	const EXECUTER = 'executer';

	public $id = 0;
	public $executer_id = 0;
	public $customer_id = 0;
	public $status = 'new';

	private $actions_map = [
		'customer' => array( 
			self::STATUS_NEW => self::ACTION_CANCEL,
			self::STATUS_EXECUTE => self::ACTION_DONE
		),
		'executer' => array(
			self::STATUS_NEW => array(self::ACTION_EXECUTE, self::ACTION_MESSAGE),
			self::STATUS_EXECUTE => array(self::ACTION_DENY, self::ACTION_MESSAGE)),
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
	
	public function getActions($user_type){
		if(in_array($user_type,array_keys($this->actions_map))){
			return $this->actions_map[$user_type][$this->status];
		} else{
			return self::ACTION_MESSAGE;
		}
	}

	public function nextStatus($action){
		if(in_array($action,array_keys($this->status_map))){
			$this->status = $this->status_map[$action];
		}
		return $this->status;
	}
}