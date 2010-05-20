<?php defined('SYSPATH') or die('No direct script access');

class Model_MenuGroup extends Model_FlyOrm {

    protected $_has_many = array('menuitems' => array(), 'pages' => array('through' => 'pagesgroups'));

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
        'ord' => array(
            'digit' => NULL,
        )
    );

    protected $_callbacks = array(
        'name' => array('is_unique'),
    );

    private $group_owners_id = array();

    public function __construct($id = NULL) {
        parent::__construct('menugroup', $id);
    }

    public function save() {
        if (empty($this->created)) {
             $this->created = time();
        }
        parent::save();
        $this->reload();
        if (! $this->is_global) {
            if (! empty($this->group_owners_id)) {
                $page = ORM::factory('page');
                foreach($this->group_owners_id as $id) {
                    $page = $page->find($id);
                    if (! $this->has('pages', $page)) {
                        $this->add('pages', $page->find($id));
                    }
                }
            }
        } else {
            if (Request::instance()->action == 'edit') {
                $count = $this->pages->count_all();
                if ($count) {
                   $pages = $this->pages->find_all();
                   foreach($pages as $page) {
                       $this->remove('pages', $page);
                   }
                }
            }
        }
    }

    public function values($data) {
        parent::values($data);
        if (! isset($data['is_global'])) {
           if (isset($data['pages'])) {
               foreach( $data['pages'] as $key => $value) {
                   $this->group_owners_id[] = $key;
               }
           }
           $this->is_global = 0;
        }
        
    }

    public function check() {
        $result = parent::check();
        if (! $this->is_global) {
            if (empty($this->group_owners_id)) {
                $this->_validate->error('is_global', 'no_pages');
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
        return $this->where('location', '=', $id)->order_by('ord', 'ASC')->find_all();
    }

    public function get_globals() {
        return $this->where('is_global', '=', 1)->order_by('ord', 'ASC')->find_all();
    }

    public function get_all_groups() {
        return $this->find_all();
    }

    public function get_items() {
        return $this->menuitems->find_all();
    }
}
?>
