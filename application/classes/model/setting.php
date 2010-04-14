<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Setting extends Model_FlyOrm {

    protected $_has_one = array('template' => array());

    protected $_filters = array
    (
        TRUE       => array('trim' => NULL),
        'keywords' => array('htmlspecialchars' => NULL),
        'description' => array('htmlspecialchars' => NULL),
        'author' => array('htmlspecialchars' => NULL),
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
		'sidebar_on'                     => array
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
                       
                ),
                'author' =>  array(
                    'max_length' => array(50),
                )
	);

}
?>
