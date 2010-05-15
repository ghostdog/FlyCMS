<?php defined('SYSPATH') or die('No direct script access');

class Model_Page extends Model_FlyOrm {

    protected $_filters = array(
                            'title' => array('trim' => NULL),
                            'content' => array('trim' => NULL),
                            'keywords' => array('trim' => NULL),
                            'description' => array('trim' => NULL)
                       );

    protected $_has_many = array('templates' => array(), 'menugroups' => array('through' => 'enrollments'));

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
               'content' => array(
                   'not_empty' => array(),
                   'min_length' => array(10),
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

    public function get_pages() {
        return $this->order_by('is_main', 'DESC')->find_all();
    }

    public function save() {
        if (empty($this->link) || isset($this->_changed['link'])) {
            $this->create_link();
        }
        if (empty($this->created)) {
            $this->created = time();
        } else {
            $this->last_modified = time();
        }
        if ($this->is_main) {
            $old_main = $this->get_main_page();
            if ($old_main->_loaded) {
                $old_main->is_main = 0;
                $old_main->save();
            }
        }
        return parent::save();
    }

    public function values($values) {
        foreach($values as $key => $val) {
            if ($val == self::NOT_SET)
                $values[$key] = NULL;
        }
        return parent::values($values);
    }

    public function _delete($id) {
        $this->set_result($this->get_msg('pages.success.delete'));
        if (is_array($id)) {
                $pages = ORM::factory('page')->where('id', 'IN', $id)->find_all();
                foreach ($pages as $page) {
                  if ($page->is_main) {
                        $this->set_result($this->get_msg('pages.fail.main_page'), FALSE);
                  } else {
                      $page->delete();
                  }
                }
        } else {
            $this->find($id);
            if ($this->_loaded) {
                if ($this->is_main) {
                    $this->set_result($this->get_msg('pages.fail.main_page'), FALSE);
                } else {
                    $this->delete();
                }
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

    public function get_main_page() {
        return ORM::factory('page')->where('is_main', '=', 1)->find();
    }

    private function create_link() {
        $link = text::pl2en($this->title);
        $link = trim(preg_replace('/[^A-Za-z0-9\-\s]+/', '', $link));
        $link = preg_replace('/\s+/', '-', $link);
        $link = preg_replace('/^(-*)|(-*$)/', '', $link);
        $this->link = strtolower($link);
    }

    private function set_result($msg, $is_success = TRUE) {
        $this->result['msg'] = $msg;
        $this->result['is_success'] = $is_success;
    }

    private function get_msg($path) {
        return Kohana::message('messages', $path);
    }

    private function set_global_settings_if_required($global) {
        if (empty($this->template)) {
                $this->template = $global->template;
        }
        if (is_null($this->header_on)) {
                $this->header_on = $global->header_on;
        }
        if (is_null($this->sidebar_on)) {
                $this->sidebar_on = $global->sidebar_on;
        }
        if (is_null($this->footer_on)) {
                $this->footer_on = $global->footer_on;
        }
        if (empty($this->keywords)) {
                $this->keywords = $global->keywords;
        }
        if (empty($this->description)) {
                $this->description = $global->description;
        }
        if (empty($this->author)) {
                $this->author = $global->author;
        }
    }
    CONST NOT_SET = -1;
}
?>
