<?php defined('SYSPATH') or die('No direct script access');

class Model_Menu extends ORM_MPTT {

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
    

}
?>
