<?php defined('SYSPATH') or die('No direct script access');

class Model_Enrollment extends ORM  {
    protected $_belongs_to = array('page' => array(), 'menugroup' => array());
}
?>
