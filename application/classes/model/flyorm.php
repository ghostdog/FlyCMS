<?php defined('SYSPATH') or die('No direct script access');

class Model_FlyOrm extends ORM {

    protected $errors_filename = '';

    public function  __construct($errors_filename, $id = null) {
        $this->errors_filename = $errors_filename;
        parent::__construct($id);
    }

    public function get_errors() {
        return $this->_validate->errors($this->errors_filename);
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
    
    public function _delete($id) {
        if (is_array($id)) {
                $sql = DB::delete($this->_table_name)->where('id', 'IN', $id);
                return $this->execute($sql);
        } else {
            $this->find($id);
            if ($this->_loaded) {
                $this->delete();
                return true;
            }
        }
        return false;
    }

    public function find_all_except_this() {
        return ORM::factory($this->_object_name)->where('id', '!=', $this->id)->find_all();
    }
    
    protected function get_config($key) {
        $model_name = preg_replace('/Model_/', '', get_class($this));
        return Kohana::config(Inflector::plural($model_name).'.'.$key);
    }

    protected function execute($sql) {
        try {
            $result = $sql->execute();
        } catch (Database_Exception $ex) {
              return FALSE;
        }
        return $result;
    }

}
?>
