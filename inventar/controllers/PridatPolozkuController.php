<?php
class PridatPolozkuController extends Controller
{
    public function process($parameters) {

        $this->checkUser(true);

        $this->header['title'] = 'Přidání položky';

        $detail = array(
            'zbozi_id',
            'nazev' => '',
            'kategorie' => '',
            'popis' => '',
            'mnozstvi_skladem' => '',
            'cena_s_DPH' => ''
        );

        if ($_POST) {
            $keys = array('nazev', 'kategorie', 'popis', 'mnozstvi_skladem', 'cena_s_DPH');
            $detail = array_intersect_key($_POST, array_flip($keys));

            Db::insert('zbozi', $detail);
            $this->addMessage('Položka úspěšně přidána');
            
            $this->redirect('inventar/' . $detail['zbozi_id']);

        } 

        $this->data['detail'] = $detail;
        $this->view = 'addItem';

    }
}