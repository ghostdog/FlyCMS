<?php defined('SYSPATH') or die('No direct script access');

abstract class ArchiveInstaller {

    public static $upload_path = '';
    public static $temp_path = '';

    public function __construct() {
        self::$upload_path = DOCROOT.'upload/';
        self::$temp_path = DOCROOT.'tmp/';
        fire::log(self::$upload_path, 'upload_path');
    }
    
    abstract public function validate(Validate & $validate, array $required_content);

    abstract public function install($path);

    public static function get_installer_by_ext($ext) {
        switch ($ext) {
            case 'zip' : return new ZipArchiveInstaller();
                         break;
            default: throw new Kohana_Exception('Nie akceptowane rozszerzenie pliku archiwum.');
        }
    }
}
?>
