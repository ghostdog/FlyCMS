// JavaScript Document

(function($) {
		  
	$(document).ready(function() {
		$('#dialog').hide();
	});
	
	$.fn.dialog = function(actions, opts, effects) {
		var dialog = $('#dialog'),
                    invoker = $(this);

		var settings = $.extend({}, $.fn.dialog.defaultSettings, opts);
		var acts = $.extend({}, $.fn.dialog.actions, actions);
		var effects = $.extend({}, $.fn.dialog.effects, effects);
                var submit = $('#dialog-submit');
		var bgOverlay;


                dialog.attr('tabIndex', -1).css('outline', 0)
                .find('h4').text(settings.title);
                dialog.find('#dialog-header a').click(function(evt) {
                    evt.preventDefault();
                    doClose(evt);
                })
                dialog.keyup(function(evt) {
					var keyCode = evt.which || evt.keyCode;
					if (keyCode == 27)
						doClose(evt);
				})
		.css({
                    'height' : settings.height,
                    'width'  : settings.width
                });
                invoker.click(function(evt) {
                        evt.preventDefault();
                        doOpen(evt);
                        });
                submit.click(function(evt) {
                    evt.preventDefault();
                    acts.onSubmit(dialog, invoker, evt);
                    doClose(evt);
                })
		
		function doOpen(evt) {
			invoker = $(evt.target);
			setDialogPosition();
			if (settings.makeBgDark) {
				if (bgOverlay === undefined) {
					bgOverlay = createOverlay()
				}
				effects.showOverlay();
			}
                        effects.showDialog(dialog, invoker);
			acts.onOpen(dialog, invoker, evt);
		}

		function doClose(evt) {
			effects.hideDialog(dialog, invoker);
			if (settings.makeBgDark)
				effects.hideOverlay();
			acts.onClose(dialog, invoker, evt);
			dialog.blur();
		}
		
		function setDialogPosition() {
			var top;
			var left;
			if (settings.onCentre) {
				top = Math.ceil($(window).height() / 2 - settings.height / 2 + $(window).scrollTop());
				left = Math.ceil($(window).width() / 2 - settings.width / 2 + $(window).scrollLeft())
			} 
			dialog.css({'position': 'absolute', 'top': top, 'left': left});
		}
		
		function createOverlay() {
				var bgOverlay = $('<div/>');
				bgOverlay.hide()
				.css(settings.bgOverlayStyle)
				.height($(document).height())
				.width($(window).width())
				.attr('id', 'bg_overlay');
				$(document.body).append(bgOverlay);
				return bgOverlay;
		}
		
			
		
		
		return this;
		
	};
	
	$.fn.dialog.actions = {
		
		onOpen : function(dialog, invoker, evt) {
				
		},
		
		onClose : function(dialog, invoker, evt) {
				
		},
		
		onSubmit: function(dialog, invoker, evt) {
		}
	}
	
	$.fn.dialog.defaultSettings = {
                height: 400,
                width: 420,
		title: 'Twoje strony',
		onCentre: true,
                makeBgDark : true,
		bgOverlayStyle:
		{
		   'background-color' : '#000',
		   'filter':'alpha(opacity=80)',
  		   'opacity': '.85',
		   'z-index': 998,
		   'position': 'absolute',
		   'top': 0,
		   'left': 0
		}		 
	}
	
	$.fn.dialog.effects = {
		showDialog : function(dialog, invoker, evt) {
			dialog.fadeIn('slow');
		},
		hideDialog : function(dialog, invoker, evt) {	
			dialog.hide(100);	
		},
		
		showOverlay : function() {
			$('#bg_overlay').fadeIn('fast');
		},
		
		hideOverlay : function() {
			$('#bg_overlay').fadeOut();
		}
	}
	

	
  	
	
	
	
})(jQuery);

