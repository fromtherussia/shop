(function($){
	function popupMenu(node, options) {
		var menu = this;
		
		function StopTimeout() {
			if (menu.m_timeout) {
				menu.m_timeout.stop();
			}
		}
		
		function ForceHide() {
			StopTimeout();
			menu.m_node.fadeOut('fast');
		}
		
		function Construct(node, options) {
			if (!$.isValid(options.clickHandler)) {
				throw 'popupMenu. clickHandler param not set';
			}
			
			menu.m_node = node;
			menu.m_timeoutBeforeHide = 100;
			menu.m_context = null;
			menu.m_timeout = null;
			
			menu.m_node.disableTextSelect();
			menu.m_node
				.addClass('popup-menu')
				.hover(
					function() {
						StopTimeout();
					},
					function() {
						menu.hide();
					}
				)
				.find('li').click(
					function(event) {
						ForceHide();
						options.clickHandler(menu.m_context, $(this));
						event.preventDefault();
						return false;
					}
				);
			
			ForceHide();
		}
		
		function ShowNode(position, edges) {
			if ($.isValid(position)) {
				menu.m_node
					.css('left', position.left)
					.css('top', position.top)
					.fadeIn('fast');
			} else {
				menu.m_node.fadeIn('fast');
			}
		}
		
		// Public interface
		
		menu.getDimensions = function() {
			return {'width': menu.m_node.width(), 'height': menu.m_node.height()};
		}
		
		menu.getContext = function() {
			return menu.m_context;
		}
		
		menu.show = function(position, edges, context) {
			StopTimeout();
			ShowNode(position, edges);
			menu.m_context = context;
		}
		
		menu.hide = function() {
			if (menu.m_timeout == null) {
				menu.m_timeout = new $.timer({
					'timeout': menu.m_timeoutBeforeHide,
					'callback': function() {
						ForceHide();
					},
					'repeat': false
				});
			}
			menu.m_timeout.start();
		}
		
		Construct(node, options);
		return menu;
	}
	
	/* 
		Popup menu class.
		
		$().popupMenu(options)
		options:
			clickHandler: function handles click gets two params: context (object), clicked item
    */
	$.fn.popupMenu = function(options) {
		return $.cachedVisualPlugin(this, popupMenu, options);
    }
})(jQuery);
