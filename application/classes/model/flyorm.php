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
                $exists = (bool) $this->where($target, '=', $array[$target])->count_all();
		if ($exists)
			$array->error($target, 'unique');
    }
}
?>
