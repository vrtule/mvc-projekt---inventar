<?php
class InventarController extends Controller
{
    public function process($parameters) {
        $this->checkUser();

        $inventory_manager = new InventoryManager();
        $users_manager = new UsersManager();
        $user = $users_manager->returnUser();
        
        $this->data['admin'] = $user && $user['admin'];
		
        if (!empty($parameters[1]) && $parameters[1] == 'odstranit') {
            $this->checkUser(true);
            $inventory_manager->deleteItem($parameters[0]);
            $this->addMessage('Pojištěnec byl úspěšně odstraněn');
            $this->redirect('inventar');
		
        } else if (!empty($parameters[0])) {

            $detail = $inventory_manager->returnOne($parameters[0]);
			
			
            if (!$detail) {
                $this->redirect('error');
            }
                

            $this->header = array(
                'title' => "Inventář"
            );
            
            $this->view = 'detail';
        } else {
            $inventory = $inventory_manager->returnAll();
            $this->data['inventory'] = $inventory;
            
            $count = Db::returnCount();
            $this->data['count'] = $count['num'];
            
            $this->view = 'inventory';
        }
    }
}