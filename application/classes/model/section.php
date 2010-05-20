<?php defined('SYSPATH') or die('No direct script access');

class Model_Section extends Model_FlyOrm {

    protected $_has_many = array('pages' => array('through' => 'pagessections'));

    protected $_filters = array(
        'name' => array('trim' => null),
    );
    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(50),
            'validate::standard_text' => array(),
        ),
        'content' => array(
            'not_empty' => NULL,
        ),
    );

    protected $_callbacks = array(
        'name' => array('is_unique'),
    );

    private $section_additional_owners_id = array();

    public function __construct($id = null) {
        parent::__construct('sections', $id);
    }

    public function get_globals() {
        return $this->where('is_global', '=', 1)->order_by('ord', 'ASC')->find_all();
    }

    public function values($values) {
        if (isset($values['pages'])) {
            $this->section_additional_owners_id = array_keys($values['pages']);
        }
        return parent::values($values);
    }

    public function _save($current_page) {
        if (empty($this->created)) {
            $this->created = time();
        } else {
            $this->last_modified = time();
        }
        
        parent::save();
        $this->reload();
        if (! $this->is_global) {
            if (! $this->has('pages', $current_page)) {
                $current_page->add('sections', $this);
            }
            if (! empty($this->section_additional_owners_id)) {
                    $page = ORM::factory('page');
                    foreach($this->section_additional_owners_id as $id) {
                       $page->find($id);
                       if (! $this->has('pages', $page)) {
                           $this->add('pages', $page);
                       }
                    }
            }
            if (Request::instance()->action == 'edit') {
                $pages = $this->pages->find_all();
                foreach($pages as $page) {
                    if (! in_array($page->id, $this->section_additional_owners_id)) {
                        $this->remove('pages', $page);
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

    public function get_section_pages() {
        if ($this->pages->count_all()) {
            return $this->pages->find_all();
        }
        return FALSE;
    }
    
    public function get_empty_sections($quantity = 1) {
        $arr_obj = new ArrayObject(array());
        for ($i = 0; $i < $quantity; $i++) {
             $arr_obj->append($this);
        }
        return $arr_obj;
    }
}
?>
