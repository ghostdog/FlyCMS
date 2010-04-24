<?php defined('SYSPATH') or die('No direct script access');

class Model_Template extends Model_FlyOrm {

    protected $_belongs_to = array('page' => array());
    protected $_has_one = array('setting' => array());

    private $templates_dir;
    private $allowed_archive_ext;
    private $allowed_img_ext;
    private $errors;
    private static $required_files = array('header.php', 'content.php', 'footer.php', 'sidebar.php');
    private static $thumb_img_w = 225;
    private static $thumb_img_h = 175;
    private static $thumb_img_name = 'example';
//width: 325
//height: 249
    public function __construct($id = null) {
        $this->templates_dir = 'modules/templates/views/';
        $this->allowed_archive_ext = Kohana::config('templates.allowed_archive_ext');
        $this->allowed_img_ext = Kohana::config('templates.allowed_img_ext');
        $this->error_msg_filename = 'templates';
        parent::__construct($id);
    }

    public function __get($name) {
        $value = parent::__get($name);
        if ($name == 'created')
            return date("Y-m-d H:i:s", $value);
        else return $value;
    }

    public function validate_template(Array $values) {
        $this->values($values);
        $validate = $this->get_data_validator($values);
        $this->created = time();
        if ($validate->check()) {
            $tpl_path = $this->templates_dir.$values['name'];
            if (file_exists($tpl_path)) {
                    if ($this->are_required_files_exists($tpl_path)) {
                        $this->create_thumb_img_if_exists($tpl_path, $values['name']);
                        return true;
                    } else {
                        $validate->error('file', Kohana::message($this->error_msg_filename, 'file.invalid'));
                    }
                } else {
                    if ($this->upload_exists($validate)) {
                       if ($this->upload_install_if_valid($validate, $tpl_path)) {
                           $this->create_thumb_img_if_exists($tpl_path, $values['name']);
                           return true;
                       }
                    }
                }
        }
        $this->errors = $validate->errors($this->error_msg_filename); 
        return false;
    }

    public function _delete($id) {
        if ($this->count_all() < 2) return false;
        file::recursive_remove_directory('modules/templates/views/'.$this->name);
        return parent::_delete($id);
    }

    public function set_template_global($id) {
        $this->find($id);
        if (! $this->is_loaded())
                return false;
        $settings = ORM::factory('setting')->find();
        $settings->template = $this;
        $settings->save();
        $old_global = $this->get_global_template();
        if ($old_global->is_loaded()) {
            $old_global->is_global = 0;
            $old_global->save();
        }
        $this->is_global = 1;
        $this->save();
        return true;
    }

    public function get_templates() {
        return $this->find_all();
    }

    public function get_errors() {
        return $this->errors;
    }

   private function are_required_files_exists($tpl_path) {
        $files_found = file::search_by_names($tpl_path, self::$required_files);
        return ! ($files_found == false || sizeof($files_found) != sizeof(self::$required_files));
    }

    private function create_thumb_img_if_exists($tpl_path, $tpl_name) {
        $img_found = file::search_by_ext($tpl_path, $this->allowed_img_ext);
        if ($img_found != false) {
            foreach($img_found as $img) {
                $name = file::remove_ext($img);
                if ($name == self::$thumb_img_name) {
                    $img_lib = Image::factory($tpl_path.'/'.$img);
                    $img_lib->resize(self::$thumb_img_h, self::$thumb_img_w)->sharpen(10);
                    $save_path = DOCROOT.'media/img/tpl_examples/'.$tpl_name.'.'.file::get_ext($img);
                    $img_lib->save($save_path, 100);
                    $this->has_img = 1;
                }
            }
        }
    }

    private function get_data_validator(array $values) {
            return Validate::factory($values)
                    ->filters('name', array('trim' => NULL))
                    ->filters('description', array('trim' => NULL))
                    ->rules('name', array(
                                    'not_empty' => array(),
                                    'min_length' => array(3),
                                    'max_length' => array(50),
                                    'standard_text' => array(),
                            ))
                    ->rules('file', array(
                                'Upload::valid' => array(),
                                'Upload::type' => array($this->allowed_archive_ext),
                              ))
                    ->rule('description', 'max_length', array(255))
                    ->callback('name', array($this, 'is_unique'));
    }

    private function upload_exists(Validate $array) {
        $array->rules('file', array('Upload::not_empty' => array()));
        return $array->check();
    }
    
    private function upload_install_if_valid(Validate & $array, $tpl_path) {
            $ext = file::get_ext($array['file']['name']);
            Upload::save($array['file'], 'temp.'.$ext);
            $installer = ArchiveInstaller::get_installer_by_ext($ext);
            if ($installer->validate($array, self::$required_files))
                    return $installer->install($tpl_path);
            return false;
    }

    private function get_global_template() {
        return ORM::factory('template')->where('is_global', '=', 1)->and_where('id', '!=', $this->id)->find();
    }
}
?>
