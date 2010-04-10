<?php defined('SYSPATH') or die('No direct script accesss');

class Controller_Admin_Templates extends Controller_Admin_Admin {

    public function before() {
        parent::before();
       // $this->model = ORM::factory('template');
        $this->set_page_title('Szablony');
    }

    public function action_index() {
        
    }

    public function action_add() {
           $this->load_page_content('templates_form');
           $this->set_content_var('template', array('name' => 'Nazwa szablonu', 'description' => 'Opis szablonu strony'));
           if ($_POST) {
                       if ($this->model->add_template(array_merge($_FILES, $_POST)
                                                        , isset($_POST['already_uploaded'])))
                               Fire::log('ok');

                       else {
                           $this->set_form_errors($this->model->get_errors());
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
              $this->set_form_vals($_POST);
           }
    }

    public function action_edit($id) {

    }

    public function action_delete($id) {
        
    }

    private function get_file_ext($file_name) {
        $dot = utf8::strpos($file_name, '.');
        return utf8::substr($file_name, $dot);
    }
    
}
?>
