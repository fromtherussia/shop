(function($){
    function popupMessage(node, options) {
        var popupMessageObj = this;
		
		function ClearMessage() {
            popupMessageObj.m_node.removeClass().text('');
        }
		
        function ShowMessage(text, messageClass) {
			if (popupMessageObj.m_hideByTimer) {
				popupMessageObj.m_timer = new $.timer({
					'timeout': popupMessageObj.m_timeVisible,
					'callback': function () {
						popupMessageObj.hide();
					},
					'repeat': false
				});
			}
            ClearMessage();
            popupMessageObj.m_node
				.addClass('lc-popup-message ' + messageClass)
				.html('<div>' + text + '</div>')
				.fadeIn('normal');
        }
		
        function HideMessage() {
			popupMessageObj.m_node.fadeOut('normal');
        }
		
		function Construct(node, options) {
            popupMessageObj.m_timeVisible = $.isValid(options.timeVisible) ? options.timeVisible : 1000;
			popupMessageObj.m_hideByClick = $.isValid(options.hideByClick) ? options.hideByClick : false;
			popupMessageObj.m_hideByTimer = $.isValid(options.hideByTimer) ? options.hideByTimer : false;
			popupMessageObj.m_node = node;
			
			if (popupMessageObj.m_hideByClick) {
				popupMessageObj.m_node.click(
					function() {
						popupMessageObj.hide();
					}
				);
			}
        }
		
		// Public interface
        
        popupMessageObj.show = function(text, messageClass) {
			if (!$.isValid(messageClass)) {
				throw 'popupMessage. messageClass param not set';
			}
			
			ShowMessage(text, messageClass);
			return popupMessageObj;
        }
		
        popupMessageObj.hide = function() {
			HideMessage();
			return popupMessageObj;
        }
		
        Construct(node, options);
        return popupMessageObj;
    }
	
	/*
		Popup message class.
		
		Usage: $().popupMessage(options)
		Options:
			timeVisible: visibility time in msec [default 1000]
			hideByClick: should message hides by click [default false]
			hideByTimer: should message hides by timer [default false]
	*/
	
    $.fn.popupMessage = function(options) {
		return $.cachedVisualPlugin(this, popupMessage, options);
    }
	
	$.popupMessageType = {
		'success': 'success',
		'error': 'error',
		'info': 'info'
	};
})(jQuery);
