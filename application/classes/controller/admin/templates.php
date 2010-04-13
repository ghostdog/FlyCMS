
<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->model = new Model_Template();
        $this->set_page_title('Szablony');
        $this->load_page_content('tpl_main');
    }

    public function action_index() {
        $tpl_list = View::factory('tpl_list')->set('templates', $this->model->get_templates());
        $this->set_content_var('tpl_content', $tpl_list);
    }

    public function action_add() {
        $this->model->values($_POST);
        $this->populate_form();
    }

    public function action_edit($id) {
         $this->model->find($id);
         if ($this->model->loaded()) {
                $this->populate_form();
         } else {
             //TODO
         }
    }

    public function action_delete($id) {
        
    }

    private function populate_form() {
       $form = View::factory('tpl_form')->set('template', $this->model);
       $this->set_content_var('tpl_content', $form);
       if ($_POST) {
           if ($this->model->validate_template($_POST)){
                   $this->model->save();
                   $this->set_success_msg('templates');
           } else {
               $this->template->content->tpl_content->errors= $this->model->get_errors();
           }
        }
    }
}
?>
