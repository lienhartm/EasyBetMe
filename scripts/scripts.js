$(function() {
    var header = $("header");
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();

		if (scroll >= 10) {
			header.addClass('mini');
		} else {
			header.removeClass("mini");
		}
	});
});