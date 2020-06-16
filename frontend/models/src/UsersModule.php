<?php

namespace frontend\models\src;

use Yii;
use yii\base\Module;
use frontend\models\ExecutersCategory;
use frontend\models\Users;
use frontend\models\UserProfile;
use frontend\models\Feadback;
use frontend\models\Tasks;
use frontend\models\Categories;
use frontend\functions;

class UsersModule extends Module {
	
	/*Выводим данные для представления*/
    public function getData(){
        // Выводим список всех исполнителей с их id, fio и датой регистрации
        $exec = new Users();
        $idexecuters = $exec->find()->select(['u.id', 'u.fio', 'u.dt_add', 'u.avatar', 'u.about', 'u.last_update'])->from('users u')->where('u.role = 2')->orderBy(['u.last_update' => SORT_DESC])->limit(10)->all();
        
        // Выводим список всех категорий с их id и названиями
        $categ = new Categories();
        $all_categories = $categ->find()->select(['c.id','c.category','c.icon'])->from('categories c')->all();
        
        foreach($all_categories as $cat){
            $categories[$cat['id']] = $cat['category'];
        }
        
        // Для каждого исполнителея выводим массив с idcategory работ которые они выполняют
        $idcat = new ExecutersCategory();
        foreach($idexecuters as $exc){
            $i= $exc['id'];
            $idcats[$i] = $idcat->find()->select('c.idcategory')->from('executers_category c')->where("c.idexecuter = $i")->all();
                             
            foreach($idcats[$i] as $idcat){
                $exec_categ[$i][] = $categories[$idcat['idcategory']];
            }
        }

        // Для каждого исполнителея выводим массив из количества задач и среднего рейтинга по задачам, которые он выполнил
    	$fead = new Feadback();
        foreach($idexecuters as $exc){
            $i= $exc['id'];
            $rate[$i]['qtask'] = $fead->find()->where("idexecuter = $i")->count('distinct idtask');
            $rate[$i]['qrate'] = $fead->find()->where("idexecuter = $i")->count('distinct rate');
            $rate[$i]['rate'] = $fead->find()->where("idexecuter = $i")->average('rate');
        }

        // Формируем данные в виде массива для представления
        $fun = new Functions();
        foreach($idexecuters as $exec){
        	$data[] = array('id' => $exec['id'],
                            'fio' => $exec['fio'],
                            'dt_add' => $exec['dt_add'],
                            'avatar' => $exec['avatar'],
                            'about' => $exec['about'],
                            'categories' => $exec_categ[$exec['id']],
            				'qtask' => $rate[$exec['id']]['qtask'],
                            'qrate' => $rate[$exec['id']]['qrate'],
            				'rate' => round($rate[$exec['id']]['rate'],2),
                            // 'last_update' => $fun->diff_result($exec['dt_add'])
                            'last_update' => $fun->diff_result($exec['last_update'])
            				);
        }
             
        return $data;
    }
}