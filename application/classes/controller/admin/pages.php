<?php defined('SYSPATH') or die('No direct script access');

class Controller_Admin_Pages extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->set_page_title('Edytor stron');

    }

     public function after() {
        if ($_POST && $this->request->action != 'delete') {
            $is_saved = $this->model->save_if_valid($_POST);
            $this->set_msg($is_saved);
            if (! $is_saved) {
                $this->load_form_errors();
            } 
        }
        parent::after();
     }

    public function action_index() {
        $this->load_pages_list();
    }

    public function action_search() {
        $finder = new Finder($this->model);
        $this->load_page_content('pages')
             ->set('pages', $finder->find_by_value('title', $_GET['search']))
             ->set('pagination', $finder->get_links());
        
    }

    public function action_add() {
        $this->load_page_form();
     }

     public function action_edit($id) {
        $this->model->find($id);
         $this->load_page_form();
     }

     public function action_delete($id = NULL) {
         if ($_POST) {
              $delete_count = $this->model->_delete($_POST['pages']);
              if ($delete_count > 0) {
                  $this->set_msg(TRUE, TRUE, array($delete_count));
              } else {
                  $this->set_msg(FALSE, TRUE);
              } 
         } else {
             if ($id == NULL) {
                 $is_success = FALSE;
             }
             else {
                 $is_success = $this->model->_delete($id);
             }
             $this->set_msg($is_success);
         }
         $this->redirect('pages');
         //$this->redirect2prev_uri();
         
     }
     private function load_page_form() {
         $this->load_page_content('page_form')
              ->bind('page', $this->model)
              ->bind('action', $action)
              ->set('templates', ORM::factory('template')->get_templates());

         $action = $this->request->action;
         if ($action == 'edit') {
             $action .= '/'.$this->request->param('id');
         }
     }

     private function load_pages_list() {
        //$items_per_page = (isset($_GET['items_per_page'])) ? intval($_GET['items_per_page']) : 10;
        $this->set_page_title('Twoje strony');
        $finder = new Finder($this->model);
        $this->load_page_content('pages')
                ->set('pages', $finder->find_all())
                ->set('pagination', $finder->get_links());
     }
    
}
?>
