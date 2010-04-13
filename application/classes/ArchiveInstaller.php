<?php defined('SYSPATH') or die('No direct script access');

abstract class ArchiveInstaller {

    protected $upload_path = '';
    protected $temp_path = '';

    public function __construct() {
        $this->upload_path = DOCROOT.'upload/';
        $this->temp_path = DOCROOT.'tmp/';
    }

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
