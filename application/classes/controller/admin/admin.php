<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $session;
                protected $is_ajax;

                public function __construct(Request $req) {
                    parent::__construct($req);
                    $this->session = Session::instance();
                    if (Request::$is_ajax OR $this->request !== Request::instance()) {
                        $this->auto_render = FALSE;
                        $this->is_ajax = TRUE;
                    }

//                    FirePHP_Profiler::instance()
//                        ->group('KO3 FirePHP Application Profiler')
//                        ->post()
//                        ->get()
//                        ->database()
//                        ->benchmark()
//
//                        ->groupEnd();

                }

                public function after() {
                    if (($msg = $this->session->get('msg'))) {
                            $this->template->set('msg', $msg)
                                           ->set('is_success', $this->session->get('is_success'));
                            $this->session->delete('msg')
                                          ->delete('is_success');
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

                protected function set_content_var($var_name, $value) {
                    $this->template->content->set($var_name, $value);
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

               protected function redirect($controller, $action = null) {
                    $route = Route::get('admin');
                    $segments['controller'] = $controller;
                    if (! is_null($action)) {
                        $segments['action'] = $action;
                    }
                    $this->request->redirect($route->uri($segments));
                }
                
                private function set_msg_params($msg, $params) {
                    $regex = '/:param/';
                    while (strpos($msg, ':param') !== FALSE) {
                        $msg = preg_replace($regex, array_shift($params), $msg, 1);
                    }
                    return $msg;
                }
			
	}
?>