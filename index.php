<?php
	$appid='499d5cded32e442061029f50618471ac';
	if (isset($_GET["city"])){
		$city=$_GET["city"];
		$reqStr="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$appid&lang=ru";
		$jsonData=file_get_contents($reqStr);
		$data=json_decode($jsonData);
		$temp=round($data->main->temp-273,15);
		$pressure=round($data->main->pressure*0.75006375541921);
		$humidity=$data->main->humidity;
		$weather=$data->weather[0]->description;
		$wIco=$data->weather[0]->icon;
	}
	else die("параметр сity обязателен<br>Например: <i>index.php?city=Moscow</i>");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Домашнее задание к лекции 1.4 «Стандартные функции»</title>
</head>
<body>
	<h1>Погода в <?= $city?></h1>
	<p>Температура воздуха: <i><?= $temp?>&deg;C</i></p>
	<p>Погодные условия: <img src="http://openweathermap.org/img/w/<?= $wIco?>.png"><i><?= $weather?></i></p>
	<p>Атмосферное давление: <i><?= $pressure?> мм рт. ст.</i></p>
	<p>Влажность воздуха: <i><?= $humidity?>%</i></p>
</body>
</html>