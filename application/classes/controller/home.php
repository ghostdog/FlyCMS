<?php defined('SYSATH') or die('No direct script access');

class Controller_Home extends Controller_Fly {

   private $settings;
   private $page;

   public function before() {
       $this->page = ORM::factory('page');
   }

   public function action_main() {
        $this->page = ORM::factory('page')->get_main_page();
    }

    public function after() {
        $settings = ORM::factory('setting')->find();
        $template = $settings->template->name;
        $this->template = View::factory($template.'/template')
                          ->set_global('page', $this->page)
                          ->set_global('settings', $settings)
                          ->set('footer', View::factory($template.'/footer'))
                          ->bind('content', $content)
                          ->bind('header', $header);

        parent::after();
    }
}
?>
