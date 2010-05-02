<?php defined('SYSPATH') or die('No direct script access');

class Model_PageMenu extends ORM  {
    protected $_belongs_to = array('pages' => array(), 'menugroups' => array());
}
?>
