<?php defined('SYSPATH') or die('No direct script access');

class Model_MenuGroup extends Model_FlyOrm {

    protected $_has_many = array('menuitems' => array(), 'pages' => array('through' => 'pagemenu'));

    protected $_filters = array(
        'name' => array('trim' => NULL),
    );
    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(100)
        ),
        'location' => array(
            'range' => array(0,2),
        ),
        'is_global' => array(
            'range' => array(0,1),
        ),
        'order' => array(
            'digit' => NULL,
        )
    );

    protected $_callbacks = array(
        'name' => array('is_unique'),
    );

    public function __construct($id = NULL) {
        parent::__construct('menugroup', $id);
    }

    public function save() {
        $this->created = time();
        parent::save();
    }

    public function __get($name) {
        $value = parent::__get($name);
        if ($name == 'created')
            return date("Y-m-d H:i:s", $value);
        else return $value;
    }

    public function get_groups_by_location($id) {
        return $this->where('location', '=', $id)->order_by('order', 'ASC')->find_all();
    }
}
?>
