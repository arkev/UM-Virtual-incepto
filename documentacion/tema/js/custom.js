// JavaScript Document

// jQuery Initialization

jQuery(document).ready(function($){
	
	/* ---------------------------------------------------------------------- */
    /*	PrettyPhoto
    /* ---------------------------------------------------------------------- */
	
	if($().prettyPhoto){
        $("a[rel^='prettyPhoto']").prettyPhoto({
            overlay_gallery: false,
            social_tools: false
        });
	}
	
	/* ---------------------------------------------------------------------- */
    /*	Scroll to Top
    /* ---------------------------------------------------------------------- */
	
	/*
	var defaults = {
		containerID: 'toTop', // fading element id
		containerHoverID: 'toTopHover', // fading element hover id
		scrollSpeed: 1200,
		easingType: 'linear' 
	};
	*/
	
	if($().UItoTop){
		$().UItoTop({ easingType: 'easeOutQuart' });
	}
	
	/* ---------------------------------------------------------------------- */
    /*	Tiny Nav
    /* ---------------------------------------------------------------------- */
	
	if($().tinyNav){
		$('.nav').tinyNav({
			header: 'Navigation Menu' // Writing any title with this option triggers the header
		});
	}
	
});