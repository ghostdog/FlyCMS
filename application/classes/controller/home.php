<?php defined('SYSATH') or die('No direct script access');

class Controller_Home extends Controller_Fly {

   private $page;

   public function before() {
       $this->page = ORM::factory('page');
   }

   public function action_main() {
        $this->page->get_main_page();
   }

   public function action_page($page_title) {
       $this->page->get_by_title($page_title);
       if (! $this->page->loaded()) {
           $this->page->get_main_page();
       }
   }

   public function after() {
        $settings = ORM::factory('setting')->find();
        $header = View::factory($template.'/header')
                  ->set('site_title', $settings->title)
                  ->set('subtitle', $settings->subtitle)
                  ->set('keywords', $this->page->keywords)
                  ->set('description', $this->page->description)
                  ->set('author', $this->page->author);
        if ($this->page->header_on) {
            $header->bind('menus', $header_menus);
        }
        $template = $settings->template->name;
        $this->template = View::factory('site')
                          ->set_global('page', $this->page)
                          ->set('sections', $page->get_sections())
                          ->bind('header', $header)
                          ->bind('sidebar_menus', $sidebar_menus)
                          ->bind('content_menus', $content_menus);
        $menus_global = ORM::factory('menugroup')->get_globals();
        $menus = $this->page->menugroups;
        $header_menus = new ArrayObject();
        $sidebar_menus = new ArrayObject();
        $content_menus = new ArrayObject();
       
        if ($this->page->footer_on) {
            $this->template->footer = View::factory($template);
        }
        parent::after();
   }
}
?>
