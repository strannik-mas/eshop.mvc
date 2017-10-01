<?php
class AdminController extends Controller implements IController {
	const FILE_NAME = '.htpassword';
	public function __construct(){
		parent::__construct();
		
		session_start();
		$this->_page->title = 'Авторизация';
		$this->_page->user  = '';
		
	}
	public function indexAction() {
		
		if(!$_SESSION['admin'])
		{
			$output = $this->_page->render('../views/login.php');
			
		}else{
			$output = $this->_page->render('../views/admin.php');
		}
		$this->_fc->setBody($output);		
	}
	
	public function loginAction(){
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$user = trim(strip_tags($_POST["user"]));
			$pw = trim(strip_tags($_POST["pw"]));
			/* $ref = trim(strip_tags($_GET["ref"]));
			if(!$ref)
				$ref = '/eshop/admin/'; */
			if($user and $pw){
				if($result = $this->userExists($user)){
					list($login, $password, $salt, $iteration) = explode(":", $result);
					if($this->getHash($pw, $salt, $iteration) == $password){
						$_SESSION['admin'] = true;
						//header("Location: $ref");
						$output = $this->_page->render('../views/admin.php');
					}else{
						$this->_page->title = "Неверный пароль!";	
						$output = $this->_page->render('../views/login.php');
					}
				}else{
					$this->_page->title = "Неправильное имя пользователя!";
					$output = $this->_page->render('../views/login.php');
				}
			}else{
				$this->_page->title = "Заполните все поля формы!";
				$output = $this->_page->render('../views/login.php');
			}
			$this->_fc->setBody($output);
		}
	}
	
	public function addproductAction(){
		$this->_page->categories = $this->_db->selectCategory();
		
		$output = $this->_page->render('../views/add.php');
		$this->_fc->setBody($output);
	}
	
	public function saveproductAction(){
		if($_POST){
			//получаем и обрабатываем данные из формы
			$title = $this->_db->clearStr($_POST['title']);
			$author = $this->_db->clearStr($_POST['author']);
			$pub = $this->_db->clearInt($_POST['pubyear']);
			$cat = $this->_db->clearInt($_POST['cat']);
			$price = $this->_db->clearInt($_POST['price']);
			
			if($this->_db->saveProduct($title, $author, $pub, $cat, $price))		
				$this->_page->message = 'Товар успешно добавлен!';
			else $this->_page->message = 'Произошла ошибка при добавлении товара в каталог';
			$output = $this->_page->render('../views/admin.php');
		
			$this->_fc->setBody($output);
		}
	}
	
	public function addcatAction(){
		$output = $this->_page->render('../views/addcat.php');
		$this->_fc->setBody($output);
	}
	
	public function  savecatAction(){
		if($_POST){
			$name = $this->_db->clearStr($_POST['name']);
		}
		if($this->_db->saveCategory($name))		
			$this->_page->message = 'Категория успешно добавлена!';
		else $this->_page->message = 'Произошла ошибка при добавлении категории';
		$output = $this->_page->render('../views/admin.php');
	
		$this->_fc->setBody($output);
	}
		
	public function getordersAction(){
		//заказы
		$this->_page->orders = $this->_db->getOrders();
		
		$output = $this->_page->render('../views/orders.php');
	
		$this->_fc->setBody($output);
	}
	
	public function adduserAction(){
		$output = $this->_page->render('../views/adduser.php');
		$this->_fc->setBody($output);
	}
	
	public function saveuserAction(){
		if (!$salt)
			$salt = str_replace('=', '', base64_encode(md5(microtime() . '1FD37EAA5ED9425683326EA68DCD0E59')));

		if ($_SERVER['REQUEST_METHOD']=='POST'){
			if(!$this->userExists($_POST['user'])){
				$salt = $_POST['salt'] ?: $salt;
				$resHash = $this->getHash($_POST['string'], $salt, $_POST['n']);
				$result = 'Хеш '. $resHash. ' успешно создан';
				if($this->saveHash($_POST['user'], $resHash, $salt, $_POST['n']))
					$result = 'Хеш '. $resHash. ' успешно добавлен в файл';
				else
					$result = 'При записи хеша '. $resHash. ' произошла ошибка';
			}else{
				$result = "Пользователь $user уже существует. Выберите другое имя.";
			}
		}
		
		$this->_page->message = $result;
		$output = $this->_page->render('../views/admin.php');
	
		$this->_fc->setBody($output);
	}
	
	private function userExists($login){
		if(!is_file(self::FILE_NAME))
			return false;
		$users = file(self::FILE_NAME);
		foreach($users as $user){
			if(strpos($user, $login) !==false)
				return $user;
		}
		return false;
	}
	
	private function getHash($string, $salt, $iterationCount){
		for($i=0; $i<$iterationCount; $i++){
			$string = sha1($string.$salt);
		}
		return $string;
	}
	
	function saveHash($user, $hash, $salt, $iteration){
		$str = "$user:$hash:$salt:$iteration\n";
		if(file_put_contents(self::FILE_NAME, $str, FILE_APPEND))
			return true;
		else
			return false;
	}
	
	function logoutAction(){
		session_destroy();
		$output = $this->_page->render('../views/login.php');
		$this->_fc->setBody($output);
	}
}
