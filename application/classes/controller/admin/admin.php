<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {


		public $template = 'admin/template';
                protected $model;
  
                protected function set_page_title($title) {
			$this->template->page_title = $title;
		}
		
		protected function load_page_content($view) {
			$this->template->content = View::factory('admin/'.$view);
		}

                protected function set_page_content($content) {
                    $this->template->content = $content;
                }

                protected function set_content_var($val_name, $val_content) {
                    $this->template->content->$val_name = $val_content;
                }

                protected function set_success_msg($msg_id) {
                    $this->template->content->msg = Kohana::message('success', $msg_id);
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