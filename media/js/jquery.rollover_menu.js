(function($){
  $.fn.tagName = function() {
    if (this.get(0) !== undefined)
        return this.get(0).tagName.toLowerCase();
    return '';
  }

  $.fn.rolloverMenu = function(opts) {

    var options             = $.extend({}, $.fn.rolloverMenu.defaults, opts),
        menu                = $(this);

    menu.find('li:has(ul)').each(function() {
            
    });

    function showMenu(invoker, submenu) {
            var inv_height = invoker.outerHeight();
            var inv_coords = invoker.offset();
            inv_coords.top += inv_height;
            submenu.css(inv_coords);
            options.showEffect(submenu);
    };

    function hideMenu(invoker, submenu) {
            options.hideEffect(submenu);
    };

   return this;
  };

  $.fn.rolloverMenu.defaults = {
        showEffect : function(submenu) {
                submenu.slideDown();
        },
        hideEffect : function(submenu) {
                submenu.slideUp();
        },
        css : {
            'position' : 'absolute',
            'float' : 'none',
            'background' : '#000'
            
        }
   };
 })(jQuery);



