<?php defined('SYSPATH') or die('No direct script allowe');

    abstract class Controller_Fly extends Controller_Template {
        protected $is_ajax;

        public function before() {
            parent::before();
            if (Request::$is_ajax || $this->request !== Request::instance()) {
                $this->is_ajax = TRUE;
            }
        }
    }


?>
