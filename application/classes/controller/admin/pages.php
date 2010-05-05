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
                ->set('pages', $finder->find_w_limit(15, 'is_main', FALSE))
                ->set('pagination', $finder->get_pagination_links());
    }

    public function action_search() {
        $finder = new Finder($this->page);
        $this->load_page_content('pages')
             ->set('pages', $finder->find_by_value('title', $_GET['search']))
             ->set('pagination', $finder->get_pagination_links());
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
              $this->page->_delete($_POST['pages']);
         } else {
             if ($id == NULL) {
                 $this->redirect_to_prev_uri();
             }
             else {
                 $this->page->_delete($id);
             }
         }
         
         $this->set_msg_from_result($this->page->get_result_status());
         $this->redirect('pages');
         
     }

     public function action_ajax_get_pages() {
         $limit = intval($_GET['limit']);
         $finder = new Finder($this->page);
         $pages = $finder->find_w_limit($limit);
         $result = misc::get_raw_db_result($pages, array('id', 'title', 'link'));
         $result['pagination'] = $finder->get_pagination_links();
         echo json_encode($result);
     }

     public function after() {
        if (! $this->is_ajax) {
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
        }
        parent::after();
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

     private function set_msg_from_result($result) {
         $this->session->set('msg', $result['msg'])
                       ->set('is_success', $result['is_success']);
     }
}
?>
