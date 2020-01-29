<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_regex_encoding('UTF-8');
$patch = $_SERVER["DOCUMENT_ROOT"]."/files";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Тестик</title>
	</head>
	<body>
		<form method="POST" action="/pages/search.php">
		<div>
			<h3>Выберите файл из списка:</h3>
		<?php
			$d = dir($patch);
			while (($entry = $d->read())) {
				if($entry!=".."&&$entry!="."){
					echo "<input type='radio' name='Filename' required = 'required' value='$entry'/>$entry<br/>";
				}
			}
		?>
		<h3>Поиск по файлу:</h3>
		<p>Введите ключевое слово для поиска:<br>
			<input type='text' name='Key' required="required">
		</p>
		<input type="submit" value="Найти">
		</div>
		</form>
	</body>
</html>