(function($){
	function dynamicList(node, options) {
		var currentList = this;
		
		currentList.m_itemsCount = 0;
		
		currentList.addItem = function(itemNode) {
			var itemNodeWrapper = $('<div class="dynamic-list-item"><table><tr><td></td><td></td></tr></table></div>');
			node.append(itemNodeWrapper);
			
			var deleteItemIcon = $('<a class="ui-state-default ui-corner-all icon left" href="#"><div class="ui-icon ui-icon-closethick">&nbsp;</div></a>');
			deleteItemIcon.click(function() {
				itemNodeWrapper.fadeOut('fast', function() {
					itemNodeWrapper.remove();
					currentList.m_itemsCount--;
				});
			});
			deleteItemIcon.hover(
				function() { $(this).addClass('ui-state-hover'); }, 
				function() { $(this).removeClass('ui-state-hover'); }
			);
			
			itemNodeWrapper.find('td:eq(0)').append(deleteItemIcon).css('width', '25px');
			itemNodeWrapper.find('td:eq(1)').append(itemNode);
			
			currentList.m_itemsCount++;
		}
		
		currentList.itemsCount = function() {
			return currentList.m_itemsCount;
		}
		
		return currentList;
	}

	$.fn.dynamicList = function(options) {
		return $.cachedVisualPlugin(this, dynamicList, options);
    }
})(jQuery);
