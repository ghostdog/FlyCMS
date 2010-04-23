<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Setting extends Model_FlyOrm {

    protected $_has_one = array('template' => array());

    protected $error_msg_filename = 'settings';

    protected $_filters = array
    (
        TRUE       => array('trim' => NULL),
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
			'max_length'		=> array(50),
		),
		'template_id'	=> array
		(
			'not_empty'             => NULL,
                        'digit'  => NULL,
		),
		'header_on'                     => array
		(
			'range'	=> array(0, 1),
		),
		'footer_on'                     => array
		(
			'range'	=> array(0, 1),
		),
		'sidebar_on'                     => array
		(
			'range'	=> array(0, 1),
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
