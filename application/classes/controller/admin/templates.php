<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->model = new Model_Template();
        $this->set_page_title('Szablony');
        $this->load_page_content('tpl_main');
    }

    public function action_index() {
        $this->template->content->tpl_content = View::factory('tpl_list');
        Fire::log($this->model->get_all_templates());
    }

    public function action_add() {
           $template = array('name' => '', 'description' => '');
           $add_form = View::factory('tpl_form')->bind('template', $template);
           $this->template->content->tpl_content = $add_form;
           if ($_POST) { 
               $template = arr::merge($template, $_POST, $_FILES);
               if ($this->model->validate_template($template)) {
                   $this->model->save();
                   $this->set_success_msg('templates');
               } else $this->template->content->tpl_content->errors = $this->model->get_tpl_errors();
            }
    }

    public function action_edit($id) {

    }

    public function action_delete($id) {
        
    }

 
    
}
?>
