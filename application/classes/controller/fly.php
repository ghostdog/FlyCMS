<?php defined('SYSPATH') or die('No direct script allowe');

    abstract class Controller_Fly extends Controller_Template {

            protected function m($model_name, $id = NULL) {
                if (! isset($this->$model_name)) {
                       $this->$model_name = ORM::factory($model_name, $id);
                }
                return $this->$model_name;
            }

            protected function mf($model_name, $id = NULL) {
                return ORM::factory($model_name, $id);
            }

    }


?>
