<?php defined('SYSPATH') or die('No direct script access');

class Controller_Site extends Controller_Fly {

   public $template = 'site';
   private $page;
   private $settings;

   public static $meta_names = array('keywords', 'descriptions', 'author');

   public function before() {
       parent::before();
       $this->page = ORM::factory('page');
       $this->settings = ORM::factory('setting')->find();

   }

   public function action_main() {
        $this->page = $this->page->get_main_page();
   }

   public function action_page($page_title) {
       $this->page->get_by_link($page_title);
       if (! $this->page->loaded()) {
           $this->page->get_main_page();
       }
   }

   public function after() {
        $settings = $this->settings;
        $page = $this->page;
        $template = $page->template->name;
        $menus = $page->get_menus();
        $metas = '';
        foreach(self::$meta_names as $meta) {
           if (! empty($this->page->$meta)) {
              $metas .= html::meta($this->page->$meta, $meta).PHP_EOL;
           }
        }
        $this->template->set('template', $template)
                       ->set('metas', $metas)
                       ->set('menus', $menus['content'])
                       ->set('sections', $page->get_sections())
                       ->set_global('page', $page);
        if ($page->header_on) {
            $this->template->header = View::factory($template.'/header')
                                              ->set('title', $settings->title)
                                              ->set('subtitle', $settings->subtitle)
                                              ->set('menus', $menus['header']);
        }
        if ($page->sidebar_on) {
            $this->template->sidebar = View::factory($template.'/sidebar', array('menus' => $menus['sidebar']));
        }
        if ($page->footer_on) {
            $this->template->footer = View::factory($template.'/footer');
        }

        parent::after();
   }

}
?>
