<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $model;
                protected $session;
                
               public function before() {
                    parent::before();
                    $curr_controller = $this->request->controller;
                    $this->model = Model::factory(Inflector::singular($curr_controller));
                    $this->session = Session::instance();
   
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

//                protected function load($id) {
//                    $this->model->find($id);
//                    return $this->model->loaded();
//                }

                protected function set_page_title($title) {
			$this->template->page_title = $title;
		}
		
		protected function load_page_content($view) {
                        $this->template->set('content', View::factory($view));
		}

                protected function set_page_content($content) {
                    $this->template->content = $content;
                }

                protected function set_content_var($var_name, $value) {
                    $this->template->content->set($var_name, $value);
                }

                protected function set_msg($is_success, $group_action = false, $params = array()) {
                    $msg_group = $this->request->controller;
                    $msg_name = $this->request->action;
                    if ($group_action) {
                        $msg_name = 'group_'.$this->request->action;
                    }
                    if ($is_success) {
                        $msg_type = '.success.';
                    }
                    else {
                        $msg_type = '.fail.';
                    }
                    $msg = Kohana::message('messages', $msg_group.$msg_type.$msg_name);
                    if (! empty($params)) {
                        $msg = $this->set_msg_params($msg, $params);
                    }
                    $this->session->set('msg', $msg)
                                  ->set('is_success', $is_success);
                }

                protected function set_form_errors(array $errors) {
                    $this->template->content->errors = $errors;
                }

                protected function load_form_errors() {
                    $this->template->content->errors = $this->model->get_errors();
                }

               protected function redirect($controller, $action = null) {
                    $route = Route::get('admin');
                    $segments['controller'] = $controller;
                    if (! is_null($action)) {
                        $segments['action'] = $action;
                    }
                    $this->request->redirect($route->uri($segments));
                }

		protected function is_ajax() {
			return $this->request->is_ajax;
		}

                private function set_msg_params($msg, $params) {
                    $regex = '/:param/';
                    fire::log($params, 'params');
                    while (strpos($msg, ':param') !== FALSE) {
                        $msg = preg_replace($regex, array_shift($params), $msg, 1);
                    }
                    return $msg;
                }
			
	}
?>