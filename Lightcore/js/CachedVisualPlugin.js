(function($){
	/*
		Function that apply visual plugin constructor to node.
		
		Usage: $.cachedVisualPlugin(node, pluginConstructor, options)
		Params:
			node: domNode
			pluginConstructor: function that constructs plugin around node
			options: options passes to constructor
	*/
	
	$.cachedVisualPlugin = function(node, pluginConstructor, options) {
		var pluginObj = node.data('LCVisualPluginData');
		if ($.isValid(pluginObj)) {
			return pluginObj;
		}
		pluginObj = new pluginConstructor(node, $.isValid(options) ? options : {});
		node.data('LCVisualPluginData', pluginObj);
		return pluginObj;
	}
})(jQuery);
