(function($){
	function panel(node, options) {
		var panelObj = this;
		
		function GetCookieName() {
			return 'LCPanelState' + node.attr('id');
		}
		
		function IsVisible() {
			return panelObj.m_content.is(":visible");
		}
		
		function Show(isForced) {
			panelObj.m_visibilityTrigger.removeClass().addClass('visibility-trigger shown');
			
			if (isForced) {
				panelObj.m_content.show();
			} else {
				panelObj.m_content.slideDown('fast');
			}
			
			// Saving state in cookie
			if (panelObj.m_saveState) {
				$.cookie(GetCookieName(), 2);
			}
		}
		
		function Hide(isForced) {
			panelObj.m_visibilityTrigger.removeClass().addClass('visibility-trigger hidden');
			
			if (isForced) {
				panelObj.m_content.hide();
			} else {
				panelObj.m_content.slideUp('fast');
			}
			
			// Saving state in cookie
			if (panelObj.m_saveState) {
				$.cookie(GetCookieName(), 1);
			}
		}
		
		function Construct(node, options) {
			if (!$.isValid(node.attr('id'))) {
				throw "panel. passed node without id";
			}
			
			var controls = $('<div class="controls"><div class="visibility-trigger">&nbsp;</div></div>');
			node.wrap('<div class="content" />');
			node.parent().wrap('<div class="panel">');
			node.parent().before(controls);
			
			panelObj.m_content = node.parent();
			panelObj.m_saveState = $.isValid(options.saveState) ? options.saveState : false;
			panelObj.m_visibilityTrigger = controls.find('div.visibility-trigger');
			panelObj.m_isShown = $.isValid(options.isShown)	? (options.isShown ? 2 : 1) : 2;
			panelObj.m_visibilityTrigger.click(
				function() {
					if (IsVisible()) {
						Hide(false);
					} else {
						Show(false);
					}
				}
			);
			
			if (panelObj.m_saveState) {
				isShown = $.cookie(GetCookieName());
				if (!$.isValid(isShown)) {
					$.cookie(GetCookieName(), panelObj.m_isShown);
				} else {
					panelObj.m_isShown = isShown;
				}
			}
			
			if (panelObj.m_isShown - 1) {
				Show(true);
			} else {
				Hide(true);
			}
		}
		
		Construct(node, options);
		return panelObj;
	}
	
	/* 
		panel class.
		
		Usage $().panel(options)
		Options:
			saveState: should panel save its state in cookie [default false]
			isShown: is shown panel when created [default true]
    */
	$.fn.panel = function (options) {
		return $.cachedVisualPlugin(this, panel, options);
    }
})(jQuery);