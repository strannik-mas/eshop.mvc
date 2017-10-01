<head>
	<title>Форма добавления товара в каталог</title>
</head>
<body>
	<form action="/admin/saveproduct/" method="post" id="addForm">
		<p>Название: <input type="text" name="title" size="100" required>
		<p>Автор: <input type="text" name="author" size="50" required>
		<p>Год издания: <input type="text" name="pubyear" size="4">
		<p>Категория: <select name="cat" form="addForm">
			<?php foreach($this->categories as $item) { 
				echo "<option value='".$item['id']."'>".$item['name']."</option>";
			}
			?>
		</select>
		<p>Цена: <input type="text" name="price" size="6" required> руб.
		<p><input type="submit" value="Добавить">
	</form>
</body>