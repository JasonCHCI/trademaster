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

            case 'login':
                $this->login();
                break;

            case 'processLogin':
                $username = $_POST['un'];
                $password = $_POST['pw'];
                $this->processLogin($username, $password);
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

        $holdings = Hold::getHoldsByUserId(1);
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/home.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }

    public function login()
    {

        $pageName = 'Login';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/login.html';
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
    public function market()
    {
        $pageName = 'market';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/market.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }

    public function processLogin($u, $p) {
        $db = Db::instance();
        $q = "SELECT * FROM user WHERE username = '$u'; ";
        $result = mysql_query($q);
        if (!$result) {
            die("Incorrect username or password.");
            exit();
        }
        else {
            $adminUsername = '';
            $adminPassword = '';
            $id = 0;
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $adminUsername = $row["username"];
                $adminPassword = $row["password"];
                $id = $row["id"];
            }

            if(($u == $adminUsername) && ($p == $adminPassword)) {
                session_start();
                $_SESSION['user'] = $u;
                $_SESSION['id'] = $id;
                header('Location: '.BASE_URL);
                exit();
            } else {
                $message ="Incorrect username or password.";
                //pop up the aleat message
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }
        $pageName = 'Login';
        include_once SYSTEM_PATH.'/view/header.html';
        include_once SYSTEM_PATH.'/view/login.html';
        include_once SYSTEM_PATH.'/view/footer.html';

    }

    public function trade()
    {
        $pageName = 'Trade';
        include_once SYSTEM_PATH . '/view/header.html';
        include_once SYSTEM_PATH . '/view/trade.html';
        include_once SYSTEM_PATH . '/view/footer.html';
    }
}
