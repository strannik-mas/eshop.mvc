<?php
class DB{
	const DB_HOST = 'localhost';
	const DB_NAME = 'eshop';
	const DB_LOGIN = 'root';
	const DB_PASSWORD = ''; 
	public $_link;
	static protected $_instance = null;
	private function __construct(){
		$this->_link = mysqli_connect(self::DB_HOST, self::DB_LOGIN, self::DB_PASSWORD, self::DB_NAME) or die(mysqli_connect_error());
	}
	private function __clone(){}
	function __destruct(){
		unset($this->_link);
	}
	static function getInstance(){
		if(!self::$_instance instanceof self){
            self::$_instance = new self;
        }
        return self::$_instance;
	}
	
	//для обработки данных
	function clearInt($data){
		return abs((int)$data);
	}
	function clearStr($data){
		return mysqli_real_escape_string($this->_link, trim(strip_tags($data)));
	}
	/* Перегоняем объект в массив для удобства использования */
	protected function result2Array($data){
		$arr = array();
		while($row = mysqli_fetch_assoc($data))
			$arr[] = $row;
		return $arr;	
	}
	/* Выборка каталога по id категории*/
	function selectItems($id){
		try{
			$sql = "SELECT id, title, author, pubyear, price FROM catalog WHERE category_id = $id";
			$result = $this->_link->query($sql);
			if (!is_object($result)) 
				throw new Exception($this->_link->error);
			return $this->result2Array($result);
		}catch(Exception $e){
			return false;
		}	
	}
	
	function selectCategory(){
		try{
			$sql = "SELECT id, name FROM category";
			$result = $this->_link->query($sql);
			if (!is_object($result)) 
				throw new Exception($this->_link->error);
			return $this->result2Array($result);
		}catch(Exception $e){
			return false;
		}	
	}
	
	function getId($id){
		try{
			$sql = "SELECT category_id FROM catalog WHERE id = $id";
			$result = mysqli_fetch_assoc($this->_link->query($sql));
			if (!is_array($result)) 
				throw new Exception($this->_link->error);
			return $result;
		}catch(Exception $e){
			return false;
		}	
	}
	function getBasket($id){
		try{
			$sql = "SELECT t1.order_id, t1.product_id, t1.quantity, t1.id as basket_id, t2.id, t2.title, t2.author, t2.pubyear, t2.price FROM basket t1, catalog t2 
			WHERE t1.order_id = '$id' AND t1.product_id = t2.id";
			$result = $this->_link->query($sql);
			if (!is_object($result)) 
				throw new Exception($this->_link->error);
			return $this->result2Array($result);
		}catch(Exception $e){
			return false;
		}	
	}
	
	function saveBasket($order_id, $id){
		try{
			$sql = "INSERT INTO basket (order_id, product_id, quantity) VALUES ('$order_id', $id, 1)";
			$result = $this->_link->query($sql);
			if (!is_object($result)) 
				throw new Exception($this->_link->error);
			return true;
		}catch(Exception $e){
			return false;
		}	
	}
	
	function deleteItemFromBasket($id){
		try{
			$sql = "DELETE FROM basket WHERE id = $id";
			$result = $this->_link->query($sql);
			if (!$result) 
				throw new Exception($this->_link->error);
			return true;
		}catch(Exception $e){
			return false;
		}	
	}
	
	function saveContacts($n, $e, $p, $a, $dt){
		$sql = 'INSERT INTO contacts (name, email, phone, address, order_time) 
				VALUES (?, ?, ?, ?, ?)';
		if (!$stmt = mysqli_prepare($this->_link, $sql))
			return false;
		mysqli_stmt_bind_param($stmt, 'ssisi', $n, $e, $p, $a, $dt);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return true;
	}
	
	function saveOrder($id, $datetime){
		$goods = $this->getBasket($id);
		$sql = 'INSERT INTO orders (title, author, pubyear, price, quantity, orderid, datetime) 
				VALUES (?, ?, ?, ?, ?, ?, ?)';
		if (!$stmt = mysqli_prepare($this->_link, $sql))
			return false;
		foreach ($goods as $item){
			mysqli_stmt_bind_param($stmt, 'ssiiisi', $item['title'], $item['author'], $item['pubyear'], $item['price'], $item['quantity'], $id, $datetime);
			mysqli_stmt_execute($stmt);
		}  
		mysqli_stmt_close($stmt);
		try{
			$sql = "DELETE FROM basket";
			$result = $this->_link->query($sql);
			if (!$result) 
				throw new Exception($this->_link->error);
			return true;
		}catch(Exception $e){
			return false;
		}	
	}
	
	function saveProduct($title, $author, $pub, $cat, $price){
		$sql = 'INSERT INTO catalog (title, author, pubyear, category_id, price) 
				VALUES (?, ?, ?, ?, ?)';
		if (!$stmt = mysqli_prepare($this->_link, $sql))
			return false;
		mysqli_stmt_bind_param($stmt, 'ssiii', $title, $author, $pub,$cat, $price);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return true;
	}
	
	function saveCategory ($n){
		$sql = 'INSERT INTO category (name) 
				VALUES (?)';
		if (!$stmt = mysqli_prepare($this->_link, $sql))
			return false;
		mysqli_stmt_bind_param($stmt, 's', $n);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return true;
	}
	
	function getOrders(){
		$allorders = array();
		try{
			$sql = "SELECT DISTINCT t1.orderid, t1.datetime, t2.name, t2.email, t2.phone, t2.address FROM orders t1 , contacts t2 WHERE t1.datetime = t2.order_time";
			$result = $this->_link->query($sql);
			if (!is_object($result)) 
				throw new Exception($this->_link->error);
			$orders = $this->result2Array($result);
			
			foreach($orders as $order){
				$sql = "SELECT title, author, pubyear, price, quantity FROM orders WHERE orderid = '".$order['orderid']."'";
				$result = $this->_link->query($sql);
				if (!is_object($result)) 
					throw new Exception($this->_link->error);
				$goods = $this->result2Array($result);
				$order["goods"]=$goods;
				$allorders[] = $order;
			}
			
			return $allorders;
		}catch(Exception $e){
			return false;
		}	
	}
}
?>