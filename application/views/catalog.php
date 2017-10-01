<head>
	<title>Каталог товаров</title>
	
</head>
<body>
<p><a href="/">Главная</a></p>
<p>Товаров в <a href="/basket/">корзине</a>: <?php echo $this->count ?></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>В корзину</th>
</tr>
<tr>
<?php
	if(!is_array($this->goods)){
		echo 'Произошла ошибка при выводе товаров';
		exit;
	}
	if (!$this->goods){
		echo 'В данной категории товаров нет.';
		exit;
	}
	foreach($this->goods as $item){
?>
		<tr>
			<td><?php echo $item['title']?></td>
			<td><?php echo $item['author']?></td>
			<td><?php echo $item['pubyear']?></td>
			<td><?php echo $item['price']?></td>
			<td><a href="/basket/add2basket/<?php echo $item['id']?>">В корзину</a></td>
		</tr>
<?php
	}
?>
</table>
</body>