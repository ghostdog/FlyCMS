<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Setting extends Model_FlyOrm {

    protected $_has_one = array('template' => array());

    protected $error_msg_filename = 'settings';

    protected $_filters = array
    (
        TRUE       => array('trim' => NULL),
        'keywords' => array('html::chars' => NULL),
        'description' => array('html::chars' => NULL),
        'author' => array('html::chars' => NULL),
        'title' => array('html::chars' => NULL),
        'subtitle' => array('html::chars' => NULL),
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
			'min_length'		=> array(3),
			'max_length'		=> array(50),
		),
		'template_id'	=> array
		(
			'not_empty'             => NULL,
                        'digit'  => NULL,
		),
		'header_on'                     => array
		(
			'digit'	=> NULL,
		),
		'footer_on'                     => array
		(
			'digit'	=> NULL,
		),
		'sidebar_on'                     => array
		(
			'digit'	=> NULL,
		),
		'keywords'                     => array
		(
                        'max_length'          => array(255),
                        
		),
                'description'                 => array
                (
                        'max_length'          => array(255),
                       
                ),
                'author' =>  array(
                    'max_length' => array(50),
                )
	);

}
?>
