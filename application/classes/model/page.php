<?php defined('SYSPATH') or die('No direct script access');

class Model_Page extends Model_FlyOrm {

    protected $_has_many = array('templates' => array(), 'menugroups' => array('through' => 'pagemenu'));

    protected $_rules = array(

               'title' => array(
                   'not_empty' => array(),
                   'min_length' => array(3),
                   'max_length' => array(100),

               ),
//               'link' => array(
//                   'not_empty' => NULL,
//                   'min_length' => array(3),
//                   'max_length' => array(100),
//               ),
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
        'link' => array('is_unique'),
    );

    public function __construct($id = null) {
        parent::__construct('pages', $id);
    }

    public function get_pages() {
       // $global_settings = Model::factory('setting');
        $pages = $this->find_all();
        foreach($pages as $page) {
           // $this->set_global_data_if_required($page, $global_settings);
        }
        return $pages;
    }

    public function save() {
        $this->create_link();
        if (! $this->_loaded) $this->created = time();
        else $this->last_modified = time();
        return parent::save();
    }

    public function values($values) {
        foreach($values as $key => $val) {
            $values[$key] = utf8::trim($val);
            if ($val == self::NOT_SET)
                $values[$key] = NULL;
        }
        if (! isset($values['description']))
            $values['desciption'] = NULL;
        if (! isset($values['keywords']))
            $values['keywords'] = NULL;
        return parent::values($values);
    }

    public function __get($name) {
        $value = parent::__get($name);
        if ($name == 'created' || $name == 'last_modified')
            return date("Y-m-d H:i:s", $value);
        else return $value;
    }

    public function has_keywords() {
        return ! empty($this->keywords);
    }

    public function has_description() {
        return ! empty($this->description);
    }

    public function has_subtitle() {
        return ! empty($this->subtitle);
    }

    public function has_global_header_setting() {
        return is_null($this->header_on);
    }

    public function has_author() {
        return ! empty($this->author);
    }

    public function has_global_footer_setting() {
        return is_null($this->footer_on);
    }

    public function has_global_sidebar_setting() {
        return is_null($this->sidebar_on);
    }

    public function has_global_template_setting() {
        return is_null($this->template_id);
    }

    public function create_link() {
        $link = text::pl2en($this->title);
        $link = trim(preg_replace('/[^A-Za-z0-9\-\s]+/', '', $link));
        $link = preg_replace('/\s+/', '-', $link);
        $link = preg_replace('/^(-*)|(-*$)/', '', $link);
        $this->link = strtolower($link);
    }

    private function set_global_data_if_required($page, $global) {
        if ($page->has_global_template_setting())
                $page->template = $global->template;
        if ($page->has_global_header_setting())
                $page->header_on = $global->header_on;
        if ($page->has_global_sidebar_setting())
                $page->header_on = $global->sidebar_on;
        if ($page->has_global_footer_setting())
                $page->footer_on = $global->footer_on;
    }
    CONST NOT_SET = -1;
}
?>
