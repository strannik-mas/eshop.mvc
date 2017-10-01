<?php
class IndexController extends Controller implements IController {

	public function indexAction() {
		$this->_page->params = $this->_db->selectCategory();

		$output = $this->_page->render('../views/index.php');
		
		$this->_fc->setBody($output);
	}
	
	public function catalogAction(){	
		$this->_page->goods = $this->_db->selectItems($this->_fc->getParams());
		//количество товаров в корзине
		$this->_basket->basketInit();
		$this->_page->count = $this->_basket->count;
		
		$output = $this->_page->render('../views/catalog.php');
		
		$this->_fc->setBody($output);
		
	}
	
	
}
