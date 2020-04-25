<?php
use task_force\models\task;
require_once 'vendor/autoload.php';

$myTask = new Task(11111,22222);
echo $myTask->next_status('execute').'<br/>';
echo $myTask->get_status().'<br/>';
echo $myTask->get_actions('customer').'<br/>';
echo $myTask->get_customer().'<br/>';

try {
    assert($myTask->next_status('execute') === 'В работе');
    assert($myTask->get_actions('customer') == 'Отменить'); 
    assert($myTask->get_customer() == 11111);
} catch (AssertionError $e) {
    echo $e->getMessage();
}