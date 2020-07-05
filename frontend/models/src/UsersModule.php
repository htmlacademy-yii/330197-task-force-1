<?php

namespace frontend\models\src;

use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use frontend\models\ExecutersCategory;
use frontend\models\Users;
use frontend\models\UserProfile;
use frontend\models\Feadback;
use frontend\models\Tasks;
use frontend\models\Categories;
use frontend\functions;

class UsersModule extends Module {
	
	/*Выводим данные для представления*/
    public function getData($form_data = null){
        if($form_data['categories']){
            $array_cat = implode(",",$form_data['categories']);
        }
        if($form_data['free']){
            $free = true;
        }
        if($form_data['online']){
            $online = true;
            // var_dump($online); die('here');
        }
        if($form_data['feedback']){
            $feedback = true;
        }
        if($form_data['favorite']){
            $favorite = true;
        }
        if($form_data['find']){
            $find = $form_data['find'];
        }

        //Выводим список исполнителей, которые принадлежат к выбранной категории
        $users = new ExecutersCategory();
        $idusers = $users->find()->distinct()->select(['idexecuter'])->from('executers_category');
        if($array_cat){
            $idusers = $idusers->andWhere("idcategory in ($array_cat)");
        }
        $idusers = $idusers->all();
        //Записываем в масив список всех исполнителей с нужной категорией
        foreach($idusers as $value){
            $array_exec[] = $value['idexecuter'];
        }
        $array_exec = implode(",",$array_exec);

        // Выводим список всех исполнителей с их id, fio и датой регистрации
        $exec = new Users();
        $idexecuters = $exec->find()->distinct()->select(['u.id', 'u.fio', 'u.dt_add', 'u.avatar', 'u.about', 'u.last_update'])->from('users u')->where("u.id in ($array_exec)");
        
        //Добавляем условия по фильтрам
        if($find){
            $idexecuters = $idexecuters->andWhere("MATCH(fio) AGAINST('*$find*' in boolean mode)");
        } else {
            if($free){
                $idexecuters = $idexecuters->andWhere("NOT EXISTS (SELECT * FROM tasks t WHERE t.idexecuter = u.id AND t.current_status IN ('new','in_progress'))");
            }
            if($online){
                $idexecuters = $idexecuters->andWhere("u.last_update >= date_sub(NOW(),INTERVAL 30 MINUTE)");
            }
            if($feedback){
                $idexecuters = $idexecuters->andWhere("u.id in (select distinct idexecuter from feadback)");
            }
            if($favorite){
                $idexecuters = $idexecuters->andWhere("u.id in (select distinct idexecuter from favorite)");
            }
        }
        
        $idexecuters = $idexecuters->orderBy(['u.last_update' => SORT_DESC])->limit(10)->all();

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