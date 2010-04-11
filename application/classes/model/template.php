<?php defined('SYSPATH') or die('No direct script access');

class Model_Template extends Model_FlyOrm {

    private $templates_dir = '';
    private $allowed_archive_ext = array();
    private $allowed_img_ext = array();
    private $errors = array();
    private static $required_files = array('header.php', 'content.php', 'footer.php', 'sidebar.php');
    private static $thumb_img_w = 375;
    private static $thumb_img_h = 325;
    private static $thumb_img_name = 'example';

//width: 325
//height: 249
    public function __construct($model, $id = null) {
        $this->templates_dir = MODPATH.'templates/views/';
        $this->allowed_archive_ext = Kohana::config('templates.allowed_archive_ext');
        $this->allowed_img_ext = Kohana::config('templates.allowed_img_ext');
        $this->error_msg_filename = 'templates';
        parent::__construct($id);
    }

    public function validate_template(Array $values) {
        $this->values($values);
        $this->created = time();
        $validate = $this->get_data_validator($values);
        if ($validate->check()) {
            $tpl_path = $this->templates_dir.$values['name'];
            if (file_exists($tpl_path)) {
                    if ($this->are_required_files_exists($tpl_path)) {
                        $this->create_thumb_img_if_exists($tpl_path);
                        return true;
                    } else {
                        $validate->error('file', Kohana::message($this->error_msg_filename, 'file.invalid'));
                    }
                } else {
                    if ($this->upload_exists($validate)) {
                       if ($this->upload_install_if_valid($validate, $tpl_path)) {
                           $this->create_thumb_img_if_exists($tpl_path);
                           return true;
                       }
                    }
                }
        }
        $this->errors = $validate->errors($this->error_msg_filename); 
        fire::log($this->errors);
        return false;
    }

    public function get_tpl_errors() {
        return $this->errors;
    }

   private function are_required_files_exists($tpl_path) {
        $files_found = file::search_dir_files_by_names($tpl_path, self::$required_files);
        return ! ($files_found == false || sizeof($files_found) != sizeof(self::$required_files));
    }

    private function create_thumb_img_if_exists($tpl_path) {
        $img_found = file::search_dir_files_by_ext($tpl_path, $this->allowed_img_ext);
        if ($img_found != false) {
            foreach($img_found as $img) {
                $name = file::remove_filename_ext($img);
                if ($name == self::$thumb_img_name) {
                    $img_processor = Image::factory($tpl_path.'/'.$img);
                    $img_processor->resize(self::$thumb_img_h, self::$thumb_img_w);
                    $img_processor->save();
                }
            }
        }
    }


    private function get_data_validator(array $values) {
            return Validate::factory($values)
                    ->filters('name', array('trim' => NULL, 'htmlspecialchars' => NULL))
                    ->filters('description', array('trim' => NULL, 'htmlspecialchars' => NULL))
                    ->rules('name', array(
                                    'not_empty' => array(),
                                    'min_length' => array(3),
                                    'max_length' => array(50),
                                    'alpha_dash' => array(),
                            ))
                    ->rules('file', array(
                                'Upload::valid' => array(),
                                'Upload::type' => array($this->allowed_archive_ext),
                              ))
                    ->rule('description', 'max_length', array(255))
                    ->callback('name', array($this, 'is_unique'));
    }

    private function upload_exists(Validate & $array) {
        $array->rules('file', array('Upload::not_empty' => array()));
        return $array->check();
    }
    
    private function upload_install_if_valid(Validate & $array, $tpl_path) {
            $ext = file::get_filename_ext($array['file']['name']);
            Upload::save($array['file'], 'temp.'.$ext);
            $installer = ArchiveInstaller::get_installer_by_ext($ext);
            if ($installer->validate($array, self::$required_files))
                    return $installer->install($tpl_path);
            return false;
    }
    
    public function __get($name) {
        $value = parent::__get($name);
        if ($name == 'created')
            return date("Y-m-d H:i:s", $value);
    }
}
?>
