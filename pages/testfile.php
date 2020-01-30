<?php
$filename = $_SERVER["DOCUMENT_ROOT"] . "/files/testfile.txt";
$size = 1024 ** 3;
//echo $size;
$file = fopen($filename, "w");
$i=0;
$f=false;
while(ftell($file)<=$size){
	if($f){
		fputs($file, "\x0A");
	}
	else{
		$f = true;
	}
	fputs($file, "Key_$i\tValue-".rand());

	$i++;
}
fclose($file);