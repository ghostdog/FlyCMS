<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->set_page_title('Ustawienia globalne');
        $this->load_page_content('settings');
        $this->model = ORM::factory('setting', 1);
    }

    public function action_index() {
        
    }

    public function action_save() {
        if ($this->model->save_if_valid($_POST))
            $this->set_success_msg('settings');
        else $this->set_content_var('errors', $this->model->get_errors('validate'));
    }

    public function after() {
        $settings = $this->model->as_array();
        $this->set_content_var('settings', $settings);
        parent::after();
    }
}

?>