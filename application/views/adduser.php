<head>
	<title>Добавление пользователя</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<body>
<h1>Добавление пользователя</h1>

<form action="/admin/saveuser/" method="post">
	<div>
		<label for="txtUser">Логин</label>
		<input id="txtUser" type="text" name="user" required style="width:40em"/>
	</div>
	<div>
		<label for="txtString">Пароль</label>
		<input id="txtString" type="text" name="string" required style="width:40em"/>
	</div>
	<div>
		<label for="txtSalt">Соль</label>
		<input id="txtSalt" type="text" name="salt" style="width:40em"/>
	</div>	
	<div>
		<label for="txtIterationCount">Число иттераций</label>
		<input id="txtIterationCount" type="range" min="1" max="100" name="n" required style="width:40em" placeholder="Введите число от 1 до 100"/>
	</div>		
	<div>
		<button type="submit">Создать</button>
	</div>	
</form>
</body>