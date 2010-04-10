<?php defined('SYSPATH') or die('No direct script access');

class Model_FlyOrm extends ORM {

    public function get_errors($name) {
        return $this->_validate->errors($name);
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
			$array->error($target, 'Podana wartość już istnieje, musisz podać inną.' );
    }

    public function get_validator() {
        return $this->_validate;
    }
}
?>
