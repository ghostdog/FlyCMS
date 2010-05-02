<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $session;
                protected $is_ajax;

                public function __construct(Request $req) {
                    parent::__construct($req);
                    $this->session = Session::instance();
                    $this->session->set('prev_uri', $_SERVER['REQUEST_URI']);
                    if (Request::$is_ajax OR $this->request !== Request::instance()) {
                        $this->auto_render = FALSE;
                        $this->is_ajax = TRUE;
                        fire::log('is ajax!!!!!!');
                        header('content-type: application/json');

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

                protected function redirect_to_prev_uri() {
                    $this->request->reditect($this->session->get('prev_uri'));
                }
	}
?>