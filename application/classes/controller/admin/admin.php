<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $msg_key = '';
                protected $model;


                
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

                protected function set_msg($msg_name, $is_success = true) {
                    if ($is_success) $msg_file = 'success';
                    else $msg_file = 'fail';
                    $this->template->content->msg = Kohana::message($msg_file, $this->msg_key.'.'.$msg_name);
                }

                protected function set_form_vals(Array $values) {
                    $this->template->content->values = $values;
                }

                protected function set_form_errors(Array $errors) {
                    if (isset($this->template->content->errors))
                            $this->template->content->errors =
                                arr::merge($this->template->content->errors, $errors);
                    else $this->template->content->errors = $errors;
                }

		protected function is_ajax() {
			return $this->request->is_ajax;
		}
                
			
	}
?>