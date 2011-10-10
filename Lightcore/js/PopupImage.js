(function($) {
	/*
		popupImage class.
		
		Usage: $().popupImage(options)
		Options:
			small: small image url
			large: large image url
	*/
	$.fn.popupImage = function(options) {
		var currentNode = this;
		
		if (!$.isValid(options.small) || !$.isValid(options.large)) {
			throw "popupImage. not all options set";
		}
		
		var smallImageUrl = options.small;
		var largeImageUrl = options.large;
		var imageTitle = $.isValid(options.title) ? options.title : '';
		var image = $('<img src="' + smallImageUrl + '" alt="' + imageTitle + '" />');
		var popup = $('<div><div class="dialog-background">&nbsp;</div><div class="dialog"><img src="" /></div></div>');
		currentNode.append(image);
		currentNode.after(popup);
		
		if (imageTitle != '') {
			image.captify();
		}
		
		function centerImage(image, width, height) {
			image.css('left', (width - image.width()) / 2);
			image.css('top', (height - image.height()) / 2);
		}
		
		function hidePopup() {
			popup.find('div.dialog').hide();
			popup.find('div.dialog-background').fadeOut('fast');
		}
		
		function showLargeImage() {
			var modalDialog = popup.find('div.dialog');
			var background = popup.find('div.dialog-background');
			
			modalDialog.fadeIn('fast');
			background.fadeTo('fast', 0.8);
			
			var largeImage = popup.find('img');
			largeImage.attr('src', largeImageUrl);
			centerImage(largeImage, modalDialog.width(), modalDialog.height());
		}
		
		popup.find('div.dialog').click(function() {
			hidePopup();
		});
		
		image.click(function() {
			showLargeImage();
		});
	}
})(jQuery);
