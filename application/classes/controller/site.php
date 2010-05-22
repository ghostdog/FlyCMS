<?php defined('SYSPATH') or die('No direct script access');

class Controller_Site extends Controller_Fly {

   public static $meta_names = array('keywords', 'descriptions', 'author');


   public function action_main() {
        $this->m('page')->get_main_page();
   }

   public function action_page($page_title) {
       $page = $this->m('page');
       $page->get_by_link($page_title);
       if (! $page->loaded()) {
           $page->get_main_page();
       }
   }

   public function after() {
        $page = $this->m('page');
        $metas = '';
        foreach(self::$meta_names as $meta) {
           if (! empty($page->$meta)) {
              $metas .= html::meta($page->$meta, $meta).PHP_EOL;
           }
        }
        $theme = $page->get_theme_name();
        Kohana::set_module_path('themes', Kohana::get_module_path('themes').'/'.$theme);
        $menus = $page->get_menus();
        $this->template = View::factory('layout')
                           ->set('theme', $theme)
                           ->set('metas', $metas)
                           ->set('menus', $menus['content'])
                           ->set('sections', $page->get_sections())
                           ->set_global('page', $page);
        if ($page->header_on) {
            $settings = $this->m('setting');
            $this->template->header = View::factory('/header')
                                              ->set('title', $settings->title)
                                              ->set('subtitle', $settings->subtitle)
                                              ->set('menus', $menus['header']);
        }
        if ($page->sidebar_on) {
            $this->template->sidebar = View::factory('sidebar', array('menus' => $menus['sidebar']));
        }
        if ($page->footer_on) {
            $this->template->footer = View::factory('footer');
        }
        parent::after();
   }

}
?>
