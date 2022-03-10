<?php
class RegistraceController extends Controller
{
    public function process($parameters) {		
		
		$this->header['title'] = 'Registrace';
		if ($_POST) {
			try {
				$users_manager = new UsersManager();
				$users_manager->signUp($_POST['uzivatelske_jmeno'], $_POST['email'], $_POST['heslo'], $_POST['heslo_znovu']);
				$users_manager->login($_POST['uzivatelske_jmeno'], $_POST['heslo']);				
				$this->addMessage('Byl jste úspěšně zaregistrován.');
				$this->redirect('ucet');
			} catch (UserError $error) {
				$this->addMessage($error->getMessage());
			}
		}
		$this->view = 'signup';
    }
}