

jQuery(document).ready(function() {
	jQuery('.cover').on('click', function () {

		var href = jQuery(this).siblings('a').prop('href');
		window.location.href = href;

	});

});

