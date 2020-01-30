<?php

Class fileString {
	private $str;
	function fileString($str) {
		if (strlen($str) !== 0) {
			$this->str = $str;
		} else {
			throw new \Exception('Empty String');
		}
	}
	function getKey() {
		return explode("\t", $this->str)['0'];
	}

	function getValue() {
		return explode("\t", $this->str)['1'];
	}
}

Class FileSearcher{
	private $file;
	function FileSearcher($fileName) {
		$this->file = fopen($fileName, "r");
	}

	function getLength(){
		$linecount = 0;
		while(!feof($this->file)){
		$p = fgetc($this->file);
			if(ord($p)==0x0A){
				$linecount++;
			}
		}
		return $linecount+1;
	}
	

	private function goToString(int $nstring) {
		fseek($this->file, 0);  // seek to 0
		$i = 0;
		$linecount = 0;
		while(($linecount!=$nstring)&& !feof($this->file)){
			$p= fgetc($this->file);
			if(ord($p)===0x0A){
				$linecount++;
			}
			$i++;
		}
		return $i;
	}
	private function cmpKey($key){
		$f = true;
		$n = strlen($key);
		for($i=0;$i<$n;$i++){
			if($key[$i]===fgetc($this->file)){
			   continue;
			}
			else{
				$f = false;
				break;
			}
		}
		if(fgetc($this->file)!=="\t"){
			$f=false;
		}
		return $f;
	}
	function getCurrentString(){
		$pos = ftell($this->file);
		$str = "";
		while(!feof($this->file)){
			$p = fgetc($this->file);
			if(ord($p)===0x0A){
				break;
			}
			$str.=$p;
		}
		fseek($this->file, $pos);
		return $str;
	}
	function getCurrentKey(){
		$key="";
		while(!feof($this->file)){
			$p = fgetc($this->file);
			if($p==="\x0A"||$p==="\t"){
				break;
			}
			$key.=$p;
		}
		return $key;
	}
	function getString(int $string) {
		$this->goToString($string);
		return $this->getCurrentString();
	}
	
	function binarySearch($searchKey, int $left = 0, int $right) {
		if ($left>=$right) {
			return 'undef';
		}
		$midle = floor(($right+$left)/2);
		$this->goToString($midle);
		$curKey = $this->getCurrentKey();
		$cmp = strnatcasecmp($searchKey,$curKey);
		switch($cmp){
			case 1:
				return $this->binarySearch($searchKey, $midle + 1, $right);
			case 0:
				return new fileString($this->getString($midle));
			case -1: 
				return $this->binarySearch($searchKey, $left, $midle);
		}
	}
}
