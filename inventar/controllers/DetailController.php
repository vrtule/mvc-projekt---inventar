<?php
class DetailController extends Controller
{
    public function process($parameters) {

        $this->checkUser();

        $this->header['title'] = 'Detail produktu';

        $inventory_manager = new InventoryManager();
        $users_manager = new UsersManager();
        $user = $users_manager->returnUser();
        
        $this->data['admin'] = $user && $user['admin'];


        $detail = array(
            'zbozi_id' => '',
            'nazev' => '',
            'kategorie' => '',
            'popis' => '',
            'mnozstvi_skladem' => '',
            'cena_s_DPH' => ''
        );

        if ($_POST) {
            $keys = array('nazev', 'kategorie', 'popis', 'mnozstvi_skladem', 'cena_s_DPH');
            $detail = array_intersect_key($_POST, array_flip($keys));

            Db::update('zbozi', $detail, 'WHERE zbozi_id = ?', array($_POST['zbozi_id']));
            $this->addMessage('Položka úspěšně změněna');
            
            $this->redirect('inventar/');

        } else if (!empty($parameters[0])) {
            $loadedItem = $inventory_manager->returnOne($parameters[0]);
            if ($loadedItem) {
                $detail = $loadedItem;
            } else {
                $this->addWarning('Položka nebyla nalezena');
            }
        }

        $this->data['zbozi_id'] = $detail['zbozi_id'];
        $this->data['nazev'] = $detail['nazev'];
        $this->data['kategorie'] = $detail['kategorie'];
        $this->data['popis'] = $detail['popis'];
        $this->data['mnozstvi_skladem'] = $detail['mnozstvi_skladem'];
        $this->data['cena_s_DPH'] = $detail['cena_s_DPH'];
        

        $this->view = 'detail';

    }
}