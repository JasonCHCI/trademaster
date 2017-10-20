<?php

include_once 'global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$pc = new SiteController();
$pc->route($action);

class SiteController
{

    // route us to the appropriate class method for this action
    public function route($action)
    {
        switch ($action) {
            case 'welcome':
                $this->welcome();
                break;

            case 'home':
                $this->home();
                break;

            case 'membership':
                $this->membership();
                break;
            case 'pricing':
                $this->pricing();
                break;

            case 'trade':
                $this->trade();
                break;

            // redirect to home page if all else fails
            default:
                header('Location: ' . BASE_URL);
                exit();

        }

    }

    public function welcome()
    {
        $pageName = 'Welcome';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/welcome.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }

    public function home()
    {
        $pageName = 'Home';

        $result = Test::getAllStocks();
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/home.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }

    public function membership()
    {
        $pageName = 'Membership';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/membership.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }
    public function pricing()
    {
        $pageName = 'Pricing';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/stock_info.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }

    public function trade()
    {
        $pageName = 'Trade';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/trade.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }
}
