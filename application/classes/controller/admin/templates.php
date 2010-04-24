<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->msg_key = 'templates';
        $this->set_page_title('Szablony');
        $this->load_page_content('templates');
        $this->set_content_var('template', $this->model);
    }

    public function action_index() {

    }

    public function action_add() {
       if ($_POST) {
               $this->model->values($_POST);
               $is_valid = $this->model->validate_template(arr::merge($_POST, $_FILES));
               if ($is_valid) $this->model->save();
               else $this->load_form_errors();
               $this->set_msg($is_valid);
           }
    }

    public function action_remove($id) {
            $is_removed = $this->model->_delete($id);
            $this->set_msg($is_removed);
            $this->redirect('templates');
         
    }

    public function action_preview($id) {
            //TODO
    }

    public function action_global($id) {
            $is_saved = $this->model->set_template_global($id);
            $this->set_msg($is_saved);
            $this->redirect('templates');
        
    }

    public function after() {
        $this->set_content_var('templates', $this->model->get_templates());
        parent::after();
    }

}
?>
