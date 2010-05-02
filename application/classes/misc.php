<?php defined('SYSPATH') or die('No direct script access');

	class Misc {
		private function __construct() {}
		
		public static function print_if(& $value = null, $default = '') {
			if (isset($value)) {
				echo $value;
			} else {
				if (! empty($default))
					echo $default;
			}
		}

                public static function empty_assoc_array_from_keys(Array $keys) {
                    foreach ($keys as $key) {
                        $result[$key] = null;
                    }
                    return $result;
                }

                public static function get_raw_db_result(Database_Result $result, Array $columns) {
                    $result = $result->as_array();
                    foreach ($result as $r) {
                        foreach($columns as $col) {
                            $temp[$col] = $r->$col;
                        }
                        $output[] = $temp;
                    }
                     return $output;
                }
	}

?>