<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {

    public static function fieldset($legend = '', $attr = array()) {
        $output = '<fieldset '.html::attributes($attr).'>';
        if (! empty($legend)) $output .= '<legend>'.$legend.'</legend>';
        return $output;
   }

   public static function close_fieldset() {
       return '</fieldset>';
   }
   public static function cluetip($id, $value) {
       return '<div id="'.$id.'-tip" class="cluetip">'.$value.'</div>';
   }

   public static function help($id, $value) {
       $output = html::anchor('#'.$id.'-help', 'Co to jest?');
       return $output .= '<div id="'.$id.'-help" class="help">'.$value.'</div>';
   }

   public static function error(& $error = '') {
        return (! empty($error)) ? '<strong class="error">'.$error.'</strong>' : '';
   }

   public static function text_w_label($id, $label, $value = null , $attr = array()) {
       $output = '<div class="input-wrap">';
       $output .= form::label($id, $label);
       $attr['id'] = $id;
       $output .= form::input($id, $value, $attr);
       return $output .= '</div>';
   }

   public static function tarea_w_label($id, $label, $value = null, $attr = array()) {
       $output = '<div class="input-wrap">';
       $output .= form::label($id, $label);
       $attr['id'] = $id;
       $output .= form::textarea($id, $value, $attr);
       return $output .= '</div>';
   }

   public static function select_w_label($id, $label, $value = null, $options = array(), $attr = array()) {
       $output = '<div class="input-wrap-label-right">';
       $output .= form::label($id, $label);
        $attr['id'] = $id;
       $output .= form::select($id, $options, $value, $attr);
       return $output .= '</div>';
   }

   public static function check_w_label($id, $label, $value = null, $attr = array()) {
       $output = '<div class="input-wrap-label-right">';
       $output .= form::label($id, $label);
       if (! is_null($value)) $checked = true; else $checked = false;
        $attr['id'] = $id;
       $output .= form::checkbox($id, $value, $checked, $attr);
       return $output .= '</div>';
   }

   public static function submit_div($name, $value, $attr = array()) {
       $submit = form::submit($name, $value, $attr);
       return '<div class="submit">'.$submit.'</div>';

   }

}
