(function($){
	function imageBrowser(node, options) {
		if (!$.isValid(options.url)) {
			throw "imageBrowser. not all options set";
		}
		
		var uploadIcon = $('<div class="load-icon">&nbsp;</div>');
		var content = $('<div class="content" />');
		
		node.addClass('image-browser');
		node.append(content);
		node.append(uploadIcon);
		uploadIcon.hide();
		
		this.updateImages = function() {
			content.slideUp();
			uploadIcon.show();
			$.ajax({
				url: options.url,
				success: function(html) {
					content.html(html);
					content.slideDown();
					uploadIcon.hide();
				},
				error: function() {
					content.html('Ошибка просмотра загруженных изображений.')
					content.slideDown();
					uploadIcon.hide();
				}
			});
		}
		return this;
	}
	
	/* 
		Image Browser class.
		
		Usage: $().imageBrowser(options)
		Options:
			url: url to get list images
    */
	$.fn.imageBrowser = function(options) {
		return $.cachedVisualPlugin(this, imageBrowser, options);
    }
})(jQuery);
