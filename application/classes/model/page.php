<?php defined('SYSPATH') or die('No direct script access');

class Model_Page extends Model_FlyOrm {

    protected $_filters = array(
                            'title' => array('trim' => NULL),
                            'content' => array('trim' => NULL),
                            'keywords' => array('trim' => NULL),
                            'description' => array('trim' => NULL)
                       );

    protected $_has_many = array('menugroups' => array('through' => 'pagesgroups'), 'sections' => array('through' => 'pagessections'));
    
    protected $_belongs_to = array('theme' => array());

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
        $arr_obj = misc::result_obj2arr_obj($global_sections);
        return misc::result_obj2arr_obj($page_sections, $arr_obj);
    }

    public function get_menus() {
        $page_menus = $this->menugroups->order_by('ord', 'ASC')->find_all();
        $global_menus = ORM::factory('menugroup')->get_globals();
        $menus_all = misc::result_obj2arr_obj($global_menus);
        $menus_all = misc::result_obj2arr_obj($page_menus, $menus_all);
        $header_menus = new ArrayObject();
        $sidebar_menus = new ArrayObject();
        $content_menus = new ArrayObject();
        foreach($menus_all as $menu) {
            $location = (int) $menu->location;
            switch ($location) {
                case 0 : $header_menus->append($menu);
                         break;
                case 1 : $sidebar_menus->append($menu);
                         break;
                case 2 : $content_menus->append($menu);
                         break;
            }
        }
        $menus['header'] = $header_menus;
        $menus['sidebar'] = $sidebar_menus;
        $menus['content'] = $content_menus;
        return $menus;
    }

    public function get_pages() {
        return $this->order_by('is_main', 'DESC')->find_all();
    }

    public function get_theme_name() {
        $name = $this->theme->find()->name;
        if (empty($name)) {
           return ORM::factory('theme')->get_global_theme()->name;
        }
        return $name;
    }

    public function save() {
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
        if (empty($this->theme_id)) {
            $this->theme = $settings->theme;
        }
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
        $this->set_result('delete', TRUE);
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
                $this->set_result('delete', FALSE);
            }
        }
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
                $sections = $page->sections->find_all();
                foreach ($sections as $section) {
                    $section->delete();
                }
                $page->delete();
//            } else {
//                $this->set_result('main_page', FALSE);
//            }
        } else {
            $this->set_result('last_page', FALSE);
        }
    }
    CONST NOT_SET = -1;
}
?>
