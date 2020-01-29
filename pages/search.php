<?php
//include_once 'function.php';
include_once 'fileSearcer.php';
if (!isset($_POST["Key"]) || !isset($_POST["Filename"])) {
	exit("Нет данных");
}
$filename = $_SERVER["DOCUMENT_ROOT"] . "/files/" . $_POST["Filename"];
$searcer = new FileSearcher($filename);
//echo $searcer->getLength();
$rezult = $searcer->binarySearch($_POST["Key"], 0, $searcer->getLength());
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Тестик</title>
	</head>
	<body>
		<h1>Результаты поиска</h1>
		<p>По запросу: "<?php echo $_POST["Key"]; ?>"
<?php
if ($rezult == "undef") {
	echo "ничего не найдено!";
} else {
	echo "найдено:";
	echo "<p><b>" . $rezult->getKey() . "</b> " . $rezult->getValue() . "</p>";
}
?>
			<a href="/">Назад</a>
		</p>
	</body>
</html>



