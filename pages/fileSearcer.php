<?php

Class	fileString	{
				private	$str;
				function	fileString($str)	{
								if	(strlen($str)	!==	0)	{
												$this->str	=	$str;
								}	else	{
												throw	new	\Exception('Empty String');
								}
				}
				function	getKey()	{
								return	explode("\t",	$this->str)['0'];
				}
				function	getValue()	{
								return	explode("\t",	$this->str)['1'];
				}
}

Class	FileSearcher	{
				private	$file;
				function	FileSearcher($fileName)	{
								$this->file	=	fopen($fileName,	"r");
				}
				function	getLength()	{
								$linecount	=	0;
								while	(!feof($this->file))	{
												$line	=	fgets($this->file,	4096);
												$linecount	=	$linecount	+	substr_count($line,	PHP_EOL);
								}
								return	$linecount;
				}

				private	function	goToString(int	$string)	{
								fseek($this->file,	0);		// seek to 0
								$i	=	0;
								$bufcarac	=	0;
								for	($i	=	1;	$i	<	$string;	$i++)	{
												$ligne	=	fgets($this->file);
												$bufcarac	+=	strlen($ligne);
								}

								fseek($this->file,	$bufcarac);
								return	($bufcarac);
				}
				function	getString(int	$string)	{
								$bufcarac	=	$this->goToString($string);
								return	stream_get_line($this->file,	$bufcarac,	"\x0A");
				}
				function	binarySearch($searchKey,	$left	=	0,	$right)	{
								if	($right	<=	$left){
												return	'undef';
								}
								$midle	=	(int)(($right	+	$left)	/	2);
								$curString	=	New	FileString($this->getString($midle));	
								if($curString->getKey()===$searchKey){
												return $curString;
								}
								$rezult = FileSearcher::binarySearch($searchKey,	$left,	$midle	-	1);
								if($rezult!="undef"){
												return $rezult;
								}
								return FileSearcher::binarySearch($searchKey,	$midle	+	1,	$right);
				}
}
