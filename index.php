<?php
$link = mysqli_connect('localhost', 'root', '', 'obor') or die(mysqli_error($link));
header('Content-type: text/html; charset=utf-8');

$file =  fopen('pricelist.csv','r');

	echo '<table cellspacing= "0" border ="1" width = "500">';
	while (!feof($file)){
		$mass = fgetcsv($file, 1024, ';');
		if (count($mass) > 1){
		echo '<tr align = "center">';
		    echo '<td width = "25%">';
		    echo $mass[0];
			echo '</td>';
		    echo '<td width = "25%">';
		    echo $mass[1];
			echo '</td>';
			echo '<td width = "25%">';
		    echo $mass[2];
			echo '</td>';
			echo '<td width = "25%">';
		    echo $mass[3];
			echo '</td>';
			echo '<td width = "25%">';
		    echo $mass[4];
			echo '</td>';
			echo '<td width = "25%">';
		    echo $mass[5];
			echo '</td>';
			echo '<td width = "25%">';
		    echo $mass[6];
			echo '</td>';
		echo '</tr>';

$query = "INSERT INTO price (name,unit_price, opt_price,pcs_1,pcs_2,country,notes) VALUES ('{$mass[0]}','{$mass[1]}','{$mass[2]}','{$mass[3]}','{$mass[4]}','{$mass[5]}','{$mass[6]}')";

$result = mysqli_query($link, $query) or die( mysqli_error($link) );

}
	}
		echo '</table>';
		
//Общее количество товаров на Складе1 и на Складе2		
$query_sum1 = "SELECT SUM(pcs_1) FROM price WHERE id > 1";
$result_sum1 = mysqli_query($link, $query_sum1) or die(mysqli_error($link));
$row_sum1 = mysqli_fetch_assoc($result_sum1);

$query_sum2 = "SELECT SUM(pcs_2) FROM price WHERE id > 1";
$result_sum2 = mysqli_query($link, $query_sum2) or die(mysqli_error($link));
$row_sum2 = mysqli_fetch_assoc($result_sum2);
echo 'сумма '.array_sum($row_sum1+$row_sum2).'<br/>';


//Вывести среднюю стоимость розничной цены товара
$query_cnt = "SELECT COUNT(unit_price) FROM price WHERE id > 1";
$result_cnt = mysqli_query($link, $query_cnt) or die(mysqli_error($link));
$row_cnt = mysqli_fetch_assoc($result_cnt);

$query_sum = "SELECT SUM(unit_price) FROM price WHERE id > 1";
$result_sum = mysqli_query($link, $query_sum) or die(mysqli_error($link));
$row_sum = mysqli_fetch_assoc($result_sum);
echo 'Средняя стоимость розничной цены '. array_sum($row_sum)/$row_cnt["COUNT(unit_price)"].'<br/>';


//Вывести под таблицей среднюю стоимость оптовой цены товара
$query_cnt2 = "SELECT COUNT(opt_price) FROM price WHERE id > 1";
$result_cnt2 = mysqli_query($link, $query_cnt2) or die(mysqli_error($link));
$row_cnt2 = mysqli_fetch_assoc($result_cnt2);

$query_sum2 = "SELECT SUM(opt_price) FROM price WHERE id > 1";
$result_sum2 = mysqli_query($link, $query_sum2) or die(mysqli_error($link));
$row_sum2 = mysqli_fetch_assoc($result_sum2);
echo 'Средняя стоимость оптовой цены '.array_sum($row_sum2)/$row_cnt2["COUNT(opt_price)"].'<br/>';

//Самый дорогой товар
$query_max = "SELECT MAX(unit_price) FROM price WHERE id > 1";
$result_max = mysqli_query($link, $query_max) or die(mysqli_error($link));
$row_max = mysqli_fetch_assoc($result_max);
echo 'Самый дорогой товар '.$row_max['MAX(unit_price)'].'<br/>';
 

//Самый дешевый товар
$query_min = "SELECT MIN(opt_price) FROM price WHERE id > 1";
$result_min = mysqli_query($link, $query_min) or die(mysqli_error($link));
$row_min = mysqli_fetch_assoc($result_min);
 echo 'Самый дешевый товар '.$row_min['MIN(opt_price)'].'<br/>';

fclose($file);
	
?>