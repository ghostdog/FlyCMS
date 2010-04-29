<?php

class Controller_Admin_Menus extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->template = View::factory('template');
    }

    public function action_index() {

        $this->action_add();
    }
    
    public function action_add() {
        if ($_POST) {
            fire::log($_POST, 'post');
        }
        $menus = ORM_MPTT::factory('menu');
        $this->template->content = View::factory('menu/add_template');
    }


}
?>
