<?php defined('SYSPATH') or die('No direct script access');

class Controller_Admin_Pages extends Controller_Admin_Admin {

     private $page;
     private $section;

     public function before() {
         parent::before();
         $this->page = ORM::factory('page');
         $this->section = ORM::factory('section');
     }

    public function action_index($limit = 15) {
        $this->set_pages_list($limit);
    }

    public function action_search() {
        $this->set_pages_list(15);
    }

    private function set_pages_list($limit) {
        $finder = new Finder($this->page);
        $action = $this->request->action;
        if ($action == 'index') {
            $result = $finder->find_all($limit, 'is_main', FALSE);
        } else if ($action == 'search') {
            $result = $finder->find_by_value('title', $_GET['search']);
        }
        if ($this->is_ajax) {
             $result = misc::get_raw_db_result($result, array('id', 'title', 'link'));
             $result['pagination'] = $finder->get_pagination_links();
             echo json_encode($result);
        } else {
             $this->load_page_content('pages')
                 ->set('pages', $result)
                 ->set('pagination', $finder->get_pagination_links());
        }
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
         
         $this->set_msg_from_result($this->page->get_result());
         $this->redirect('pages');
     }

    public function action_ajax_sections_refresh() {
        $addSz = intval($_GET['add_sz']);
        $next_id = intval($_GET['next_id']);
        $sections = $this->section->get_empty_sections($addSz);
        $sections = View::factory('section')
                 ->set('sections', $sections)
                 ->set('i', $next_id)
                 ->set('action', $this->request->action)
                 ->render();
        $this->request->headers['Content-Type'] = 'text/html; charset=utf-8';
        echo $sections;
    }



     public function after() {
        if (! $this->is_ajax) {
            $action = $this->request->action;
            if ($_POST && $action != 'delete') {
                fire::log($_POST, 'post');
                $this->template->content
                        ->bind('sections', $sections)
                        ->bind('errors', $page_errors)
                        ->bind('page_errors', $errors)
                        ->bind('sections_errors', $sections_errors);
                $sections_valid = TRUE;
                $page_valid = TRUE;
                $posted_sections = $_POST['sections'];
                $sections = new ArrayObject();
                $sections_errors = array();
                $page_errors = array();
                foreach($posted_sections as $key => $section) {
                    $section_orm = ORM::factory('section');
                    if ($action == 'edit') {
                        $section_orm->find($section['id']);
                        unset($section['id']);
                    }
                    $section_orm->values($section);
                    if (! $section_orm->check()) {
                        $sections_valid = FALSE;
                        $sections_errors[$key] = $section_orm->get_errors();
                    }
                    $sections->append($section_orm);
                }
                $this->page->values($_POST['page']);
                if ($this->page->check() && $sections_valid) {
                    $this->page->save();
                    $this->page->reload();
                    foreach($sections as $section) {
                        $section->_save($this->page);
                    }
                } else {
                    $page_valid = FALSE;
                    $page_errors = $this->page->get_errors();
                }
                if ($sections_valid && $page_valid) {
                    $this->set_msg(TRUE);
                    $this->redirect('pages', 'add');
                } else {
                    $this->set_msg(FALSE);
                }
            } else if($action == 'edit') {
                $this->template->content->sections = $this->page->sections->find_all();
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
              ->bind('sections', $sections)
              ->set('templates', ORM::factory('template')->get_templates());
         $action = $this->request->action;
         if ($action == 'edit') {
             $action .= '/'.$this->request->param('id');
         } else {
             if (! $_POST) {
                $sections = $this->section->get_empty_sections(3);
             }
         }
     }

     private function set_msg_from_result($result) {
         $this->session->set('msg', $result['msg'])
                       ->set('is_success', $result['is_success']);
     }
}
?>
