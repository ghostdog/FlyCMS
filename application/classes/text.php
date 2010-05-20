<?php defined('SYSPATH') or die('No direct script access');

class Text extends Kohana_Text {

    public static function pl2en($string) {

        if (empty($string)) return '';
        $aPL = array('ą', 'ę', 'ć', 'ś', 'ł','ń', 'ó', 'ż', 'ź', 'Ą', 'Ę', 'Ć', 'Ś', 'Ł','Ń', 'Ó', 'Ż', 'Ź');
        $aEN = array('a', 'e', 'c', 's', 'l','n', 'o', 'z', 'z', 'A', 'E', 'C', 'S', 'L','N', 'O', 'Z', 'Z');
        return str_ireplace($aPL, $aEN, $string);
                 
    }

    public static function first_words($string, $num = 1, $tail='&nbsp;') {
            /** words into an array **/
            $words = str_word_count($string, 2);

            /*** get the first $num words ***/
            $firstwords = array_slice( $words, 0, $num);

            /** return words in a string **/
            return  implode(' ', $firstwords).$tail;
    }
}
?>
