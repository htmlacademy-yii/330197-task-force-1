<?php
use task_force\models\task;
use task_force\models\act_done;
use task_force\models\act_execute;
use task_force\ex\CallNameException;
use task_force\models\sql_insert;
use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\categories;
require_once '../../vendor/autoload.php';

/* @var $this yii\web\View */

$this->title = 'Task Force';
?>
<div class="site-index" style="display:block; min-height: 63vh">
    <?php
        $task = new Tasks();
        $query = $task->find()->select(['t.title','t.description','t.budget','t.dt_add','t.deadline','c.*'])->from(['tasks t','categories c'])->where('t.idcategory = c.id')->orderBy(['c.id' => SORT_ASC])->limit(10);
        $rows = $query->all();

        $categ = new Categories();

        foreach($rows as $row){
            $i= $row['id'];
            $catgory[$i] = $categ->find()->select(['c.category'])->from('categories c')->where("c.id = $i")->one();
        }
    ?>
    <table style='border: solid 1px lightgrey; font-size: 10pt'>
        <h3>Список задач</h3>
        <tr style='background: lightgrey; text-align: center'>
            <th style='text-align: center;'>Категория</th>
            <th style='text-align: center;'>Название</th>
            <th style='text-align: center; width: 50%'>Описание</th>
            <th style='text-align: center;'>Бюджет</th>
            <th style='text-align: center;'>Дата начала</th>
            <th style='text-align: center;'>Конечный срок</th>
        </tr>

    <?php foreach($rows as $row):?>
        <tr style='border: solid 1px lightgrey;'>
            <td><?php echo $catgory[$row['id']]['category']?></td>
            <td><?php echo $row['title']?></td>
            <td><?php echo $row['description']?></td>
            <td><?php echo $row['budget']?></td>
            <td><?php echo $row['dt_add']?></td>
            <td><?php echo $row['deadline']?></td>
            <td><?php echo $row['satatus']?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <br>
<!-- <?php
    $myTask = new Task(11111,22222);
    echo $myTask->get_status().'<br/>';
    echo $myTask->get_customer().'<br/>';
    echo '<br/>';

    $act = 'done';
    try{
        $status_next = $myTask->next_status($act);
    } catch (CallNameException $e){
        error_log("Cannot get next status: ".$e->getMessage());
    }
    if(isset($status_next)){
        echo "Action - $act, next status: ".$status_next.'<br/><br/>';
    }

    $act = 'gone';
    try{
        $st_next = $myTask->next_status($act);
    } catch (CallNameException $e){
        error_log("Cannot get next status: ".$e->getMessage());
    }
    if(isset($st_next)){
        echo "Action - $act, next status: ".$st_next.'<br/><br/>';
    }

    try{
        $inprog_custumer = $myTask->get_actions('in_progress', 1111,2222,1111);
    } catch(CallNameException $e){
        error_log("Cannot get next action: " . $e->getMessage());
    }
    if(isset($inprog_custumer)){
        echo 'Status - in_progress, user - customer: <br/>';
        echo $inprog_custumer->get_inner_name().'<br/>';
        echo $inprog_custumer->get_public_name().'<br/>';
        echo '<br/>';
    }

    try{
        $inprog_exec = $myTask->get_actions('in_progres', 1111,2222,2222);
    } catch(CallNameException $e){
        error_log("Cannot get next action: " . $e->getMessage());
    }
    if(isset($inprog_exec)){
        echo 'Status - in_progress, user - executer: <br/>';
        echo $inprog_exec->get_inner_name().'<br/>';
        echo $inprog_exec->get_public_name().'<br/>';
        echo '<br/>';
    }

    try{
        $inprog_other = $myTask->get_actions('in_progress', 1111,2222,3333);
    } catch(CallNameException $e){
        error_log("Cannot get next action: " . $e->getMessage());
    }

    if(!$inprog_other){
        echo 'Status - in_progress, user - other: <br/>';
        var_dump($inprog_other);
        echo "<br/>";
    }

    try{
        $new_custumer = $myTask->get_actions('new', 1111,2222,1111);
    } catch(CallNameException $e){
        error_log("Cannot get next action: " . $e->getMessage());
    }
    if(isset($new_custumer)){
        echo '<br/>Status - new, user - customer: <br/>';
        echo $new_custumer->get_inner_name().'<br/>';
        echo $new_custumer->get_public_name().'<br/>';
        echo '<br/>';
    }

    try{
        $new_executer = $myTask->get_actions('new', 1111,2222,2222);
    } catch(CallNameException $e){
        error_log("Cannot get next action: " . $e->getMessage());
    }
    if(isset($new_executer)){
        echo 'Status - new, user - executer: <br/>';
        echo $new_executer->get_inner_name().'<br/>';
        echo $new_executer->get_public_name().'<br/>';
        echo '<br/>';
    }

    /*Создаём файлы с инструкциями для заполнения таблиц база данных*/
    $dir = "../../data/csv_files";
    /*Обрабатываем один файл*/
    $file_name = 'tasсks.csv';
    $file_convert = new SQL_insert($dir,$file_name);

    try {
        $answer = $file_convert->get_sqlfile();
    } catch (CallNameException $e){
        error_log("File converted was not succsess: " . $e->getMessage());
    }
    if(isset($answer)){
        echo "Обработан одиночный файл <br/>";
        echo $answer."<br/>";
    } else {
        echo "Возникла ошибка при конвертации файла. <br/>";
    }

    $iterator = new \FilesystemIterator($dir);

    // Выполняем последовательно следующие операции с каждым найденным файлом формата .csv
    while($iterator->valid()) {
        $file = $iterator->current();
        // Записываем имя файла
        $file_name = $file->getFilename();

        $file_convert = new SQL_insert($dir,$file_name);
        try {
            $answer = $file_convert->get_sqlfile();
        } catch (CallNameException $e){
            error_log("File converted was not succsess: " . $e->getMessage());
        }
        if(isset($answer)){
            echo $answer;
        } 

        $iterator->next();
    } 
?> -->
</div>
