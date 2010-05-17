<?php defined('SYSPATH') or die('No direct script access');

class Validate extends Kohana_Validate {
    	public static function standard_text($value)
	{
            return (bool) preg_match('/^[\pL\pN\pZ\p{Pc}\p{Pd}\p{Po}]++$/uD', (string) $value);
	}

//        public static function & get_callbacks() {
//            return $this->_callbacks;
//        }
}
?>
