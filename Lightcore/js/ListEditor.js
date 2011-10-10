(function($){
	/*
		listEditorItem
		
		options:
			id
			html
			onRemove
	*/
	$.fn.listEditorItem = function(options) {
		var currentObj = this;
		var isInlineItems = $.isValid(options.isInlineItems) ? options.isInlineItems : false;
		
		var itemHtml =
			'<div class="' + (isInlineItems ? 'item left' : 'item') + '">' +
				options.html +
				'<input type="hidden" name="' + options.name + '[]" value="' + options.id + '" />' +
			'</div>';
		currentObj.html(itemHtml);
		
		var removeBtn = currentObj.children('div.remove-button');
		removeBtn.click(function() {
			var effectOptions;
			if (isInlineItems) {
				effectOptions = {
					opacity: 0
				};
			} else {
				effectOptions = {
					height: 0,
					opacity: 0.1
				};
			}
			item.animate(effectOptions, 'fast', function() {
				item.remove();
				options.onRemove(options.id);
			});
		});
		
		currentObj.hover(
			function() {
				removeBtn.fadeTo('fast', 1.0);
			},
			function() {
				removeBtn.fadeTo('fast', 0.0);
			}
		);
		
		return currentObj;
	}
	
	/*
		listEditor:
			name
	*/
	function listEditor(node, options) {
		var currentObj = $(this);
		currentObj.itemsCount = 0;
		
		function onItemRemove(id) {
			currentObj.itemsCount--;
		}
		
		var items = $('<div class="items" />');
		node.append(items);
		node.addClass('list-editor');
		
		if ($.isValid(options.withItemsInput) && options.withItemsInput) {
			var inputName = options.name + '_new_item_input';
			var inputText = $('<input type="text" name="' + inputName + '" />');
			var inputButton = $('<button type="button">добавить</button>');
			inputButton.click(function() {
				currentObj.addItem(-1, inputText.val());
			});
			node.append($('<div />').append(inputText).append(inputButton));
		}
		
		currentObj.addItem = function(itemId, itemHtml) {
			var item = $('<div />').listEditorItem({
				id: itemId,
				name: options.name,
				html: itemHtml,
				isInlineItems: options.isInlineItems,
				onRemove: onItemRemove
			});
			if ($.isValid(options.isInlineItems) ? options.isInlineItems : false) {
				if (items.has('br').length == 0) {
					items.append('<br class="clear" />');
				}
				items.children('br').before(item);
			} else {
				items.append(item);
			}
			currentObj.itemsCount++;
		}
		
		return currentObj;
	}
	
	$.fn.listEditor = function(options) {
		return $.visualPlugin(this, options, listEditor);
	}
})(jQuery);;