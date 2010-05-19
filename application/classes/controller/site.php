<?php defined('SYSATH') or die('No direct script access');

class Controller_Site extends Controller_Fly {

   private $page;
   private $settings;
   private $template_name;

   public function before() {
       parent::before();
       $this->page = ORM::factory('page');
       $this->settings = ORM::factory('setting')->find();
       $this->template_name = $this->settings->template->name;
   }

   public function action_main() {
        $this->page = $this->page->get_main_page();
   }

   public function action_page($page_title) {
       $this->page->get_by_title($page_title);
       if (! $this->page->loaded()) {
           $this->page->get_main_page();
       }
   }

   public function after() {
        $settings = $this->settings;
        $page = $this->page;
        if ($page->header_on) {
            $header->bind('menus', $header_menus);
        }
        $template = $settings->template->name;
        $this->template = View::factory('site')
                          ->set_global('page', $page)
                          ->set('content', View::factory($template.'/content',
                                           array('sections' => $page->get_sections())))
                          ->set('site_title', $settings->title)
                          ->set('subtitle', $settings->subtitle)
                          ->bind('header', $header)
                          ->bind('sidebar_menus', $sidebar_menus)
                          ->bind('content_menus', $content_menus);
        $menus = $page->get_menus();
        $sidebar_menus = new ArrayObject();
        $content_menus = new ArrayObject();
        if ($page->header_on) {
            $header_menus = new ArrayObject();
            $this->template->header = View::factory($template.'/header')
                                      ->bind('menus', $header_menus);
        }
        if ($page->footer_on) {
            $this->template->footer = View::factory($template.'/footer');
        }
        parent::after();
   }
}
?>
