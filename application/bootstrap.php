<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Warsaw');

/**
 * Set the default locale.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'pl_PL.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/about.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array('base_url' => '/kohana/',
                   'index_file' => ''));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	  
	// 'image'      => MODPATH.'image',      // Image manipulation

	// 'pagination' => MODPATH.'pagination', // Paging of results
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
           'image'      => MODPATH.'image',
           'firephp'    => MODPATH.'firephp',
           'database'   => MODPATH.'database',   // Database acces
           'orm'        => MODPATH.'orm',        // Object Relationship Mapping
           'templates'  => MODPATH.'templates',
           'unittest'   => MODPATH.'unittest',
           'pagination' => MODPATH.'pagination',
           'mptt'       => MODPATH.'mptt',
           'themes'     => DOCROOT.'themes',
	));

//Kohana::$log->attach(new FirePHP_Log_File(APPPATH.'logs'));
//Kohana::$log->attach(new FirePHP_Log_Console());
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
#
//Route::set('auth', 'admin/(/<action>)')
//		->defaults(array(
//		'directory' => 'admin',
//                'controller' => 'auth',
//                'action' => 'login',
//));

Route::set('menus', 'admin/menus(/<action>(/<id>))')
		->defaults(array(
		'directory' => 'admin',
                'controller' => 'menus',
                'action' => 'add',
));



Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
		->defaults(array(
		'directory' => 'admin',
));

Route::set('page', 'page/<id>')
	->defaults(array(
		'controller' => 'site',
		'action'     => 'page',
	));


Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'site',
		'action'     => 'main',
	));


/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
	if( ! defined('SUPPRESS_REQUEST'))
	{
        	/**
         	* Execute the main request using PATH_INFO. If no URI source is specified,
	         * the URI will be automatically detected.
	         */
	        echo Request::instance($_SERVER['PATH_INFO'])
	                ->execute()
	                ->send_headers()
        	        ->response;
	}