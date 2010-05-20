<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Setting extends Model_FlyOrm {

    protected $_belongs_to = array('theme' => array());

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

        public function  __construct($id = null) {
            parent::__construct('settings', $id);
        }

}
?>
