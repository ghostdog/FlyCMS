<?php
    $request = Request::instance();

    define('APP_NAME', $site_name);
    define('req', '<em class="required">*</em>');
    define('CONTROLLER', $request->controller);
    define('ACTION', $request->action);

    function create_link($name, $controller_name, $action_name = null, $id = null, $attr = null) {
        $uri = set_controller($controller_name, $action_name, $id);
        if (CONTROLLER == $controller_name) {
            if (ACTION !== 'edit') {
                    (! isset($attr['class'])) ? $attr['class'] = 'active' : $attr['class'] .= ' active';
            }
        }
        echo html::anchor($uri, $name, $attr);
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
      echo html::style('media/css/main.css');
      echo load_style();
      echo html::script('media/js/jquery.min.js');
      echo html::script('media/js/jquery.inputtip.js');
      echo html::script('media/js/jquery.counter.js');
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
        <h1><?php echo APP_NAME ?><!--<span> Twórz oczywiste...</span>--></h1>
    </div>
    <div id="menu-bar">
        <ul id="menu">
           <li><?php create_link('Strony', 'pages') ?></li>
           <li><?php create_link('Nawigacja', 'menus') ?></li>
           <li><?php create_link('Szablony', 'themes') ?></li>
           <li><?php create_link('Ustawienia', 'settings') ?></li>
        </ul>
        <?php echo form::open('admin/pages/search', array('method' => 'GET', 'id' => 'search-frm')) ?>
        <ul id="search">
            <li><?php echo form::label('search-fld', 'Wyszukaj stronę: ') ?></li>
            <li>
                <?php
               //  echo form::cluetip('search-fld', 'Wpisz tytuł strony');
                 echo form::input('search', null,  array('id' => 'search-fld', 'style' => 'width: 15em'))
                ?>
            </li>
            <li><?php echo form::image('search-submit', 'Wyszukaj',
                                        array('src' => url::base().'media/img/search_btn.png' )) ?></li>
       </ul>
        <?php echo form::close() ?>
    </div>
</div>
<div id="content-wrap">
<h1><?php misc::print_if($page_title) ?></h1>
	<div id="page-content">
            <em class="msg <?php if (isset($is_success)) if($is_success) echo 'success'; else echo 'error' ?>"><?php echo misc::print_if($msg); ?></em>
            <?php echo $content; ?>
	</div>
</div>
<div id="footer">
<ul>
    <li><?php echo html::anchor('','Strona Główna')?></li>
    <li class="last-item"><?php echo html::anchor(set_controller('logout'), 'Wyloguj') ?></li>
</ul>
</div>
	<?php if (Kohana::$environment !== Kohana::PRODUCTION) { ?>
		<div id="kohana-profiler">
			<?php echo View::factory('profiler/stats') ?>
		</div><!-- #kohana-profiler -->
	<?php } ?>
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

     $.fn.hasElement = function(selector) {
         return $(this).find(selector).length;
     };

     $.fn.tagName = function() {
        //console.log(this.get(0), 'this.get(0)');
        if (this.get(0) !== undefined)
            return this.get(0).tagName.toLowerCase();
        return '';
      };

//      $.fn.findParentByTag = function(tagName) {
//           var inv = $(this),
//               isFound = false,
//               parent = inv.parent();
//
//           while (parent.tagName() !== tagName ) {
//                parent = parent.parent();
//           }
//           return parent;
//      };
      
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
      $('#search-fld').keyup(function(evt) {
          
      })

      $('#search-frm').submit(function() {
          var textField = $('#search-fld');
          if (textField.val().length == 0) {
              textField.val('Musisz podać szukany tytuł');
              textField.css('color', '#999');
              return false;
          }
      });
//
//      $('.input-error').showIfHasContent(function(subject) {
//            subject.show();
//            var coords = subject.offset();
//            subject.outerHeight();
//            subject.outerWidth();
//            var mask = $('<div/>').css({
//                'position' : 'absolute',
//                'z-index:' : '99',
//                'top' : coords.top - 4,
//                'left' : coords.left,
//                'height' : subject.outerHeight(),
//                'width' : subject.outerWidth(),
//                'background' : '#fff'
//            }).appendTo($('body'));
//            mask.hide('slow');
//
//      });

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
                var targetForm = invoker.parents('form');
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