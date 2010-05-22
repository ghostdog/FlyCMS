<?php defined('SYSPATH') or die('No direct script access');

abstract class Model_FlyOrm extends ORM {

    protected $errors_filename = '';

    private $result = array();

    public function  __construct($errors_filename, $id = null) {
        $this->errors_filename = $errors_filename;
        parent::__construct($id);
    }

    public function save_if_valid(Array $values) {
        if ($this->values($values)->check()) {
            $this->save();
            return true;
        } 
        return false;
    }
    
    public function is_unique(Validate $array, $target) {
                $query = $this->where($target, '=', $array[$target]);
                if (Request::instance()->action == 'edit') {
                    $query->and_where('id', '!=', $this->id);
                }
                $exists = (bool) $query->count_all();

		if ($exists) {
			$array->error($target, 'unique');
                }
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

    public function get_result() {
        return $this->result;
    }

    public function get_errors() {
        return $this->_validate->errors($this->errors_filename);
    }

    public function get_error_msg($path) {
        return Kohana::message($this->errors_filename, $path);
    }
    
    protected function get_config($key) {
        return Kohana::config($this->get_msg_group_name().'.'.$key);
        
    }

    protected function set_result($msg_name, $is_success = TRUE) {
        $msg_group = $this->get_msg_group_name();
        $msg_type = ($is_success) ? 'success' : 'fail';
        $this->result['msg'] = Kohana::message('messages', $msg_group.'.'.$msg_type.'.'.$msg_name);
        $this->result['is_success'] = $is_success;
    }

    private function execute($sql) {
        try {
            $result = $sql->execute();
        } catch (Database_Exception $ex) {
              return FALSE;
        }
        return $result;
    }

    private function get_msg_group_name() {
        return Inflector::plural(str_replace('Model_', '', get_class($this)));
    }

}
?>
