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
	}

?>