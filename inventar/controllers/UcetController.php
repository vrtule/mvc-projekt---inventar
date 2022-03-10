<?php
class UcetController extends Controller
{
    public function process($parameters)
    {		
		$this->checkUser();
		
		$this->header['title'] = 'Můj účet';
		
		$users_manager = new UsersManager();
		if (!empty($parameters[0]) && $parameters[0] == 'odhlasit') {
			$users_manager->signOut();
			$this->redirect('prihlaseni');
		}
		$user = $users_manager->returnUser();
		$this->data['uzivatelske_jmeno'] = $user['uzivatelske_jmeno'];
		$this->data['admin'] = $user['admin'];
		
		$this->view = 'account';
    }
}