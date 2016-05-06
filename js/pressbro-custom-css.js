(function($) {

	$(document).ready(function() {

		// init Ace editor
		var editor = ace.edit('pressbro-custom-css-editor');

		editor.setTheme('ace/theme/github');
		editor.getSession().setMode('ace/mode/css');
		editor.$blockScrolling = Infinity;
		editor.getSession().setTabSize(2);
		editor.getSession().setUseSoftTabs(false);

		// font size
		if(localStorage.getItem('pb-custom-css-fontsize')) {

			editor.setFontSize(localStorage.getItem('pb-custom-css-fontsize') + 'px');

		}

		// change font size
		$('.pb-custom-css-font-size-wrap a').on('click', function() {

			var default_font_size = 11;
			var set_font_size = parseInt(localStorage.getItem('pb-custom-css-fontsize'));

			if(!set_font_size) {

				if($(this).attr('id') === 'pb-custom-css-bigger-font-size') {

					var new_font_size = default_font_size + 1;

				} else {

					var new_font_size = default_font_size - 1;

				}

			} else {

				if($(this).attr('id') === 'pb-custom-css-bigger-font-size') {

					var new_font_size = set_font_size + 1;

				} else {

					var new_font_size = set_font_size - 1;

				}

			}

			localStorage.setItem('pb-custom-css-fontsize', new_font_size);

			editor.setFontSize(new_font_size);

		});

		pbGetCSS();

		// update by pressing the button
		$('#pb-custom-css-update').on('click', function() {

			pbUpdateCSS();

		});

		// update by pressing ctrl+s or cmd+s
		$(document).keydown(function(e) {

			if((e.which == '115' || e.which == '83') && (e.ctrlKey || e.metaKey)) {

				e.preventDefault();

				pbUpdateCSS();

				return false;

			}

		});

		// the actual update
	  function pbUpdateCSS() {

			var pb_css = editor.getValue();

			$('#pb-custom-css-update').html('Updating ...');

			$.ajax({
				url: ajaxurl,
				method: 'POST',
				cache: false,
				data: {action: 'pb_custom_css_update', pb_custom_css_contents: pb_css}
			}).done(function(data) {

				console.log(data);
				
				if(data !== 'forbidden') {

					$('#pb-custom-css-update').html('Update');
					$('.pressbro-custom-css-update-status').html('Updated!');
					$('.pressbro-custom-css-update-status').fadeIn(200);

				} else {

					$('#pb-custom-css-update').html('Update');
					$('.pressbro-custom-css-update-status').html('Failed :(');
					$('.pressbro-custom-css-update-status').fadeIn(200);
					
					console.log('Error: PressBro Custom CSS can not update CSS');

				}

				// clear update status
				setTimeout(function() {

					$('.pressbro-custom-css-update-status').fadeOut(200);

				}, 1500);

			});

		}

		// get code
		function pbGetCSS() {

			$.ajax({
				url: ajaxurl,
				method: 'GET',
				cache: false,
				data: {action: 'pb_custom_css_get'}
			}).done(function(data) {

				editor.setValue(data, -1);

			});

		}

	});

})(jQuery);