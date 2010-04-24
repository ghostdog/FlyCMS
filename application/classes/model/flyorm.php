<?php defined('SYSPATH') or die('No direct script access');

class Model_FlyOrm extends ORM {

    protected $error_msg_filename = '';

    public function get_errors() {
        return $this->_validate->errors($this->error_msg_filename);
    }

    public function save_if_valid(Array $values) {
        if ($this->values($values)->check()) {
            $this->save();
            return true;
        } 
        return false;
    }
    
    public function is_unique(Validate $array, $target) {
                $exists = (bool) $this->where($target, '=', $array[$target])->and_where('id', '!=', $this->id)->count_all();
		if ($exists)
			$array->error($target, 'unique');
    }

    public function is_saved() {
        return $this->_saved;
    }

    public function is_loaded() {
        return $this->_loaded;
    }

    public function _delete($id) {
        $this->find($id);
        if ($this->_loaded) {
            $this->delete();
            return true;
        }
        else {
            return false;
        }
    }

    public function find_all_except_this() {
        return ORM::factory($this->_object_name)->where('id', '!=', $this->id)->find_all();
    }

    public function get_validate() {
        return $this->_validate;
    }

    public function get_callbacks() {
        return $this->_callbacks;
    }

    protected function get_config($key) {
        $model_name = preg_replace('/Model_/', '', get_class($this));
        return Kohana::config(Inflector::plural($model_name).'.'.$key);
    }

    protected function get_error_msg($key) {
        return Kohana::message($this->error_msg_filename, $key);
    }
}
?>
