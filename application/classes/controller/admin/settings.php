<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Admin {

    private $settings;

    public function before() {
        parent::before();
        $this->settings = ORM::factory('setting')->find();
        $this->set_page_title('Ustawienia globalne');
        $this->load_page_content('settings')
             ->bind('settings', $this->settings)
             ->set('templates', ORM::factory('template')->get_templates());
    }

    public function action_index() {}

    public function action_save() {
        if ($_POST) {
            $saved = $this->settings->save_if_valid($_POST);
            $this->set_msg($saved);
            if (! $saved) {
                $this->set_form_errors($this->settings->get_errors());
            } else {
                $this->redirect('settings');
            }
        }
    }
}
?>