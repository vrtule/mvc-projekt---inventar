<?php
class PrihlaseniController extends Controller
{
    public function process($parameters)
    {
		$users_manager = new UsersManager();
		$this->header['title'] = 'Přihlášení';
		if ($_POST)
		{
			try
			{
				$users_manager->login($_POST['uzivatelske_jmeno'], $_POST['heslo']);				
				$this->addMessage('Byl jste úspěšně přihlášen.');
				$this->redirect('inventar');
			}
			catch (UserError $error)
			{
				$this->addWarning($error->getMessage());
			}
		}

		$this->view = 'login';
    }
}