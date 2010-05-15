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
        $this->redirect('menus', 'add');
    }

    public function delete() {
        //TODO
        $this->redirect('menus', 'add');
    }
    
    public function action_add() {

    }

    public function action_edit($id) {
        $this->group->find($id);
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

    public function action_ajax_groups_list() {
        $this->request->headers['Content-Type'] = 'text/html; charset=utf-8';
        $list = View::factory('menu/groups_list')->set('groups', $this->group->get_all_groups());
        echo $list;
    }

    public function action_ajax_group_items() {
        $id = intval($_GET['group_id']);
        echo json_encode(misc::get_raw_db_result($this->group->find($id)->get_items($id), array('id', 'name')));
    }

    public function after() {
        $action = $this->request->action;
        if ($action == 'add' OR $action == 'edit') {
            $group_editor = View::factory('menu/group_frm')
                     ->bind('group', $this->group);
            $groups = $this->group->get_all_groups();
            $this->template->content = $main_frm = View::factory('menu/main_frm')
                 ->bind('group', $group_editor)
                 ->bind('items', $items)
                 ->bind('groups', $groups);
               if ($_POST) {
                    $is_group_valid = TRUE;
                    $are_items_valid = TRUE;
                    $is_group_to_add = $this->is_group_to_add();

                    if ($is_group_to_add) {
                        $group = $this->group;
                        $group_vals = $_POST['group'];
                        if (! empty($group_vals['id'])) {
                            $group = $group->find($group_vals['id']);
                            unset($group_vals['id']);
                        }
                        $group->values($group_vals);
                        if (! ($is_group_valid =$group->check())) {
                            $group_editor->set('errors', $this->group->get_errors());
                        }
                    }
                    
                    $items = new ArrayObject();
                    foreach ($_POST['items'] as $item) {
                        $temp_item = ORM::factory('menuitem');
                        if (! empty($item['id'])) {
                           $temp_item->find($item['id']);
                           unset($item['id']);
                        }
                        $items->append($temp_item->values($item));
                    }

                    $errors = $this->check_items($items);
                    if (! empty($errors)) {
                        $main_frm->set('items_errors', $errors);
                        $are_items_valid = FALSE;
                    }

                    if (! $are_items_valid OR ! $is_group_valid) {
                        $this->set_msg(FALSE);

                    } else {
                        if ($is_group_to_add) {
                            $group->save();
                        }
                        foreach ($items as $item) {
                            if ($is_group_to_add) {
                                $item->menugroup_id = $this->group->id;
                            }
                            $item->save();
                        }
                        $this->set_msg(TRUE);
                       // $this->redirect('menus/add');
                    }
                } else {
                    if ($action == 'add') {
                        $items = $this->items->get_empty_items(3);
                    } else {
                        $items = $this->group->get_items();
                    }
                }
        }
        parent::after();
    }
    private function is_group_to_add() {
        if ($this->request->action == 'add') {
            if (isset($_POST['menu_type'])) {
                if ($_POST['menu_type'] == 'group') return true;
            }
        } else {
            return true;
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
        return $errors;
    }
}
?>
