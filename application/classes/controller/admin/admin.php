<?php defined('SYSPATH') or die('No direct script access');
	
	class Controller_Admin_Admin extends Controller_Fly {

		public $template = 'template';
                protected $msg_key = '';
                protected $model;
                private $msg_file_name = 'messages';


                
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

                protected function set_msg($msg_name, $is_success) {
                    if ($is_success) $msg_key_suffix = '.success.';
                    else $msg_key_suffix = '.fail.';
                    fire::log(Kohana::message($this->msg_file_name,
                            $this->msg_key.$msg_key_suffix.$msg_name), 'message');
                    $this->template->content->msg = Kohana::message($this->msg_file_name,
                            $this->msg_key.$msg_key_suffix.$msg_name);

                }

		protected function is_ajax() {
			return $this->request->is_ajax;
		}
                
			
	}
?>