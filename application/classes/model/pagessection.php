<?php defined('SYSPATH') or die('No direct script access');

    class Model_Pagessection extends ORM {
        protected $_belongs_to = array('page' => array(), 'section' => array());
    }
    
?>
