<?php
//Поиск значения по ключу в файле, массив объект или null
function Search(&$File, $Key){
				//Индексация
				//Массив с индексами начинается с 0
				$Indexes = [0];
				while(($p = fgetc($File))){
								if(ord($p)==0x0A){
												array_push($Indexes,ftell($File));
								}
				}
				$rezult = find_in($File,	$Indexes,	$Key,0,count($Indexes)-1);
				if($rezult	===	-1){
								return null;
				}
				$pos = $Indexes[$rezult];
				unset($Indexes);
				fseek($File,	$pos);
				return getStruct($File);
}

//Функция бинарного поиска по файлу, если не находит нужное возвращает -1
function find_in(&$File, array &$Indexes, &$Key, int $left, int $right){
				if($left<=$right){
								//echo "$left $right<br>";
								$n = (int)(($right+$left)/2);
								//echo "$n<br>";
								if(fstrcat($File,$Indexes,$Key,$n)){
												return $n;
								}
								
								else{
												$r=find_in($File,	$Indexes,	$Key,$left,$n-1);
												
												if($r!=-1){
																return $r;
												}
												else return find_in($File,	$Indexes,	$Key,$n+1,$right);
								}
								
				}
				else return -1;
}

//Сравнение ключа
function fstrcat(&$File, array &$Indexes, $key, $p):bool{
				fseek($File,	$Indexes[$p]);
				$text = "";
				while(($c = fgetc($File))){
								if($c=="\t"||ord($c)==0x0A)break;
								$text.=$c;
				}
				if($text===$key){
								return true;
				}
				return false;
}
function getStruct(&$File):array{
				$obj = ["Key"=>"","Value"=>""];
				$v=false;
				while(($p = fgetc($File))){
								//echo $p;
								if(ord($p)==0x0A) break;
								if($p=="\t"){
												$v=true;
												continue;
								}
								if(!$v){
												$obj["Key"].=$p;
								}
								else{
												$obj["Value"].=$p;
								}
				}
				return $obj;
}