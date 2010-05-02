<?php defined('SYSPATH') or die('No direct script access');

class File extends Kohana_File {


public static function recursive_remove_directory($directory, $empty=FALSE)
{
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}
	if(!file_exists($directory) || !is_dir($directory))
	{
		return FALSE;
	}elseif(is_readable($directory))
	{
		$handle = opendir($directory);
		while (FALSE !== ($item = readdir($handle)))
		{
			if($item != '.' && $item != '..')
			{
				$path = $directory.'/'.$item;
				if(is_dir($path))
				{
					self::recursive_remove_directory($path);
				}else{
					unlink($path);
				}
			}
		}
		closedir($handle);
		if($empty == FALSE)
		{
			if(!rmdir($directory))
			{
				return FALSE;
			}
		}
	}
	return TRUE;
}


    public static  function list_dir_filenames($dir_path) {
        $di = new DirectoryIterator(DOCROOT.$dir_path);
        foreach($di as $file) {
            if ($file->isFile())
                    $files[] = $file->getFilename();
        }
        return $files;
    }

    public static function remove_dir($dir_path) {
        $di = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(DOCROOT.$dir_path));
        foreach ($di as $file) {
                unlink($file->getPathname());
        }
    }

    public static function search_by_names($dir_path, array $file_names) {
        $dir_files = self::list_dir_filenames($dir_path);
        $files_found = array();
        foreach($dir_files as $file) {
                if (in_array($file, $file_names))
                        $files_found[] = $file;
        }
        if (empty($files_found)) return false;
        else return $files_found;
    }

    public static function search_img_by_name($name, $dir_path) {
        $extensions = array('png', 'jpg', 'gif');
        $regex = '/'.$name.'\.['.implode('|', $extensions).']/i';
        $dir_files = self::list_dir_filenames($dir_path);
        foreach($dir_files as $file) {
            if (preg_match($regex, $file))
                    return $file;
        }
        return false;
    }

    public static function search_by_ext($dir_path, array $extensions) {
        $dir_files = self::list_dir_filenames($dir_path);
        foreach ($dir_files as $file) {
                $ext = self::get_ext($file);
                if (in_array($ext, $extensions))
                        $result[] = $file;
        }
        if (empty($result)) return false;
        else return $result;
    }

    public static function remove_ext($file_name) {
        $splitted = explode('.', $file_name);
        return $splitted[0];
    }

    public static function get_ext($file_name) {
         $splitted = explode('.', $file_name);
         return $splitted[1];
    }


}
?>
