<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $session;
                protected $is_ajax = FALSE;
                protected $is_internal_request = FALSE;
                protected $current_user;

                public function before() {
                    parent::before();
//                    if (($this->_current_user = cookie::get('authorized')) === NULL)
//                    {
//                            if ($this->request->controller !== 'login')
//                            {
//                                    // Skip the current action
//                                    $this->request->action = 'skip';
//
//                                    // Load the login page via a sub-query
//                                    $this->template->content = Request::factory($this->request->uri(array('action' => 'login')))->execute();
//                            }
//                    } else if ($this->request->controller == 'login') {
//
//                    }
                    $this->template->page_title = '';
                    $this->template->content = '';
                }

                public function __construct(Request $req) {
                    parent::__construct($req);
                    $this->session = Session::instance();
                    if ( Request::$is_ajax ) {
                        $this->auto_render = FALSE;
                        $this->is_ajax = TRUE;
                        $this->request->headers['Content-Type'] = 'application/json';
                    }
                    if ($this->request !== Request::instance()) {
                        $this->is_internal_request = TRUE;
                    }
                    FirePHP_Profiler::instance()
                        ->group('Profiler')
                        ->post()
                        ->get()
                        ->database()
                        ->benchmark()
                        ->groupEnd();
                }

                final public function action_skip() {
                    
                }

                public function after() {
                  if ($this->auto_render) {
                        if (($msg = $this->session->get('msg'))) {
                                $this->template->set('msg', $msg)
                                               ->set('is_success', $this->session->get('is_success'));
                                $this->session->delete('msg')
                                              ->delete('is_success');
                       }
                       $this->template->site_name = ORM::factory('setting')->find()->title;
                   }
                   parent::after();
                }

                protected function set_page_title($title) {
			$this->template->page_title = $title;
		}
		
		protected function load_page_content($view) {
                        $this->template->set('content', View::factory($view));
                        return $this->template->content;
		}

                protected function set_msg($is_success) {
                    $msg_group = $this->request->controller;
                    $msg_name = $this->request->action;
                    if ($is_success) {
                        $msg_type = '.success.';
                    }
                    else {
                        $msg_type = '.fail.';
                    }
                    $msg = Kohana::message('messages', $msg_group.$msg_type.$msg_name);
                    $this->session->set('msg', $msg)
                                  ->set('is_success', $is_success);
                }

                protected function set_form_errors(array $errors) {
                    $this->template->content->errors = $errors;
                }

               protected function redirect($controller, $action = NULL, $id = NULL) {
                   $route = 'admin';
                   if ($controller == 'menus') {
                        $route = 'menus';
                   }
                    $params['controller'] = $controller;
                    if (isset($action)) {
                        $param['action'] = $action;
                    } else if (isset($id)) {
                        $param['id'] = $id;
                    }
                    $this->request->redirect(Route::get($route)->uri($params));
                }

	}
?>