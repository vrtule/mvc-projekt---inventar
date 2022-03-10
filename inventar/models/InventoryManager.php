<?php
class InventoryManager
{
    public function returnOne($id) {
        return Db::queryForOne('
        SELECT `zbozi_id`, `nazev`, `kategorie`, `popis`, `mnozstvi_skladem`, `cena_s_DPH`
        FROM `zbozi`
        WHERE `zbozi_id` = ?
        ', array($id));
    }

    public function returnAll() {
        return Db::queryForAll('
        SELECT `zbozi_id`, `nazev`, `kategorie`, `popis`, `mnozstvi_skladem`, `cena_s_DPH`
        FROM `zbozi`
        ORDER BY `zbozi_id` DESC
        ');
    }
	
    public function deleteItem($id) {
		Db::query('
			DELETE FROM zbozi
			WHERE zbozi_id = ?
		', array($id));
	}

    
}