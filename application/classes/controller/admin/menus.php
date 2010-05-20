<?php defined('SYSPATH') or die('No direct script access allowed');

class Controller_Admin_Menus extends Controller_Admin_Admin {

 
    public function action_delete_group() {
        //TODO
    }

    public function action_delete_item($id) {
        $item = $this->model_instance('menuitem', $id);
        if ($item->loaded()) {
            $group_id = $item->menugroup->find()->id;
            $item->delete();
            $this->set_msg(TRUE);
            $this->redirect('menus', 'edit', $group_id);
        } else {
            $this->set_msg(FALSE);
            $this->redirect('menus');
        }
    }
    
    public function action_add() {}

    public function action_edit($id) {
        $this->model_instance('menugroup')->find($id);
    }

    public function action_ajax_groups_by_location() {
        $location = intval($_GET['location']);
        echo json_encode(misc::result_obj2arr($this->model_instance('menugroup')->get_by_location($location),
                                         array('name', 'ord','is_global')));
    }

    public function action_ajax_items_refresh() {
        $addSz = intval($_GET['add_sz']);
        $next_id = intval($_GET['next_id']);
        $items = $this->model_instance('menuitem')->get_empty_items($addSz);
        $items = View::factory('menu/item_frm')
                 ->set('items', $items)
                 ->set('groups', $this->model_instance('menugroup')->get_all_groups())
                 ->set('i', $next_id)
                 ->render();
        echo $items;
    }

    public function action_ajax_groups_list() {
        $group = $this->model_instance('menugroup');
        if ($group->count_all()) {
            $list = View::factory('menu/groups_list')->set('groups', $group->get_all_groups());
            echo $list;
        } else {
            echo null;
        }
    }

    public function action_ajax_group_items() {
        $id = (int)$_GET['group_id'];
        echo json_encode(misc::result_obj2arr($this->model_instance('menugroup',$id)->get_items($id), array('id', 'name')));
    }

    public function after() {
        $action = $this->request->action;
        if ($action == 'add' OR $action == 'edit') {
            $group = $this->model_instance('menugroup');
            $group_editor = View::factory('menu/group_frm')
                     ->bind('group', $group);
            $this->template->content = $main_frm = View::factory('menu/main_frm')
                 ->bind('group', $group_editor)
                 ->bind('items', $items)
                 ->set('groups', $group->get_all_groups());
               if ($_POST) {
                    $is_group_valid = TRUE;
                    $are_items_valid = TRUE;
                    $is_group_to_add = $this->is_group_to_add($action);

                    if ($is_group_to_add) {
                        $group_vals = $_POST['group'];
                        if (! empty($group_vals['id'])) {
                            $group = $group->find($group_vals['id']);
                            unset($group_vals['id']);
                        }
                        $group->values($group_vals);
                        if (! ($is_group_valid = $group->check())) {
                            $group_editor->set('errors', $group->get_errors());
                        }
                    }
                    
                    $items = new ArrayObject();
                    foreach ($_POST['items'] as $key => $item) {
                        $temp_item = $this->model_factory('menuitem');
                        if (! empty($item['id'])) {
                           $temp_item->find($item['id']);
                           unset($item['id']);
                        }
                        $items->append($temp_item->values($item));
                        $errors = array();
                        if (! $temp_item->check()) {
                            $errors[$key] = $temp_item->get_errors();
                        }
                        $sections->append($temp_item);
                     }
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
                                $item->menugroup_id = $group->id;
                            }
                            $item->save();
                        }
                        $this->set_msg(TRUE);
                       // $this->redirect('menus/add');
                    }
                } else {
                    if ($action == 'add') {
                        $items = $this->model_instance('menuitem')->get_empty_items(3);
                    } else {
                        $items = $group->get_items();
                    }
                }
        } else if ($action == 'ajax_items_refresh' OR $action == 'ajax_groups_list') {
             $this->request->headers['Content-Type'] = 'text/html; charset=utf-8';
        }
        parent::after();
    }
    private function is_group_to_add($action)  {
        if ($action == 'add') {
            if (isset($_POST['menu_type'])) {
                if ($_POST['menu_type'] == 'group') return true;
            }
        } else if ($action == 'edit') {
            return true;
        }
        return false;
    }
}
?>
