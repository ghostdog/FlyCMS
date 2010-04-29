$.fn.c_dialog = function(options) {
    var opts = $.extend({}, $.fn.c_dialog.defaults, options),
        invoker = $(this),
        dialog = createDialogIfNotSet();
        invoker.click(function(evt) {
            var pos = getFixedPositionIfRequired(evt, dialog);
            dialog.css(pos);
            dialog.prependTo($(this));
            addButtonsListeners();
            opts.showFx(dialog);
            evt.preventDefault();
            evt.stopPropagation();

        });

    function createDialogIfNotSet() {
        var dialog = $('#c-dialog');
        if (dialog.length === 0) {
            dialog = $([
                '<div id="c-dialog">',
                '<div id="c-icon"></div>',
                '<em>' + opts.msg + '</em>',
                '<div>',
                '<a name="yes" id="yes">' + opts.yes + '</a>',
                '<a name="no" id="no">' + opts.no + '</a>',
                '</div>',
                '</div>'
            ].join('')).appendTo('body');
            dialog.css({
                'position' : 'absolute'
            });
        }
        return dialog.hide();
    }

    function addButtonsListeners() {
        $('#no').click(function(evt) {
            evt.stopPropagation();
            opts.hideFx(dialog);
            evt.preventDefault();
            opts.after_no(invoker, evt);
        });
        $('#yes').click(function(evt) {
             evt.stopPropagation();
             opts.after_yes(invoker, evt);
        });
    }
    
    function getFixedPositionIfRequired(evt, dialog) {
        var x = evt.pageX,
            y = evt.pageY,
            pageW = $(document).width(),
            pageH = $(window).height(),
            dialogH = dialog.outerHeight(),
            dialogW = dialog.outerWidth();

            if (x + dialogW > pageW) {
                x -= dialogW;
            }
            if (y + dialogH > pageH) {
                y = y - dialogH;
            }
        var pos = {
            'top' : y + 'px',
            'left' : x + 'px'
        }
        return pos;
    }
    return this;
}

$.fn.c_dialog.defaults = {
    yes : 'Tak',
    no : 'Nie',
    msg : 'Czy napewno chcesz usunąć?',
    showFx : function(dialog) {
        dialog.show('fast');
    },
    hideFx : function(dialog) {
        dialog.hide('fast');
    },
    after_yes : function(invoker, evt) {
    },
    after_no : function(invoker, evt) {
    }
}


