<?php defined('SYSPATH') or die('No direct script allowe');

    abstract class Controller_Fly extends Controller_Template {
        public function __construct(Kohana_Request $request) {
            fire::log('construct');
            $this->profiler = Profiler::start('dasd', 'dasd');
            parent::__construct($request);
        }
    }


?>
