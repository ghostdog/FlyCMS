<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of examples
 *
 * @author Marek
 */


class Controller_Examples extends Controller {
    public function action_index() {
        $love = new Examples_MyLove();
        $this->request->response = $love->show_love();
    }
}


?>
