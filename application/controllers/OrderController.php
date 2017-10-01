<?php
class OrderController extends Controller implements IController {
	public function __construct(){
		parent::__construct();
		session_start();
	}
	
	public function indexAction() {
		$output = $this->_page->render('../views/order.php');
		
		$this->_fc->setBody($output);
	}
	
	public function saveorderAction(){	
		if($_POST){
			//получаем и обрабатываем данные из формы
			$n = $this->_db->clearStr($_POST['name']);
			$e = $this->_db->clearStr($_POST['email']);
			$p = $this->_db->clearInt($_POST['phone']);
			$a = $this->_db->clearStr($_POST['address']);
			$dt = time();
			$this->_db->saveContacts($n, $e, $p, $a, $dt);
			
			$this->_db->saveOrder($_SESSION['order_id'], $dt);
			
			
			$output = $this->_page->render('../views/saveorder.php');
		
			$this->_fc->setBody($output);
		}		
	}	
}
