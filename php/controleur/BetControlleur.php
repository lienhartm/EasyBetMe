<?php

class BettControlleur {
    
    public function betPage() {

        require "view/index.php";

    }

    public function betIdAndDate($id, $date) {

            $date = date('Y-m-d');
            $Check = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? AND date=?');
            $Check->execute([$User['id'], $date]);
            $nbCheck = $Check->rowCount();
            $CheckParty = $Check->fetchAll();
            $Check_idGame = array_column($CheckParty, 'id_game');
            
        require "view/index.php";

    }

}

?>
