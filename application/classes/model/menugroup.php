<?php defined('SYSPATH') or die('No direct script access');

class Model_MenuGroup extends Model_FlyOrm {

    protected $_has_many = array('menuitems' => array(), 'pages' => array('through' => 'pagemenu'));

    protected $_filters = array(
        'name' => array('trim' => NULL),
    );
    protected $_rules = array(
        'name' => array(
            'not_empty' => array(),
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

    private $pages_id = array();

    public function __construct($id = NULL) {
        parent::__construct('menugroup', $id);
    }

    public function save() {
        $this->created = time();
        parent::save();
    }

    public function values($data) {
        if (! isset($data['is_global'])) {
           if (isset($data['pages'])) {
               $this->pages_id = $data['pages'];
           }
           $data['is_global'] = 0;
        }
        parent::values($data);
    }

    public function check() {
        $result = parent::check();
        if (! $this->is_global) {
            if (empty($this->pages_id)) {
                $this->get_validate()->error('is_global', 'no_pages');
                return false;
            }
        }
        return $result;
    }

    public function __get($name) {
        $value = parent::__get($name);
        if ($name == 'created')
            return date("Y-m-d H:i:s", $value);
        else return $value;
    }

    public function get_by_location($id) {
        return $this->where('location', '=', $id)->order_by('order', 'ASC')->find_all();
    }

    public function get_all_groups() {
        return $this->find_all();
    }

    public function get_parent_pages_if_exists() {
        if (! $this->is_global) {
            return $this->pages->find_all();
        } else {
            return FALSE;
        }
    }
}
?>
