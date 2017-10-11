<?php

include_once 'global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$pc = new SiteController();
$pc->route($action);

class SiteController {

	// route us to the appropriate class method for this action
	public function route($action) {
		switch($action) {
			case 'welcome':
			$this->welcome();
			break;

			case 'home':
			$this->home();
			break;

			// redirect to home page if all else fails
			default:
			header('Location: '.BASE_URL);
			exit();

		}

	}

	public function welcome() {
		$pageName = 'Welcome';
		include_once SYSTEM_PATH.'/view/header.html';
		include_once SYSTEM_PATH.'/view/welcome.html';
		include_once SYSTEM_PATH.'/view/footer.html';
	}

	public function home() {
		$pageName = 'Home';
		include_once SYSTEM_PATH.'/view/header.html';
		include_once SYSTEM_PATH.'/view/home.html';
		include_once SYSTEM_PATH.'/view/footer.html';
	}
}