<?php
session_start();
include('actions/functionRedirect.php');
if (isset($_POST['add']) && empty($_FILES['userfile']['name'])) {
    header("Location:admin.php");
    exit;
}
elseif (isset($_POST) && isset($_FILES) && isset($_FILES['userfile'])) {
    $fileName = $_FILES['userfile']['name'];
    $tmpFile = $_FILES['userfile']['tmp_name'];
	$uploaddir = 'files/';
	if (!file_exists("$uploaddir")) {
	mkdir("$uploaddir", 0700);
	header("Location:admin.php");

}}

if (!empty($_FILES['userfile'])) {
    $filename = $_FILES['userfile']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

		if ($ext === 'json') {	
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
		$result='Файл успешно загружен';
		}
	 	else {
		$result='Вы загрузили не json файл';
}
}
else {
	$result='Файл не загружен';
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Генератор тестов на PHP и JSON</title>
</head>
<body>
<h1>Загрузка тестов</h1>
<form enctype="multipart/form-data" action="admin.php" method="POST">

<input name="userfile" type="file" />

<input type="submit" value="Отправить">
</form>

<?php
echo "<em>$result</em>";

?>
<p>Выберите тест для прохождения</p>

<p><a href="list.php">Список загруженных тестов</a></p>
<p><a href="delete.php">Удалить тест</a></p>
<p><a href="sessionDestroy.php">Выйти</a></p>
</body>
</html>	
