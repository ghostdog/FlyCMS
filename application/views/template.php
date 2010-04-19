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

    function load_style() {
        $curr_controller = Request::instance()->controller;
        return html::style('media/css/'.$curr_controller.'.css');
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<title><?php misc::print_if($page_title, APP_NAME)?></title>
<?php echo html::meta('text/html; charset=utf-8', html::EQV_CONTENT);
      echo load_style();
      echo html::style('media/css/main.css');
      echo html::script('media/js/jquery-1.3.2.min.js');
      echo html::script('media/js/jquery.inputtip.js');
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
           <li><?php echo html::anchor(set_controller('templates'),'Szablony') ?></li>
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
	<div id="page-content">
            <em class="msg <?php if (isset($result)) if($result) echo 'success'; else echo 'error' ?>"><?php echo misc::print_if($msg); ?></em>
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
 
     Function.prototype.method = function(name, func) {
         this.prototype[name] = func;
         return this;
     };

     String.method('trim', function() {
       return this.replace(/^\s+|\s+$/g, '');
     });
   

    $.fn.clearForm = function() {
      return this.each(function() {
     var type = this.type, tag = this.tagName.toLowerCase();
     if (tag == 'form')
       return $(':input',this).clearForm();
     if (type == 'text' || type == 'password' || tag == 'textarea')
       this.value = '';
     else if (type == 'checkbox' || type == 'radio')
       this.checked = false;
     else if (tag == 'select')
       this.selectedIndex = -1;
      });
    };

     $.fn.tagName = function() {
        if (this.get(0) !== undefined)
            return this.get(0).tagName.toLowerCase();
        return '';
      };

      $.fn.findParentByTag = function(tagName) {
           var inv = $(this),
               isFound = false,
               parent = inv.parent();
           while (parent.tagName() != tagName ) {
                parent = parent.parent();
           }
           return parent;
      };
      
      $.fn.showIfHasContent = function(fn) {
          $(this).each(function() {
              var subject = $(this).hide();
              if (subject.text().length > 0) {
                  fn(subject);
              }
          });
          return this;
      
      };

         makeTips();
    

      $('.msg').showIfHasContent(function(subject) {
            subject.fadeIn(1000).click(function() { $(this).fadeOut(1000)});
      });

      $('.input-error').showIfHasContent(function(subject) {
            subject.show();
            var coords = subject.offset();
            subject.outerHeight();
            subject.outerWidth();
            var mask = $('<div/>').css({
                'position' : 'absolute',
                'z-index:' : '99',
                'top' : coords.top - 6,
                'left' : coords.left,
                'height' : subject.outerHeight(),
                'width' : subject.outerWidth(),
                'background' : '#fff'
            }).appendTo($('body'));
            mask.hide('slow');

      });

       // $('.help').hide();

       

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
      
          $('.reset').each(function() {
                var invoker =$(this);
                var targetForm = invoker.findParentByTag('form');
                invoker.click(function(evt) {
                   evt.preventDefault();
                   targetForm.clearForm();
                })
          })

       
    $('.help-invoker').each(function() {
        var invoker = $(this),
            helpId = invoker.attr('href'),
            helpSource = $(helpId).hide();
            invoker.toggle(
                function() {
                    invoker.removeClass('open').addClass('close');
                    helpSource.show('fast');
                },
                function() {
                    invoker.removeClass('close').addClass('open');
                    helpSource.hide('fast');
                    return false;
                }
            );

    })
     

    })
</script>
</body>
</html>