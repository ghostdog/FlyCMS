<?php defined('SYSPATH') or die('No direct script access');

class File extends Kohana_File {


    public static  function list_dir_filenames($dir_path) {
        $di = new DirectoryIterator($dir_path);
        foreach($di as $file) {
            if ($file->isFile())
                    $files[] = $file->getFilename();
        }
        return $files;
    }

    public static function remove_dir($dir_path) {
        $di = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir_path));
        foreach ($di as $file) {
                unlink($file->getPathname());
        }
    }

    public static function search_dir_files_by_names($dir_path, array $file_names) {
        $dir_files = self::list_dir_filenames($dir_path);
        $files_found = array();
        foreach($dir_files as $file) {
                if (in_array($file, $file_names))
                        $files_found[] = $file;
        }
        if (empty($files_found)) return false;
        else return $files_found;
    }

    public static function search_dir_files_by_ext($dir_path, array $extensions) {
        $dir_files = self::list_dir_filenames($dir_path);
        foreach ($dir_files as $file) {
                $ext = self::get_filename_ext($file);
                if (in_array($ext, $extensions))
                        $result[] = $file->getFilename();
        }
        if (empty($result)) return false;
        else return $result;
    }

    public static function remove_filename_ext($file_name) {
        $splitted = explode('.', $file_name);
        return $splitted[0];
    }

    public static function get_filename_ext($file_name) {
         $splitted = explode('.', $file_name);
         return $splitted[1];
    }


}
?>
