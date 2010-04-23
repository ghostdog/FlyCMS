<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $model;
                protected $session;
                protected $msg_key = '';
                private $msg_file_name = 'messages';
                
               public function before() {
                    parent::before();
                    $curr_controller = $this->request->controller;
                    $this->model = Model::factory(Inflector::singular($curr_controller));
                    $this->session = Session::instance();
                    if (($msg = $this->session->get('msg'))) {
                            $this->template->msg = $msg;
                            $this->template->result = $this->session->get('is_success');
                            $this->session->delete('msg')->delete('is_success');
                    }
                }

                protected function load($id) {
                    $this->model->find($id);
                    return $this->model->loaded();
                }

                protected function set_page_title($title) {
			$this->template->page_title = $title;
		}
		
		protected function load_page_content($view) {
			$this->template->content = View::factory($view);
		}

                protected function set_page_content($content) {
                    $this->template->content = $content;
                }

                protected function set_content_var($var_name, $value) {
                    $this->template->content->$var_name = $value;
                }

                protected function set_msg($is_success, $use_session = false) {
                    $this->template->result = $is_success;
                    $msg_name = $this->request->action;
                    if ($is_success) $msg_key_suffix = '.success.';
                    else $msg_key_suffix = '.fail.';
                    $msg = Kohana::message($this->msg_file_name, $this->msg_key.$msg_key_suffix.$msg_name);
                    if (! $use_session) {
                        $this->template->msg = $msg;
                    } else {
                        $this->session->set('msg', $msg)->set('is_success', $is_success);
                    }

                }

                protected function set_form_errors(array $errors) {
                    $this->template->content->errors = $errors;
                }

		protected function is_ajax() {
			return $this->request->is_ajax;
		}

                
                
			
	}
?>