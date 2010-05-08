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
        $group_editor = View::factory('menu/group_frm')
                 ->bind('group', $this->group);
        $groups = $this->group->get_all_groups();
        $this->template->content = $add_frm = View::factory('menu/add_frm')
             ->bind('group', $group_editor)
             ->bind('items_count', $items_count)
             ->bind('items', $items)
             ->bind('groups', $groups);
        if ($_POST) {
            $items_count = $_POST['items_quantity'];
            fire::log($_POST, 'post');
            if (isset($_POST['quantity_submit'])) {
                $items = $this->items->get_empty_items($items_count);
            } else {
                $is_group_valid = TRUE;
                $are_items_valid = TRUE;
                if ($this->is_group_to_add()) {
                    $this->group->values($_POST['group']);
                    if (! $this->group->check()) {
                        $group_editor->set('errors', $this->group->get_errors());
                        $is_group_valid = FALSE;
                    } 
                }
                $items = new ArrayObject();
                foreach ($_POST['items'] as $item) {
                    $items->append(ORM::factory('menuitem')->values($item));
                }
                $errors = $this->check_items($items);
                if (! empty($errors)) {
                    $add_frm->set('items_errors', $errors);
                    $are_items_valid = FALSE;
                }
             
                if (! $are_items_valid OR ! $is_group_valid) {
                    $this->set_msg(FALSE);

                } else {
                    $this->set_msg(TRUE);
                    $this->redirect('menus');
                }
            }
        } else {
            $items = $this->items->get_empty_items(3);
       }
    }

    public function action_ajax_groups_by_location() {
        $location = intval($_GET['location']);
        echo json_encode(misc::get_raw_db_result($this->group->get_by_location($location),
                                         array('name', 'ord','is_global')));
    }

    public function action_ajax_items_refresh() {
        $addSz = intval($_GET['add_sz']);
        $next_id = intval($_GET['next_id']);
        $items = $this->items->get_empty_items($addSz);
        $items = View::factory('menu/item_frm')
                 ->set('items_count', $addSz)
                 ->set('items', $items)
                 ->set('groups', $this->group->get_all_groups())
                 ->set('i', $next_id)
                 ->render();
        $this->request->headers['Content-Type'] = 'text/html; charset=utf-8';
        echo $items;
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

    private function check_items(ArrayObject $items) {
        $errors = array();
        foreach ($items as $key => $item) {
            if (! $item->check()) {
                $errors[$key] = $item->get_errors();
            }
        }
        fire::log($errors, 'errors');
        return $errors;
    }
}
?>
