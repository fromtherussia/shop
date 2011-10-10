(function($){
	function tableEditor(node, options) {
		var tableObject = this;
		
		node.find('tr').map(
			function (index, rowNode) {
				if (index == 0) {
					return;
				}
				rowClass = 'r' + (index + 1) % 2;
				$(rowNode).addClass(rowClass);
			}
		);
		
		return tableObject;
	}
	
	/* 
		tableEditor class.
		
		Usage: $().tableEditor(options)
		Options:
	*/
    $.fn.tableEditor = function(options) {
		return $.cachedVisualPlugin(this, tableEditor, options);
    }
})(jQuery);