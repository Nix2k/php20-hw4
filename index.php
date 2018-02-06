<?php
	$appid='499d5cded32e442061029f50618471ac';
	if (isset($_GET["city"])){
		$city=$_GET["city"];
		//проверка наличия локального файла со свежими данными
		$fileName=$city.'.json';
		if ((file_exists($fileName))&&(time()-filemtime($fileName)<3600)){ //если файл существует и создан менее часа назад
			$jsonData=file_get_contents($fileName);
		}
		else { //если нет свежего файла
			$reqStr="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$appid&lang=ru";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $reqStr);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$jsonData=curl_exec($ch);
			if (curl_getinfo($ch,CURLINFO_HTTP_CODE)!='200') {
				curl_close($ch);
				$data=json_decode($jsonData);
				if (isset($data->message)) die ("Ошибка: <b>$data->message</b>");
				die ("Неизвестная ошибка");
			}
			curl_close($ch);
			file_put_contents($fileName, $jsonData);
		}
		$data=json_decode($jsonData);
		$temp=round($data->main->temp-273.15,1);
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