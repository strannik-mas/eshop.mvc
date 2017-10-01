<head>
	<title>Форма добавления товара в каталог</title>
</head>
<body>
	<form action="/admin/savecat/" method="post" id="addForm">
		<label for="namecat">Название категории: </label><input type="text" name="name" size="30" required>
		<input type="submit" value="Добавить">
	</form>
</body>