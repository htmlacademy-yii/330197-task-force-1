<?php
declare(strict_types=1);
namespace task_force\models;
use task_force\ex\CallNameException;

class SQL_insert{
	private $dir_csv;
	private $dir_sql = "../../data/sql_files/";
	private $file_name;
	private $table_name;
	private $file_path;
	private $fp;

	public function __construct(string $dir_csv, string $file_name){
		$this->file_name = $file_name;
		$this->dir_csv = $dir_csv;
	}

	public function get_sqlfile():string {
		    $header_data =[];
		    $data = [];
		    $request = "";
		    $qcolmn = 0;
		    $date_reg = '/^[0-9]{2,4}[\-\.][0-9]{2}[\-\.][0-9]{2,4}$/';
		    $num_reg = "/^[1-9]{0,4}[\.]{0,1}[0-9]+$/";

		    // Проверяем найденный файл на соответствие формату .csv
		    if(!substr($this->file_name,-4,4) == '.csv'){		    	
		     throw new CallNameException("File format ' $this->file_name ' different from .csv");
			}
			// Название файла .csv должно соответствовать названию таблицы БД
			$this->table_name = substr($this->file_name,0,-4);
			$this->file_path = $this->dir_csv.'/'.$this->file_name;
		    
		    if (!file_exists($this->file_path)) {
	            throw new CallNameException("File ' $this->file_path ' does not exist");
	        } 

		    // Открываем файл для чтения
		    $this->fp = fopen($this->file_path,'r');

		    // Считываем названия столбцов в перемнную $header_data
		    if (!$this->fp) {
	            throw new CallNameException("It is not possible to open a file");
	        }
	        rewind($this->fp);
	        $header_data = fgetcsv($this->fp);
	        $qcolmn = sizeof($header_data);

	        for($i=0; $i<$qcolmn; $i++){
	        	$header_data[$i] = trim($header_data[$i]);
	        }
	        
	        // Считываем данные из файла в массив $data		        
	        foreach($this->getNextLine() as $value){
	        	$data[] = $value;
	        };
	        $data = array_filter($data);
	        
	        // Формируем sql-запрос для вставки данных из файла в таблицу БД
	        $request = "insert into $this->table_name (";
	        $character_mask = " \t\n\r\0\x0B";
	        $character_mask .= '﻿'; // !important! Add some unprinted symbols.

	        for($i=0; $i<$qcolmn-1; $i++) {
	        	$header_data[$i] = trim($header_data[$i], $character_mask);
	        	$request .= $header_data[$i]. ", ";
	        }
	        $request .= $header_data[$qcolmn-1].") \n values ";

	        foreach($data as $row){
	        	$request .= "(";

	        	for($i=0; $i<$qcolmn-1; $i++) {

	        		if ($row[$i] == null) {
	        			$request .= "null, ";
					} elseif (preg_match($date_reg,$row[$i])) {
	        			$dt = strtotime($row[$i]);
	        			$request .= "str_to_date('".date('Y-m-d',$dt)."','%Y-%m-%d '), ";
	        		} elseif (preg_match($num_reg,$row[$i])) {
	        			$request .= $row[$i].', ';
	        		} else {
	        			$request .= "'".$row[$i]."', ";
	        		}
	        	}

	        	if ($row[$qcolmn-1] == null) {
        			$request .= "null), \n";
				} elseif (preg_match($date_reg,$row[$qcolmn-1])) {
        			$dt = strtotime($row[$qcolmn-1]);
        			$request .= "str_to_date('".date('Y-m-d',$dt)."','%Y-%m-%d ')), \n";
        		} elseif (preg_match($num_reg,$row[$qcolmn-1])) {
        			$request .= $row[$qcolmn-1]."), \n";
        		} else {
        			$request .= "'".$row[$qcolmn-1]."'), \n";
        		}
	        }
	        $request = substr($request, 0,-3);
	        $request .=";";
	        
	        fclose($this->fp);

		    // Создаём файл .sql с инструкцией для вставки данных в БД
		    $new_file = fopen($this->dir_sql.$this->table_name.".sql",'w');
		    fwrite($new_file, $request);
		    fclose($new_file);

		    return $notice = " Файл $this->dir_csv/$this->file_name успешно обработан. Создан файл $this->dir_sql.$this->table_name.sql <br/> \n";
			
	}

	private function getNextLine():?iterable {
        $result = null;
        while (!feof($this->fp)) {
            yield fgetcsv($this->fp);
        }
        return $result;
    }

}