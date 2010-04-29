

(function($){
  $.fn.counter = function(options) {
   
   var options             = $.extend({}, $.fn.counter.defaults, options);
   var counter             = 0;   
   var escapedInvalidChars = '';
   var invalidCharsRegex   = null;
   if (options.invalidChars) {
     escapedInvalidChars = options.invalidChars.split('').join('|');
     invalidCharsRegex = new RegExp('[' + escapedInvalidChars + ']', 'g');
   }
   
   
	function getResultTagByInput(input) {
			var label = input.parent().find('label');
			var em = $('<em></em>');
			em.css(options.MsgStyle);
			label.append(em);
			return em;
	}
    var field = $(this);
    var resultElement = getResultTagByInput(field);
	
	field.keyup(function(e) {
		if (options.invalidChars) {
				var cleanVal = field.val().replace(invalidCharsRegex, '');
				if (field.val() !== cleanVal) {
				  field.val(cleanVal);
				}
		}
		var text = field.val();
		counter = text.length;
		if (counter > options.maxLength) {
				field.val(text.slice(0, options.maxLength));
		}
	   
		var charLeft = options.maxLength - counter;
		 if (charLeft > 0) { $(resultElement).text(' (Pozostało znaków: '+charLeft+')'); $(resultElement).css(options.MsgStyle); } 
		 else { $(resultElement).text(' (Pozostało znaków: 0)'); $(resultElement).css({ 'color' : 'red'}); }
	   
	
	});
	
	field.focus(function() {
		
		var textLength = field.val().length;
		var charLeft = options.maxLength - textLength;
		if (charLeft > 0) { 
			$(resultElement).css(options.MsgStyle); 
			$(resultElement).text(' (Pozostało znaków: '+charLeft+')') 
		} else { $(resultElement).text(' (Pozostało znaków: 0)');
				$(resultElement).css('color', 'red');
		}
	});
	
	field.blur(function() {
		$(resultElement).text('');
	});
   return this;
  };
  	
  $.fn.counter.defaults = {
        maxLength: 50,       
        invalidChars: '',
		MsgStyle : {
			'font-style' : 'normal',
			'color': '#333',
			'font-weight': 'normal'
		}
   };
 })(jQuery);

