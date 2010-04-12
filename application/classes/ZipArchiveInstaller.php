<?php defined('SYSPATH') or die('No direct script access');

class ZipArchiveInstaller extends ArchiveInstaller {

    private $zip;

    public function __construct() {
        $this->zip = new ZipArchive();
        parent::__construct();
    }

    public function validate(Validate $validate, array $required_content) {
        $this->zip->open(self::$upload_path.'temp.zip');
        $tmp_extract_folder = self::$temp_path.time();
        Fire::log($tmp_extract_folder, 'tmp_extract_folder');
        Fire::log($required_content, 'required_content');
        $this->zip->extractTo($tmp_extract_folder);
        $files_found = file::search_dir_files_by_names($tmp_extract_folder, $required_content);
        if ($files_found == FALSE || sizeof($required_content) != sizeof($files_found)) {
            $validate->error('file', Kohana::message('templates', 'file.invalid'));
            file::recursive_remove_directory($tmp_extract_folder);
            return false;
        }
        file::recursive_remove_directory($tmp_extract_folder);
        return true;
    }

    public function install($path) {
        Fire::log($path, 'Path');
        return $this->zip->extractTo($path);
    }
}
?>