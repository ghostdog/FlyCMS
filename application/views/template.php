<?php
    define('APP_NAME', 'FlyCMS');
    define('req', '<em class="required">*</em>');
    define('IMGS_PATH', 'media/img/tpl_examples/');

    function get_tpl_img($tpl_name) {
        $img_file = file::search_img_by_name($tpl_name, IMGS_PATH);
        return html::image(IMGS_PATH.$img_file, array('alt' => 'Miniaturka obrazka szablonu'));
    }

    function set_controller($controller_name, $action_name = null, $id = null) {
        $uri_segments = array('controller' => $controller_name);
        if (! is_null($action_name)) $uri_segments['action'] = $action_name;
        if (! is_null($id)) $uri_segments['id'] = $id;
        return Route::get('admin')->uri($uri_segments);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<title><?php misc::print_if($page_title, APP_NAME)?></title>
<?php echo html::meta('text/html; charset=utf-8', html::EQV_CONTENT);
      echo html::style('media/css/main.css');
      echo html::script('media/js/jquery-1.3.2.min.js');
      echo html::script('media/js/jquery.rollover_menu.js');
?>
</head>
<body>
<div id="main-wrap">
<div id="header">
    <ul id="top-menu">
	    <li><?php echo html::anchor('','Strona Główna')?></li>
            <li class="last-item"><?php echo html::anchor(set_controller('logout'), 'Wyloguj') ?></li>
    </ul>
    <div id="site-name">
        <h1>FlyCMS<span> Twórz oczywiste...</span></h1>
    </div>
    <div id="menu-bar">
        <ul id="menu">
           <li><?php echo html::anchor(set_controller('templates'),'Szablony') ?>
               <ul class="submenu">
                   <li class="first-submenu"><?php echo html::anchor(set_controller('templates', 'add'), 'Nowy szablon') ?></li>
                   <li><?php echo html::anchor(set_controller('templates'), 'Dostępne szablony') ?></li>
                </ul>
           </li>
           <li><?php echo html::anchor(set_controller('settings'),'Ustawienia', array('class' => 'active')) ?></li>
        </ul>
        <?php echo form::open() ?>
        <ul id="search">
            <li><?php echo form::label('search_fld', 'Wyszukaj stronę: ') ?></li>
            <li><?php echo form::input('search_fld', null,  array('id' => 'search_fld')) ?></li>
            <li><?php echo form::image('search_submit', 'Wyszukaj', array('src' => url::base().'media/img/search_btn.png')) ?></li>
       </ul>
        <?php echo form::close() ?>
    </div>
</div>
<div id="content-wrap">
<h1><?php misc::print_if($page_title) ?></h1>
	<div id="content">
            <em class="msg  success"><?php echo misc::print_if($msg); ?></em>
            <?php echo $content; ?>
	</div>
</div>
<div id="footer">
<ul>
    <li><?php echo html::anchor('','Strona Główna')?></li>
    <li class="last-item"><?php echo html::anchor(set_controller('logout'), 'Wyloguj') ?></li>
</ul>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

      $.fn.tagName = function() {
        if (this.get(0) !== undefined)
            return this.get(0).tagName.toLowerCase();
        return '';
      }

      var menuTop = $('#menu-bar').offset().top + $('#menu-bar').outerHeight();
      $('#menu').find('li:has(ul)').each(function() {
                var li = $(this),
                    submenu = li.find('ul').hide().addClass('submenu'),
                    menuLeft = li.offset().left;
                    
                submenu.css({ 'top' : menuTop, 'left' : menuLeft});
                li.hover(function() {
                  submenu.slideDown(100);
                }, function(evt) {
                    if($(evt.currentTarget).is('li'))
                            submenu.slideUp(300);
                });
                submenu.mouseover(function(evt) {
                    $(this).show();
                    evt.stopPropagation();
                })
         })
       var msg = $('.msg').hide();
       if (msg.text().length > 0)
            msg.fadeIn(1200);
        msg.click(function() { msg.fadeOut(1000)})
    })
</script>
</body>
</html>