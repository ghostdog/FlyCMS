<?php
    define('APP_NAME', 'FlyCMS');
    define('req', '<em class="required">*</em>');
    define('IMGS_PATH', 'media/img/tpl_examples/');

    function get_tpl_img($tpl_name) {
        $img_file = file::search_img_by_name($tpl_name, IMGS_PATH);
        return html::image(IMGS_PATH.$img_file, array('alt' => 'Miniaturka obrazka szablonu'));
    }

    function set_controller_action($controller_name, $action_name) {
        $uri_segment = (is_array($action_name)) ? $action_name : array('action' => $action_name);
        return Route::get($controller_name)->uri($uri_segment);
    }
    
    function set_controller_action_id($controller_name, $action_name, $id) {
        return Route::get($controller_name)->uri(array('action' => $action_name, 'id' => $id));
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<title><?php misc::print_if($page_title, APP_NAME)?></title>
<?php echo html::meta('text/html; charset=utf-8', html::EQV_CONTENT) ?>
</head>
<body>
<div id="header">
    <ul id="top-menu">
	    <li><?php echo html::anchor('','Strona Główna')?></li>
            <li><?php echo html::anchor(set_controller_action('admin', array('controller' => 'logout')), 'Wyloguj') ?></li>
    </ul>
    <h1>FlyCMS</h1>
    <ul id="main-menu">
       <li><?php echo html::anchor(set_controller_action('admin', array('controller' => 'settings')),'Ustawienia') ?></li>
       <li><?php echo html::anchor(set_controller_action('admin', array('controller' => 'templates')),'Szablony') ?></li>
    </ul>
    <?php echo form::open() ?>
    <ul id="search">
        <li><?php echo form::input('search_fld') ?></li>
        <li><?php echo form::image('search_submit', 'Wyszukaj', array('src' => url::base().'media/img/search_btn.png')) ?></li>
   </ul>
    <?php echo form::close() ?>
</div>
<div id="content_wrap">
<h1><?php misc::print_if($page_title) ?></h1>
	<div id="content">
	<?php echo $content; ?>
	</div>
</div>
<div id="footer">
<ul>
    <li><?php echo html::anchor('','Strona Główna')?></li>
    <li><?php echo html::anchor(set_controller_action('admin', array('controller' => 'logout')), 'Wyloguj') ?></li>
</ul>
</div>
</body>
</html>