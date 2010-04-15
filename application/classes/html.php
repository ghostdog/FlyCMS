<?php defined('SYSPATH') or die('No direct script access');

class HTML extends Kohana_HTML {

    public static function meta($meta_content, $meta_name) {
            if ($meta_name == self::DESC || $meta_name == self::KWORDS)
                    $attr['name'] = $meta_name;
            else $attr['http-equiv'] = $meta_name;
            $attr['content'] = $meta_content;
            return '<meta'.self::attributes($attr).'/>';
    }

    public static function chars($value, $double_encode = TRUE)
    {
            return htmlspecialchars((string) $value, ENT_QUOTES, Kohana::$charset, $double_encode);
    }

    public static function decode_chars($value) {
        return htmlspecialchars_decode($value);
    }



    CONST EQV_CONTENT = 'content-type';
    CONST EQV_STYLE = 'content-style-type';
    CONST EQV_EXP = 'expires';
    CONST EQV_COOKIE = 'set_cookie';
    CONST EQV_REF = 'refresh';
    CONST DESC = 'description';
    CONST KWORDS = 'keywords';
}
?>