<?php
class BasketController extends Controller implements IController {
	public function __construct(){
		parent::__construct();
		session_start();
	}
	public function indexAction() {
		$this->_page->goods = $this->_db->getBasket($_SESSION['order_id']);
//var_dump($_SESSION['order_id'], $this->_page->goods);
		$output = $this->_page->render('../views/basket.php');
		
		$this->_fc->setBody($output);
	}
	
	public function add2basketAction(){
		
		
		//получим id товара
		$params = $this->_fc->getParams();
		$this->_db->saveBasket($_SESSION['order_id'], $params);
				
		//получим id категории 
		$catID = $this->_db->getId($params);	
		$this->_page->goods = $this->_db->selectItems($catID['category_id']);
		
		
		//количество товаров в корзине
		$this->_basket->basketInit();
		$this->_page->count = $this->_basket->count;
		
		$output = $this->_page->render('../views/catalog.php');
		
		$this->_fc->setBody($output);
	}
	
	public function deleteAction(){
		$params = $this->_fc->getParams();
		if($this->_db->deleteItemFromBasket($params))
			$this->indexAction();
		else echo "<h2>Произошла ошибка при удалении товара из корзины</h2>";
	}
}
