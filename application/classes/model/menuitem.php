<?php defined('SYSPATH') or die('No direct script access');

class Model_MenuItem extends ORM_MPTT {

    protected $_belongs_to = array('menugroup' => array());

    protected $_filters = array(
        'name' => array('trim' => NULL),
        'link' => array('trim' => NULL),
        'title' => array('trim' => NULL),

    );

    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(100),
        ),
        'link' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(100),
        ),
        'title' => array(
             'max_length' => array(100),
        )
    );

    private $errors_filename = 'menuitems';

    public function  __set($name,  $value) {
        if ($name == 'created') {
            $value = time();
        }
        parent::__set($name, $value);
    }

    public function get_empty_items($quantity = 1) {
        $arr_obj = new ArrayObject(array());
        for ($i = 0; $i < $quantity; $i++) {
             $arr_obj->append($this);
        }
        return $arr_obj;
    }

    public function get_errors() {
        return $this->_validate->errors($this->errors_filename);
    }

    

}
?>
