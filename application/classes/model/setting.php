<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Setting extends Model_FlyOrm {

    protected $_has_one = array('template' => array());

    protected $_filters = array
    (
        TRUE       => array('trim' => array()),
    );


    protected $_rules = array
	(
		'title'			=> array
		(
			'not_empty'		=> NULL,
			'min_length'		=> array(3),
			'max_length'		=> array(50),
		),
                'subtitle'			=> array
		(
			'not_empty'		=> NULL,
			'min_length'		=> array(3),
			'max_length'		=> array(50),
		),
		'template_id'	=> array
		(
			'not_empty'             => NULL,
                        'validate::digit'  => NULL,
		),
		'header_on'                     => array
		(
			'validate::digit'	=> NULL,
		),
		'footer_on'                     => array
		(
			'validate::digit'	=> NULL,
		),
		'column'                     => array
		(
			'validate::digit'	=> NULL,
		),
		'keywords'                     => array
		(
                        'max_length'          => array(255),
                        
		),
                'description'                 => array
                (
                        'max_length'          => array(255),
                       
                )
	);

//	protected $_callbacks = array
//	(
//		'username'			=> array('username_available'),
//		'email'					=> array('email_available'),
//	);

        protected $_has_one = array('template' => array());


    
}
?>
