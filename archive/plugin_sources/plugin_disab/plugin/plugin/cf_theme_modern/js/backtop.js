        /* ---------------------------------------------- /*
         * Scroll top
         /* ---------------------------------------------- */
(function(){
jQuery(document).ready(function() {
		jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > 100) {
                jQuery('.scroll-up').fadeIn();
            } else {
                jQuery('.scroll-up').fadeOut();
            }
        });
		
		jQuery('.scroll-up').click(function () {
			jQuery("html, body").animate({
				scrollTop: 0
			}, 700);
			return false;
		});
    });
})(jQuery);