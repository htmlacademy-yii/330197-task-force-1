<?php
use task_force\models\task;
use task_force\models\act_done;
use task_force\models\act_execute;
use task_force\ex\CallNameException;
use task_force\models\sql_insert;
use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\Categories;
require_once '../../vendor/autoload.php';

/* @var $this yii\web\View */

$this->title = 'Task Force';
?>
<div class="site-index" style="display:block; min-height: 63vh">
    <?php
        $task = new Tasks();

        $query = $task->find()->select(['t.title','t.description','t.budget','t.dt_add','t.deadline','current_status','t.idcategory as id'])->from(['tasks t'])->orderBy(['t.idcategory' => SORT_ASC])->limit(10);

        $rows = $query->all();

        $categ = new Categories();

        foreach($rows as $row){
            $i= $row['id'];
            $catgory[$i] = $categ->find()->select(['c.category'])->from('categories c')->where("c.id = $i")->groupBy('c.category')->one();
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
            <th style='text-align: center;'>Статус</th>
        </tr>

    <?php foreach($rows as $row):?>
        <tr style='border: solid 1px lightgrey;'>
            <td><?php echo $catgory[$row['id']]['category']?></td>
            <td><?php echo $row['title']?></td>
            <td><?php echo $row['description']?></td>
            <td><?php echo $row['budget']?></td>
            <td><?php echo $row['dt_add']?></td>
            <td><?php echo $row['deadline']?></td>
            <td><?php echo $row['current_status']?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <br>

</div>
