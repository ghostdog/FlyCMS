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
        $group = View::factory('menu/group_frm')
                 ->bind('group', $this->group);
        $this->template->content = View::factory('menu/add_frm')
             ->set('group', $group)
             ->bind('items_count', $items_count)
             ->bind('items', $items)
             ->bind('groups', $groups);
        if ($_POST) {
            $items_count = $_POST['items_quantity'];
            fire::log($_POST, 'post');
            if (isset($_POST['quantity_submit'])) {
                $items = $this->items->get_empty_items($items_count);
            } else {
                if ($this->is_group_to_add()) {
                    $this->group->values($_POST['group']);
                    if (! $this->group->check()) {
                        $group->set('errors', $this->group->get_errors());
                    } else {
                        $this->group->save();
                    }
                }
            }
        } else {
            $items_count = 1;
            $items = $this->items->get_empty_items(1);

       }
       $groups = $this->group->get_all_groups();
    }

    public function action_ajax_groups_by_location() {
        $location = intval($_GET['location']);
        echo json_encode(misc::get_raw_db_result($this->group->get_by_location($location),
                                         array('name', 'order','is_global')));
    }

    public function action_ajax_group_items() {
        $id = intval($_GET['group_id']);
        echo json_encode(misc::get_raw_db_result($this->group->get_items($id), array('id', 'name')));
    }
    private function is_group_to_add() {
        if (isset($_POST['menu_type'])) {
            if ($_POST['menu_type'] == 'group') return true;
        }
        return false;
    }

    private function get_item_array(Array $data, $index) {

    }
}
?>
