<?php
abstract class Controller
{
    protected $data = array();
    protected $view = "";
    protected $header = array('title' => '');

    abstract function process($parameters);

    public function printView() {
        if ($this->view) {
            extract($this->data);
            require("views/" . $this->view . ".phtml");
        }
    }
	
	public function redirect($url) {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }
    
	public function checkUser($admin = false) {
    $users_manager = new UsersManager();
    $user = $users_manager->returnUser();
        if (!$user) {
            $this->addWarning('Nedostatečná oprávnění.');
            $this->redirect('prihlaseni');
        } else if ($admin && !$user['admin']) {
            $this->addWarning('Nedostatečná oprávnění.');
            $this->redirect('ucet');
        }
    }
	
    public function addMessage($message) {
		if (isset($_SESSION['messages'])) {
            $_SESSION['messages'][] = $message;
        } else {
            $_SESSION['messages'] = array($message);
        }
    }		

    public function showMessage() {
        if (isset($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        } else {
            return array();
        }
    }
    
    public function addWarning($warning) {
        if (isset($_SESSION['warnings'])) {
            $_SESSION['warning'][] = $warning;
        } else {
            $_SESSION['warnings'] = array($warning);
        }
    }
    
    public function showWarning() {
        if (isset($_SESSION['warnings'])) {
            $warnings = $_SESSION['warnings'];
            unset($_SESSION['warnings']);
            return $warnings;
        } else {
            return array();
        }
    }

    
}


