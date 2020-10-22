<?php

namespace frontend\models\src;

use Yii;
use yii\base\Module;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use frontend\models\ExecutersCategory;
use frontend\models\Users;
use frontend\models\Categories;

class UsersSearch extends Module {

    //Представляем, данные полученные из формы в удобном виде
    public function parse_data($form_data){
        if($form_data['category']){
            $form_data['category'] = implode(",",$form_data['category']);
        }
        return $form_data;
    }
    
    //Выводим список исполнителей, которые принадлежат к выбранной категории
    private function getExequtersCategory($categories=null){
        $idexecuters = ExecutersCategory::find()->distinct()->select(['idexecuter'])->from('executers_category');
        if($categories){
            $idexecuters = $idexecuters->andWhere("idcategory in ($categories)");
        }
        $idexecuters = $idexecuters->all();

        //Записываем в масив список всех исполнителей с нужной категорией
        foreach($idexecuters as $value){
            $array_execurters[] = $value['idexecuter'];
        }
        $array_execurters = implode(",",$array_execurters);

        return $array_execurters;
    }

    // Выводим список всех исполнителей с их id, fio и датой регистрации с условиями фильтрации
    public function search($form_data = null){
        $idexecuters = $this->getExequtersCategory($form_data['category']);
        $users = (new Query())
                    ->select(['u.id', 'u.fio', 'u.dt_add', 'u.last_update', 'u.avatar', 'u.about', 'avg(ifnull(f.rate,0)) as rate' , 'COUNT(t.id) as qtask' , 'u.views'])
                    ->from('users u')
                    ->leftJoin('feadback f','f.idexecuter = u.id')
                    ->leftJoin('tasks t','t.idexecuter = u.id')
                    ->where('u.role = 2')
                    ->andWhere("u.id in ($idexecuters)");
        if($form_data['search']){
            $users = $users->andWhere("MATCH(fio) AGAINST('*".$form_data['search']."*' in boolean mode)");
        } else {
            if($form_data['free']){
                $users = $users->andWhere("NOT EXISTS (SELECT * FROM tasks t WHERE t.idexecuter = u.id AND t.current_status IN ('new','in_progress'))");
            }
            if($form_data['online']){
                $users = $users->andWhere("u.last_update >= date_sub(NOW(),INTERVAL 30 MINUTE)");
            }
            if($form_data['feedback']){
                $users = $users->andWhere("u.id in (select distinct idexecuter from feadback)");
            }
            if($form_data['favorite']){
                $users = $users->andWhere("u.id in (select distinct idexecuter from favorite)");
            }
        }
        $users = $users->groupBy(['u.fio', 'u.dt_add', 'u.last_update', 'u.avatar', 'u.about', 'u.views']);
        if($form_data['s'] === 'date'){
            $users = $users->orderBy(['u.dt_add'=> SORT_DESC]);
        }
        if($form_data['s'] === 'rate'){
            $users = $users->orderBy(['rate'=> SORT_DESC]);
        }
        if($form_data['s'] === 'orders'){
            $users = $users->orderBy(['qtask'=> SORT_DESC]);
        }
        if($form_data['s'] === 'favor'){
            $users = $users->orderBy(['views'=> SORT_DESC]);
        }           
        $users = $users->limit(5)->all();

        return $users;
    }

    //Формируем дополнительные данные для ответа
    public function getAddition($users){
        // Для каждого исполнителея выводим массив с idcategory работ которые они выполняют
        foreach($users as $user){
            $i= $user['id'];
            $iduser = Users::findOne($i);
            $idexecuters = $iduser->executersCategories;
            foreach($idexecuters as $value){
                $array[$i]['idcategories'][] = $value->idcategory;
            }
        }
        return $array;
    }
}
