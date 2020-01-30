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
		while(($p = fgetc($this->file))){
			if(ord($p)===0x0A){
				$linecount++;
			}
		}
		return $linecount+1;
	}
	

	private function goToString(int $nstring) {
		fseek($this->file, 0);  // seek to 0
		$i = 0;
		$linecount = 0;
		while(($linecount!=$nstring)){
			if(!($p= fgetc($this->file))){
				break;
			}
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
		while(($p = fgetc($this->file))){
			if(ord($p)===0x0A){
				break;
			}
			$str.=$p;
		}
		fseek($this->file, $pos);
		return $str;
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
		if ($this->cmpKey($searchKey)) {
			return new fileString($this->getString($midle));
		}

		$rezult = $this->binarySearch($searchKey, $left, $midle);
		if ($rezult !== 'undef') {
			return $rezult;
		}
		else{
			return $this->binarySearch($searchKey, $midle + 1, $right);
		}

	}

}
