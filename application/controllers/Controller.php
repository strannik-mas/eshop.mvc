<?php
class Controller{
	protected $_fc, $_db, $_page, $_basket;
	function __construct(){
		$this->_fc = FrontController::getInstance();
		/* ������������� ������ ���� ������*/
		$this->_db = DB::getInstance();
		$this->_page = new Page();
		$this->_basket = new Basket();
	}
}
?>