$.fn.hasValue = function() {
    return this.val().trim().length;
}
function makeTips(options) {

    var defaults = {
        inputTipColor : '#b5b5b5',
        inputTextColor : '#000'
    }
    var  selectors = 'input[type="text"], textarea',
         opts = $.extend({}, defaults, options),
         tips = getTips();
         createInputsTips();
         addTipsClearerOnSubmit();

    function getTips() {
         var tips = {};
         $('.tip').each(function() {
            var tip = $(this),
                tipId = tip.attr('id').replace(/-tip/, ''), // fieldname-tip
                inputTip = {
                content : tip.text(),
                isActive : false
                };
            tips[tipId] = inputTip;
        }).hide();
        return tips;
    }

    function createInputsTips() {
         $(selectors).each(function() {
            var input = $(this);
            if (hasTip(input)) {
                showTipIfAllowed(input);
                addTipListeners(input);
            }
        });
    }

    function addTipListeners(input) {
        input.focus(function(){
            if (isTipActive(input))
                input.val('');
            input.css('color',opts.inputTextColor);
        }).blur(function() {
            showTipIfAllowed(input);
        })
    }

   function addTipsClearerOnSubmit() {
          $('form').submit(function() {
            $(this).find(selectors).each(function() {
                var input = $(this);
                if (hasTip(input)) {
                    if (isTipActive(input)) {
                        input.val('');
                    }
                }
            });
        });
        
    }

    function showTipIfAllowed(input) {
            if ( isValueNotEqualTipContent(input) && input.hasValue()) {
                        setTipInput(input, false);
            } else {
                setTipInput(input, true)
            }
    }

    function setTipInput(input, isTipActive) {
         var id = input.attr('id');
         //jQuery.data(input, 'isTipActive', isTipActive);
         tips[id].isActive = isTipActive;
         if (isTipActive) {
             input.css('color', opts.inputTipColor);
             input.val(tips[id].content);
        } else {
             input.css('color', opts.inputTextColor);
         }
    }

    function hasTip(input) {
        return tips[input.attr('id')] !== undefined;
    }

    function isTipActive(input) {
       var id = input.attr('id');
       if (id !== undefined) {
           if (tips[id]) {
                return tips[id].isActive;
           }
       }
        return false;
    }

    function isValueNotEqualTipContent(input) {
        return input.val().trim() !== tips[input.attr('id')].content.trim();
    }
}