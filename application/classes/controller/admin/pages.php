<?php defined('SYSPATH') or die('No direct script access');

class Controller_Admin_Pages extends Controller_Admin_Admin {

     private $page;

     public function before() {
         parent::before();
         $this->page = ORM::factory('page');
     }

    public function action_index() {
        $finder = new Finder($this->page);
        $this->load_page_content('pages')
                ->set('pages', $finder->find_all())
                ->set('pagination', $finder->get_links());
    }

    public function action_search() {
        $finder = new Finder($this->page);
        $this->load_page_content('pages')
             ->set('pages', $finder->find_by_value('title', $_GET['search']))
             ->set('pagination', $finder->get_links());
    }

    public function action_add() {
        $this->load_page_form();
     }

     public function action_edit($id) {
        $this->page->find($id);
         $this->load_page_form();
     }

     public function action_delete($id = NULL) {
         if ($_POST) {
              $is_success = $this->page->_delete($_POST['pages']);
         } else {
             if ($id == NULL) {
                 $is_success = false;
             }
             else {
                 $is_success = $this->page->_delete($id);
             }
         }
         $this->set_msg($is_success);
         $this->redirect('pages');         
     }
     
     private function load_page_form() {
         $this->load_page_content('page_form')
              ->bind('page', $this->page)
              ->bind('action', $action)
              ->set('templates', ORM::factory('template')->get_templates());

         $action = $this->request->action;
         if ($action == 'edit') {
             $action .= '/'.$this->request->param('id');
         }
     }

     public function after() {
        $action = $this->request->action;
        if ($_POST && $action != 'delete') {
            $is_saved = $this->page->save_if_valid($_POST);
            $this->set_msg($is_saved);
            if (! $is_saved) {
                $this->set_form_errors($this->page->get_errors());
            }
        }
        if ($action == 'index') {
            $this->set_page_title('Twoje strony');
        } else {
            $this->set_page_title('Edytor stron');
        }
        parent::after();
     }

    
}
?>
