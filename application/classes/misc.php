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

   
                public static function result_obj2arr(Database_Result $result, Array $columns) {
                    $output = array();
                    $result = $result->as_array();
                    foreach ($result as $r) {
                        foreach($columns as $col) {
                            $temp[$col] = $r->$col;
                        }
                        $output[] = $temp;
                    }
                     return $output;
                }

                public static function result_obj2arr_obj(Database_Result $results, $arr_obj = NULL) {
                    if (is_null($arr_obj)) {
                        $arr_obj = new ArrayObject();
                    }
                    foreach($results as $result) {
                        $arr_obj->append($result);
                    }
                    return $arr_obj;
                }
	}

?>