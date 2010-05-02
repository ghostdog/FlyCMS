<?php

class Controller_Admin_Menus extends Controller_Admin_Admin {

    private $group;
    private $items;
    
    public function before() {
        parent::before();
        $this->group = ORM::factory('menugroup');
        $this->items = ORM::factory('menuitem');
    }
    public function action_index() {
        $this->action_add();
    }
    
    public function action_add() {
        $this->template->content = View::factory('menu/create_frm')
             ->bind('group', $this->group)
             ->bind('items_count', $items_count)
             ->bind('items', $items);
        if ($_POST) {
            fire::log($_POST, 'post');
            if (isset($_POST['quantity_submit'])) {
                $items_count = $_POST['items_quantity'];
                $items = $this->items->get_empty_items($items_count);
            } else {
                if ($this->is_group_to_add()) {
                    $this->group->values($_POST['group']);
                    $this->group->save();
                }
                
            }
        } else {
            $items_count = 1;
            $items = $this->items->get_empty_items(1);

       }
                   $items = $this->items->get_empty_items(1);

    }

    public function action_ajax_groups_by_location() {
        $location = intval($_GET['location']);
        echo misc::db_result_to_json($this->group->get_groups_by_location($location),
                                         array('name', 'order','is_global'));
    }

    public function action_ajax_get_pages() {
        
    }

    private function is_group_to_add() {
        if (isset($_POST['menu_type'])) {
            if ($_POST['menu_type'] == 'group') return true;
        }
        return false;
    }
}
?>