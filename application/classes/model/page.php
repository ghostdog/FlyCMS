<?php defined('SYSPATH') or die('No direct script access');

class Model_Page extends Model_FlyOrm {

    protected $_filters = array(
                            'title' => array('trim' => NULL),
                            'content' => array('trim' => NULL),
                            'keywords' => array('trim' => NULL),
                            'description' => array('trim' => NULL)
                       );

    protected $_has_many = array('menugroups' => array('through' => 'pagesgroups'), 'sections' => array('through' => 'pagessections'));
    
    protected $_belongs_to = array('template' => array());

    protected $_rules = array(

               'title' => array(
                   'not_empty' => array(),
                   'min_length' => array(3),
                   'max_length' => array(100),

               ),
               'keywords' => array(
                   'max_length' => array(255),
               ),
               'description' => array(
                   'max_length' => array(255),
               ),
               'template_id' => array(
                   'digit' => array(),
               ),
               'header_on' => array(
                   'digit' => array(),
               ),
               'footer_on' => array(
                   'digit' => array(),
               ),
               'sidebar_on' => array(
                   'digit' => array(),
               ),
               'is_main' => array(
                   'digit' => array(),
               ),
               'created' => array(
                   'digit' => array(),
               ),
               'last_modified' => array(
                   'digit' => array(),
               ),
               'author' => array(
                   'max_length' => array(50),
               )
    );

    protected $_callbacks = array(
        'title' => array('is_unique'),
    );

    private $result = array('msg' => '', 'is_success' => NULL);

    public function __construct($id = null) {
        parent::__construct('pages', $id);
    }

    public function get_main_page() {
        $main_page = ORM::factory('page')->where('is_main', '=', 1)->find();
        if (! $main_page->loaded()) {
            $main_page->find();
        }
        return $main_page;
    }

    public function get_by_link($link) {
        $this->where('link', '=', $link)->find();
        if (! $this->_loaded) {
            $this->get_main_page();
        }
        return $this;
    }

    public function get_sections() {
        $page_sections = $this->sections->order_by('ord', 'ASC')->find_all();
        $global_sections = ORM::factory('section')->get_globals();
        $arr_obj = $this->db_result2arr_obj($global_sections());
        return $this->db_result2arr_obj($page_sections, $arr_obj);
    }

    public function get_pages() {
        return $this->order_by('is_main', 'DESC')->find_all();
    }

    public function save() {
        fire::log($this->_object, 'object');
        if (empty($this->link) OR isset($this->_changed['link'])) {
            $this->create_link();
        }
        if (empty($this->created)) {
            $this->created = time();
        } else {
            $this->last_modified = time();
        }
        if ($this->is_main) {
            $old_main = $this->get_main_page();
            if ($old_main->loaded()) {
                $old_main->is_main = 0;
                $old_main->save();
            }
        }
        $settings = ORM::factory('setting')->find();
        if (is_null($this->header_on)) {
                $this->header_on = $settings->header_on;
        }
        if (is_null($this->sidebar_on)) {
                $this->sidebar_on = $settings->sidebar_on;
        }
        if (is_null($this->footer_on)) {
                $this->footer_on = $settings->footer_on;
        }
        if (empty($this->keywords)) {
                $this->keywords = $settings->keywords;
        }
        if (empty($this->description)) {
                $this->description = $settings->description;
        }
        if (empty($this->author)) {
                $this->author = $settings->author;
        }
        if (empty($this->template_id)) {
            $this->template = $settings->template;
        }
        fire::log($this->_object, 'object  after save');
        parent::save();
    }

    public function values($values) {
        foreach($values as $key => $val) {
            if ($val == self::NOT_SET) {
                $values[$key] = NULL;
            }
        }
        return parent::values($values);
    }

    public function _delete($id) {
        $this->set_result($this->get_msg('pages.success.delete'));
        if (is_array($id)) {
                $pages = ORM::factory('page')->where('id', 'IN', $id)->find_all();
                foreach ($pages as $page) {
                    $this->delete_if_allowed($page);
                }
        } else {
            $this->find($id);
            if ($this->_loaded) {
                $this->delete_if_allowed();
            } else {
                $this->set_result($this->get_msg('pages.fail.delete'), FALSE);
            }
        }
    }

    public function get_result() {
        return $this->result;
    }

    public function __get($name) {
        $value = parent::__get($name);
        if ($name == 'created' || $name == 'last_modified')
            return date("Y-m-d H:i:s", $value);
        else return $value;
    }


    private function create_link() {
        $link = text::pl2en($this->title);
        $link = trim(preg_replace('/[^A-Za-z0-9\-\s]+/', '', $link));
        $link = preg_replace('/\s+/', '-', $link);
        $link = preg_replace('/^(-*)|(-*$)/', '', $link);
        $this->link = strtolower($link);
    }

    private function delete_if_allowed($page = NULL) {
        if (is_null($page)) {
            $page = $this;
        }
        if ($this->count_all() > 1) {
//            if (! $page->is_main) {
                $page->delete();
//            } else {
//                $this->set_result($this->get_msg('pages.fail.main_page'), FALSE);
//            }
        } else {
            $this->set_result($this->get_msg('pages.fail.last_page'), FALSE);
        }
    }

    private function db_result2arr_obj($results, $arr_obj = NULL) {
        if (is_null($arr_obj)) {
            $arr_obj = new ArrayObject();
        }
        foreach($results as $result) {
            $arr_obj->append($result);
        }
        return $arr_obj;
    }

    private function set_result($msg, $is_success = TRUE) {
        $this->result['msg'] = $msg;
        $this->result['is_success'] = $is_success;
    }

    private function get_msg($path) {
        return Kohana::message('messages', $path);
    }
    CONST NOT_SET = -1;
}
?>
