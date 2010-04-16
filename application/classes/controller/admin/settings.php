<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->msg_key = 'settings';
        $this->set_page_title('Ustawienia globalne');
        $this->load_page_content('settings');
        $this->model = Model::factory('setting')->find();
    }

    public function action_index() {
        
    }

    public function action_save() {
        $saved = $this->model->save_if_valid($_POST);
        $this->set_msg('save', $saved);
        if (! $saved) $this->set_form_errors($this->model->get_errors('validate'));
    }

    public function after() {
        if ($_POST) $this->model->values($_POST);
        $this->set_content_var('settings', $this->model);
        $this->set_content_var('templates', Model::factory('template')->get_templates());
        parent::after();
    }
}

?>