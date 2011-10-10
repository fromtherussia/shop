(function($){
	function imageUploader(node, options) {
		if (!$.isValid(options.url) || !$.isValid(node.attr('id')) || !$.isValid(options.uploadCallback)) {
			throw "imageUploader. not all options set";
		}
		
		var url = options.url;
		var id = node.attr('id');
		
		var formId = 'LCImageUploaderForm' + id;
		var iframeId = 'LCImageUploaderIframe' + id;
		
		node.addClass('image-uploader');
			
		var form = $('<form method="post" enctype="multipart/form-data" action="' + url + '" target="' + iframeId + '" name="' + formId + '" id="' + formId + '"></form>');
		var fileInput = $('<input type="file" name="image-file" />');
		var iframe = $('<iframe src="" id="' + iframeId + '" name="' + iframeId + '" ></iframe>');
		
		var uploadIcon = $('<div class="load-icon">&nbsp;</div>');
		var uploadForm = $('<div />');
		
		node.append(uploadForm);
		node.append(uploadIcon);
		
		uploadIcon.hide();
		
		uploadForm.append('Загрузить картинку:&nbsp;');
		uploadForm.append(form);
		uploadForm.append(iframe);
		
		form.append(fileInput);
		
		fileInput.change(
			function() {
				form.submit();
				uploadForm.hide();
				uploadIcon.show();
			}
		);
		
		iframe.load(function() {
			uploadIcon.hide();
			uploadForm.show();
			options.uploadCallback();
		});
		
		return this;
	}
	
	/* 
		Image Uploader class.
		
		Usage: $().imageUploader(options)
		Options:
    */
	$.fn.imageUploader = function(options) {
		return $.cachedVisualPlugin(this, imageUploader, options);
    }
})(jQuery);
