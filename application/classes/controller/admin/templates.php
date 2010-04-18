<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->msg_key = 'templates';
        $this->set_page_title('Szablony');
    }

    public function action_index() {
        $this->set_list_view();
    }

    public function action_add() {
       $form = View::factory('tpl_form')->set('template', $this->model);
       $this->set_page_content($form);
       if ($_POST) {
           $this->model->values($_POST);
           $is_valid = $this->model->validate_template(arr::merge($_POST, $_FILES));
           if ($is_valid) $this->model->save();
           else $this->set_form_errors($this->model->get_errors());
           $this->set_msg($is_valid);
        }
    }

    public function action_remove($id) {
        if ($this->load($id)) {
            $is_removed = $this->model->remove_template($id);
            $this->set_msg($is_removed);
         }
        $this->set_list_view();

    }

    public function action_preview($id) {
        if ($this->load($id)) {
            $tpl_name = $this->model->name;
            $this->template = View::factory('front_template');
            $path = $this->model->name.'/';
            $this->template->header = View::factory($path.'header');
            $this->template->content = View::factory($path.'content');
            $this->template->sidebar = View::factory($path.'sidebar');
            $this->template->footer = View::factory($path.'footer');
        }
    }

    public function action_global($id) {
        if ($this->load($id)) {
            $is_saved = $this->model->set_template_global();
                $this->set_msg($is_saved);
        }
        $this->set_list_view();
    }

    private function set_list_view() {
        $tpl_list = View::factory('tpl_list')->set('templates', $this->model->get_templates());
        $this->set_page_content($tpl_list);
    }

}
?>
