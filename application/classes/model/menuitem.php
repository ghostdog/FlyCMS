<?php defined('SYSPATH') or die('No direct script access');

class Model_MenuItem extends ORM_MPTT {

    protected $_belongs_to = array('menugroup' => array());

    public function  __set($name,  $value) {
        if ($name == 'created') {
            $value = time();
        }
        parent::__set($name, $value);
    }

    public function add_items(array $items) {
        if ($items['type'] == 'group') {
            $firstItem = 1;
           
        } else {
            $firstItem = 0;
        }
    }

    public function get_empty_items($quantity = 1) {
        $arr_obj = new ArrayObject(array());
        for ($i = 0; $i < $quantity; $i++) {
             $arr_obj->append($this);
        }
        return $arr_obj;
    }

    

}
?>
