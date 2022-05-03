    $(document).on('ready', function() {
		var ebut_button = '';
		if (typeof Ossn.OpenEmojiBox === 'function') {
			// display emoji button only if OssnSmilies is enabled
			ebut_button = Ossn.EmojiButton;
		}
        $('#forum-editor').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', []],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', []],
                ['help', []],
				['emojis', ['ebut']]
            ],
			buttons: {
				ebut : ebut_button
			},
            callbacks: {
                onPaste: function(e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    setTimeout(function() {
                        document.execCommand('insertText', false, bufferText);
                    }, 10);
                }
            },
        });
    });
	
	// up to Ossn 5.2 the summernote emoji button was part of OssnSmilies, it'll be removed with 5.3
	Ossn.EmojiButton = function(context) {
		var ui = $.summernote.ui;
		var button = ui.button({
			contents: '<i class="fa fa-smile-o"/>',
			tooltip: 'Emoji',
			click: function() {
				// we need to save the cursor position here first
				context.invoke('editor.saveRange');
				Ossn.OpenEmojiBox('#forum-editor');
			}
		});
		return button.render(); // return button as jquery object
	}
