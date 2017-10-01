<head>
	<title>Поступившие заказы</title>
</head>
<body>
<h1>Поступившие заказы:</h1>
<?php
	if(!is_array($this->orders)){
			echo 'Заказов нет! Вернитесь в '."<a href='/admin/'>меню</a>";
			exit;
	}

	foreach ($this->orders as $order){	
		$i = 1; $sum=0;
?>
<hr>
<h2>Заказ номер: <?php echo $order['orderid']?></h2>
<p><b>Заказчик</b>: <?php echo $order['name']?></p>
<p><b>Email</b>: <?php echo $order['email']?></p>
<p><b>Телефон</b>: <?php echo $order['phone']?></p>
<p><b>Адрес доставки</b>: <?php echo $order['address']?></p>
<p><b>Дата размещения заказа</b>: <?php echo date("d-m-Y H:i", $order['datetime'])?></p>

<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
</tr>
<?php
		foreach ($order['goods'] as $item){			
?>
<tr>
	<td><?php echo $i?></td>
	<td><?php echo $item['title']?></td>
	<td><?php echo $item['author']?></td>
	<td><?php echo $item['pubyear']?></td>
	<td><?php echo $item['price']?></td>
</tr>
<?php
			$i++;
			$sum += $item['price']*$item['quantity'];	
		}		
?>
</table>
<p>Всего товаров в заказе на сумму: <?php echo $sum?> руб.</p>
<?php
		
	}
	echo  'Вернуться в '."<a href='/admin/'>меню</a>";
?>	
</body>