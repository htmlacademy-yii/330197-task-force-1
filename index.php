<?php
//require_once "autoload.php";
use task_force\models\task;
require_once 'vendor/autoload.php';

$myTask = new Task('vasya','petya');
echo $myTask->customer_id.'<br>';
echo $myTask->get_actions('executor').'<br>';
echo $myTask->next_status('execute').'<br>';