<?php
class Basket{
	public $count = 0, $goods; 
	
	public function basketInit(){
		session_start();
		if(!isset($_SESSION['order_id'])){
			$_SESSION['order_id'] = uniqid();
		}else{
			$this->goods = DB::getInstance()->getBasket($_SESSION['order_id']);
			$this->count = count($this->goods); //не то считает
		}	
	}
}
?>