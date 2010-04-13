<?php defined('SYSPATH') or die('No direct script access');

abstract class ArchiveInstaller {

    public static $upload_dir = 'upload/';
    public static $temp_dir = 'tmp/';

    abstract public function validate(Validate $validate, array $required_content);

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
