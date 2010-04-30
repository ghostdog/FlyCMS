<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    private $templates;

    public function before() {
        parent::before();
        $this->templates = ORM::factory('template');
        $this->load_page_content('templates')->bind('template', $this->templates)
                                             ->set('templates', $this->templates->get_templates());
        $this->set_page_title('Szablony');
    }

    public function action_index() {

    }

    public function action_add() {
       if ($_POST) {
               $this->templates->values($_POST);
               $is_valid = $this->templates->validate_template(arr::merge($_POST, $_FILES));
               if ($is_valid) {
                   $this->templates->save();
               } else {
                   $this->set_form_errors($this->templates->get_errors());
               }
               $this->set_msg($is_valid);
           }
    }

    public function action_delete($id) {
            $is_removed = $this->templates->_delete($id);
            $this->set_msg($is_removed);
            $this->redirect('templates');
         
    }

    public function action_preview($id) {
            //TODO
    }

    public function action_global($id) {
            $is_saved = $this->templates->set_template_global($id);
            $this->set_msg($is_saved);
            $this->redirect('templates');
        
    }
}
?>
