<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-05-18 00:03:15 --- ERROR: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ APPPATH/views\page_form.php [ 44 ]
2010-05-18 00:07:48 --- ERROR: Database_Exception [ 1048 ]: Column 'page_id' cannot be null [ INSERT INTO `pagessections` (`section_id`, `page_id`) VALUES ('10', NULL) ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 00:11:21 --- ERROR: Database_Exception [ 1048 ]: Column 'page_id' cannot be null [ INSERT INTO `pagessections` (`section_id`, `page_id`) VALUES ('11', NULL) ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 00:13:01 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/views\section.php [ 88 ]
2010-05-18 00:15:58 --- ERROR: ErrorException [ 8 ]: Undefined index: name ~ APPPATH/views\section.php [ 88 ]
2010-05-18 00:23:31 --- ERROR: Database_Exception [ 1048 ]: Column 'page_id' cannot be null [ INSERT INTO `pagessections` (`section_id`, `page_id`) VALUES ('12', NULL) ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 01:48:59 --- ERROR: Database_Exception [ 1048 ]: Column 'page_id' cannot be null [ INSERT INTO `pagessections` (`section_id`, `page_id`) VALUES ('13', NULL) ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 01:54:48 --- ERROR: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ APPPATH/views\page_form.php [ 44 ]
2010-05-18 11:49:23 --- ERROR: ErrorException [ 8 ]: Undefined index: controller ~ SYSPATH/classes\kohana\request.php [ 553 ]
2010-05-18 11:49:28 --- ERROR: ReflectionException [ -1 ]: Class controller_admin_ages does not exist ~ SYSPATH/classes\kohana\request.php [ 864 ]
2010-05-18 12:17:15 --- ERROR: Kohana_Exception [ 0 ]: The template property does not exist in the Model_Page class ~ MODPATH/orm\classes\kohana\orm.php [ 425 ]