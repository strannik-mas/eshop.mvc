<head>
	<title>Админка</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body>
	<h1>Администрирование магазина</h1>
	<ul>
		<li><a href='/admin/addcat/'>Добавление категории товаров в каталог</a></li>
		<li><a href='/admin/addproduct/'>Добавление товара в каталог</a></li>
		<li><a href='/admin/getorders/'>Просмотр готовых заказов</a></li>
		<li><a href='/admin/adduser/'>Добавить пользователя</a></li>
		<li><a href='/admin/logout/'>Завершить сеанс</a></li>
	</ul>
<?php
	if($this->message)
		echo "<h2>$this->message</h2>";
?>
</body>