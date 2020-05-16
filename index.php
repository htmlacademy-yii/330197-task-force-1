<?php
use task_force\models\task;
use task_force\models\act_done;
use task_force\models\act_execute;
require_once 'vendor/autoload.php';

$myTask = new Task(11111,22222);
echo $myTask->get_status().'<br/>';
echo $myTask->get_customer().'<br/>';
echo '<br/>';

$inprog_custumer = $myTask->get_actions('in_progress', 1111,2222,1111);
if($inprog_custumer){
	echo 'Status - in_progress, user - customer: <br/>';
	echo $inprog_custumer->get_inner_name().'<br/>';
	echo $inprog_custumer->get_public_name().'<br/>';
	echo '<br/>';
}

$inprog_exec = $myTask->get_actions('in_progress', 1111,2222,2222);
if($inprog_exec){
	echo 'Status - in_progress, user - executer: <br/>';
	echo $inprog_exec->get_inner_name().'<br/>';
	echo $inprog_exec->get_public_name().'<br/>';
	echo '<br/>';
}

$inprog_other = $myTask->get_actions('in_progress', 1111,2222,3333);
if(!$inprog_other){
	echo 'Status - in_progress, user - other: <br/>';
	var_dump($inprog_other);
	echo "<br/>";
}

$new_custumer = $myTask->get_actions('new', 1111,2222,1111);
if($new_custumer){
	echo 'Status - new, user - customer: <br/>';
	echo $new_custumer->get_inner_name().'<br/>';
	echo $new_custumer->get_public_name().'<br/>';
	echo '<br/>';
}

$new_executer = $myTask->get_actions('new', 1111,2222,2222);
if($new_executer){
	echo 'Status - new, user - executer: <br/>';
	echo $new_executer->get_inner_name().'<br/>';
	echo $new_executer->get_public_name().'<br/>';
	echo '<br/>';
}

/*
try {
    assert($myTask->next_status('execute') == 'В работе');
    assert($myTask->get_actions('new') == array('Отменить','Откликнуться')); 
    assert($myTask->get_customer() == 11111);
} catch (AssertionError $e) {
    echo $e->getMessage();
}
*/