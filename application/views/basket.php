<head>
	<title>Корзина пользователя</title>
</head>
<body>
	<h1>Ваша корзина</h1>
<?php
//var_dump($this->goods);
	if(!is_array($this->goods)){
		echo 'Произошла ошибка при выводе товаров! Вернитесь на '.'<a href="/">главную</a>';
		exit;
	}
	if (!$this->goods){
		echo 'Корзина пуста! Вернитесь на '."<a href='/'>главную</a>";
		exit;
	}else {
		echo '<p>Вернуться на <a href="/">главную</a></p>';
	}
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Удалить</th>
</tr>
<?php
	$i = 1; $sum=0;
	foreach($this->goods as $item){
?>
		<tr>
			<td><?php echo $i?></td>
			<td><?php echo $item['title']?></td>
			<td><?php echo $item['author']?></td>
			<td><?php echo $item['pubyear']?></td>
			<td><?php echo $item['price']?></td>
			<td><a href="/basket/delete/<?php echo $item['basket_id']?>">Удалить</a></td>
		</tr>
<?php
	$i++;
	$sum += $item['price'];
	}
?>
</table>

<p>Всего товаров в корзине на сумму: <?php echo $sum?> руб.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='/order/'" />
</div>

</body>