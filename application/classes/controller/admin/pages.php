<?php defined('SYSPATH') or die('No direct script access');

class Controller_Admin_Pages extends Controller_Admin_Admin {

    public function action_index() {
        $this->create_pages_list();
    }

    public function action_search() {
        $this->create_pages_list();
    }

    public function action_add() {
        $this->load_page_form();
    }

    public function action_edit($id) {
        $this->m('page')->find($id);
        $this->load_page_form();
    }

    public function action_delete($id) {
        $page = $this->m('page');
        if ($_POST) {
            $page->_delete($_POST['pages']);
        } else {
            $page->_delete($id);
        }
        $this->set_msg_from_result($page->get_result());
        $this->redirect('pages');
    }

    public function action_ajax_sections_refresh() {
        $addSz = (int) $_GET['add_sz'];
        $next_id = (int) $_GET['next_id'];
        $sections = $this->m('section')->get_empty_sections($addSz);
        $sections = View::factory('section')
                ->set('sections', $sections)
                ->set('i', $next_id)
                ->set('action', $this->request->action)
                ->render();
        $this->request->headers['Content-Type'] = 'text/html; charset=utf-8';
        echo $sections;
    }



    public function after() {
        if ($this->auto_render) {
            $action = $this->request->action;
            if ($_POST AND $action != 'delete') {
                fire::log($_POST, 'post');
                $sections_valid = TRUE;
                $page_valid = TRUE;
                $sections = new ArrayObject();
                $sections_errors = array();
                $page_errors = array();
                if (isset($_POST['sections'])) {
                    $posted_sections = $_POST['sections'];
                     foreach($posted_sections as $key => $section) {
                        $section_orm = $this->mf('section');
                        if ($action == 'edit') {
                            $section_orm->find($section['id']);
                            unset($section['id']);
                        }
                        $section_orm->values($section);
                        if (! $section_orm->check()) {
                            $sections_errors[$key] = $section_orm->get_errors();
                        }
                        $sections->append($section_orm);
                        if (! empty($sections_errors)) {
                            $sections_valid = FALSE;
                        }
                    }
                }
                $page = $this->m('page');
                $page->values($_POST['page']);
                if ($page->check() AND $sections_valid) {
                    $page->save();
                    $page->reload();
                    foreach($sections as $section) {
                        $section->_save($page);
                    }
                } else {
                    $page_valid = FALSE;
                    $page_errors = $page->get_errors();
                }
                if ($sections_valid AND $page_valid) {
                    $this->set_msg(TRUE);
                    if ($action == 'add') {
                        $this->redirect('pages', 'add');
                    } else if ($action  == 'edit') {
                       $this->redirect('pages', 'index');
                    }

                } else {
                    $this->set_msg(FALSE);
                }
                $this->template->content
                        ->set('sections', $sections)
                        ->set('errors', $page_errors)
                        ->set('sections_errors', $sections_errors);
            } else if($action == 'edit') {
                $this->template->content->sections = $this->m('page')->sections->find_all();
            }
            if ($action == 'index') {
                $this->set_page_title('Lista strony');
            } else {
                $this->set_page_title('Edytor stron');
            }
        }
        parent::after();
    }

    private function create_pages_list($limit = 15) {
        $finder = new Finder($this->m('page'));
        $action = $this->request->action;
        if ($action == 'index') {
            $result = $finder->find_all($limit, 'is_main', FALSE);
        } else if ($action == 'search') {
            $result = $finder->find_by_value('title', $_GET['search']);
        }
        if ($this->is_ajax) {
            $result = misc::result_obj2arr($result, array('id', 'title', 'link'));
            $result['pagination'] = $finder->get_pagination_links();
            echo json_encode($result);
        } else {
            $this->load_page_content('pages')
                    ->set('pages', $result)
                    ->set('pagination', $finder->get_pagination_links());
        }
    }

    private function load_page_form() {
        $action = $this->request->action;
        $this->load_page_content('page_form');
        if ($action == 'edit') {
            $action .= '/'.$this->request->param('id');
        } else {
            if (! $_POST) {
               $this->template->content->sections = $this->m('section')->get_empty_sections(3);
            }
        }
        $this->template->content->set('page', $this->m('page'))
                                ->set('action', $action)
                                ->set('themes', $this->m('theme')->get_themes());
    }

    private function set_msg_from_result($result) {
        $this->session->set('msg', $result['msg'])
                      ->set('is_success', $result['is_success']);
    }
}
?>
