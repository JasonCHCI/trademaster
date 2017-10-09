<?php

include_once 'global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a ProductController and route it
$pc = new StockController();
$pc->route($action);

class StockController {

	// route us to the appropriate class method for this action

	public function route($action) {
		switch($action) {

			/* This is an example of how to add your page
			case 'stocks':
			$productType = $_GET['ptype'];
			if($productType == 'stock') {
				$this->stock();
			}
			*/

			// redirect to home page if all else fails
			default:
			header('Location: '.BASE_URL);
			exit();
		}

	}



}
