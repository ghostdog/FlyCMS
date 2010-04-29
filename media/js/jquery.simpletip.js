

$.fn.simpleCluetip = function(invoker, options) {
    var opts = $.extend({}, $.fn.simpleCluetip.defaults, options);
    if ($('#tip-wrapper') === undefined)
        $(opts.tipHtml.join('')).appendTo($('body'));
    var tipSource = $(this).hide(),
        tipInvoker = $(invoker),
        tipPos = opts.tipPosition.toLowerCase(),
        cluetip = $('#tip-wrapper'),
        invCoords = getCoords(tipInvoker);

    $('#tip-content').css({'width' : opts.tipWidth});
    if (opts.useArrow) {
          var arrow = $('#tip-arrow');
          if (arrow.find('img') === undefined) {
              var arrowImgPath = opts.arrowsDir + 'arrow_pos_' + tipPos + '.png',
                  img =  $('<img>').attr('src', arrowImgPath).appendTo(arrow);
          }
          var imgDim = getDim(arrow.find('img'));
    }
    cluetip.hide();

    tipInvoker.focus(function() {
        if (opts.useArrow)
            setArrowPosition();
        setCluetipPosition();
        opts.setTipContentFromSource(tipSource);
        opts.show(cluetip);
    })

    tipInvoker.blur(function() {
        opts.hide(cluetip);
    })

    function setArrowPosition() {
        arrowStyle = {'position' : 'relative'},
        arrowTop = 0,
        arrowLeft = 0;
        if (tipPos === 'right') {
            arrowTop =+ opts.arrowOffset;
            arrowLeft = - (imgDim.width);
        } else {
            arrowLeft += opts.arrowOffset;
            if (tipPos === 'top') arrowTop = 0;
            else arrowTop = - (imgDim.height)
        }
        arrow.css(addPositionStyle(arrowStyle, arrowTop, arrowLeft));
    }

    function setCluetipPosition() {
        var tipStyle = {'position' : 'absolute', 'z-index' : '99'},
            top = 0,
            left = 0;
        if (tipPos === 'right') {
            top = invCoords.top;
            left = invCoords.right + opts.tipDistance + imgDim.width;

        } else {
            left = invCoords.left;
            if (tipPos === 'top') top = invCoords.top - opts.tipDistance - imgDim.height - invCoords.height;
             else top = invCoords.top + invCoords.height + opts.tipDistance + imgDim.height;
       }
       cluetip.css(addPositionStyle(tipStyle, top, left));
    }
     

    function addPositionStyle(style, top, left) {
        return $.extend(style, {
            top : top + 'px',
            left : left + 'px'
        });
    }

    function getCoords(element) {
        var pos = element.offset();
        var coords = {
            top : pos.top,
            left : pos.left,
            height : element.outerHeight(),
            width : element.outerWidth()
        }
        coords.bottom = coords.top + coords.height;
        coords.right = coords.left + coords.width;
        return coords;
    }

    function getDim(element) {
        return {
            height : element.outerHeight(),
            width : element.outerWidth()
        }
    }

    return this;
}

$.fn.simpleCluetip.defaults = {
    useArrow : true,
    tipPosition : 'right',
    tipDistance : 0,
    arrowOffset : 5,
    arrowsDir : '/kohana/media/css/img/content/',
    tipHtml : [
    '<div id="tip-wrapper">',
    '<div id="tip-arrow"></div>',
    '<div id="tip-content"></div>',
    '</div>'
    ],
    tipWidth : '300px',
    show : function(tip) {
        tip.show('fast');
    },
    hide : function(tip) {
        tip.hide('fast');
    },
    setTipContentFromSource: function(tipSource) {
        $('#tip-content').text(tipSource.text());
    }
}

