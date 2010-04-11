<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->model = ORM::factory('template');
        $this->set_page_title('Szablony');
        $this->load_page_content('tpl_main');
    }

    public function action_index() {
        
    }

    public function action_add() {
           $template = array('name' => '', 'description' => '');
           $add_form = View::factory('tpl_form')->bind('template', $template);

           $this->template->content->tpl_content = $add_form;
           if ($_POST) { 
                        $template = arr::merge($template, $_POST, $_FILES);
                       if ($this->model->validate_template($template)) {
                           $this->model->save();
                           $this->set_success_msg('templates');
                       } else {
                           $this->template->content->tpl_content->errors = $this->model->get_tpl_errors();
                       }
                      
//                       $validate = Validate::factory($_FILES)
//                                ->rules('file',
//                                    array(
//                                        'upload::not_empty' => array(),
//                                        'uploadarray::valid' => array(),
//                                        'upload::type' => array(Kohana::config('templates.extensions')),
//                                        'upload::size' => array('5M')
//                                    )
//                                );
//                       if ($validate->check()) {
//                           $ext = $this->get_file_ext($_FILES['file']['name']);
//                           Upload::save($_FILES['file'], 'temp'.$ext);
//                       } else {
//                           $this->set_form_errors($validate->errors('upload'));
//                       }
               
//               if ($this->model->save_if_valid($_POST)) {
//                   Fire::log('OK!');
//               } else $this->set_form_errors($this->model->get_errors('validate'));

           }
    }

    public function action_edit($id) {

    }

    public function action_delete($id) {
        
    }

 
    
}
?>
