<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->msg_key = 'templates';
        $this->set_page_title('Szablony');
        $this->load_page_content('templates');
        $this->set_content_var('templates', $this->model->get_templates());
        $this->set_content_var('template', $this->model);
    }

    public function action_index() {

    }

    public function action_add() {
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
    }

}
?>
