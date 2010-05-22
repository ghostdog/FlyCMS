<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Admin {

    public function action_index() {

    }

    public function action_save() {

    }

    public function after() {
        $settings = $this->m('setting')->find();
        $this->set_page_title('Ustawienia globalne');
        if ($_POST) {
            $saved = $settings->save_if_valid($_POST);
            $this->set_msg($saved);
            if (! $saved) {
                $this->set_form_errors($settings->get_errors());
            } else {
                $this->redirect('settings');
            }
        }
        $this->load_page_content('settings')
                ->set('settings', $settings)
                ->set('user', DB::query(Database::SELECT, 'SELECT username FROM auth LIMIT 1')->execute()->current())
                ->set('themes', $this->m('theme')->get_themes());
        parent::after();
    }
}
?>