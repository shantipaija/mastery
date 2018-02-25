jQuery( document ).ready(function() { // jscs:ignore validateLineBreaks

    // Here for each comment reply link of WordPress
    jQuery( '.comment-reply-link' ).addClass( 'btn btn-sm btn-default' );

    // Here for the submit button of the comment reply form
    jQuery( '#submit, button[type=submit], html input[type=button], input[type=reset], input[type=submit]' ).addClass( 'btn btn-default' );

    // Now we'll add some classes for the WordPress default widgets - let's go
    jQuery( '.widget_rss ul' ).addClass( 'media-list' );

    // Add Bootstrap style for drop-downs
    jQuery( '.postform' ).addClass( 'form-control' );

    // Add Bootstrap styling for tables
    jQuery( 'table#wp-calendar' ).addClass( 'table table-striped' );

    jQuery( '#submit, .tagcloud, button[type=submit], .comment-reply-link, .widget_rss ul, .postform, table#wp-calendar' ).show( 'fast' );
});

function masteryIsMobile() {
    return (
        ( navigator.userAgent.match( /Android/i ) ) ||
        ( navigator.userAgent.match( /webOS/i ) ) ||
        ( navigator.userAgent.match( /iPhone/i ) ) ||
        ( navigator.userAgent.match( /iPod/i ) ) ||
        ( navigator.userAgent.match( /iPad/i ) ) ||
        ( navigator.userAgent.match( /BlackBerry/ ) )
    );
}

function generateMobileMenu() {
    var menu = jQuery( '#masthead .site-navigation-inner .navbar-collapse > ul.nav' );
    if ( masteryIsMobile() && jQuery( window ).width() > 767 ) {
        menu.addClass( 'mastery-mobile-menu' );
    } else {
        menu.removeClass( 'mastery-mobile-menu' );
    }
}

// JQuery powered scroll to top
jQuery( document ).ready(function() {

    //Check to see if the window is top if not then display button
    jQuery( window ).scroll(function() {
        if ( jQuery( this ).scrollTop() > 100 ) {
            jQuery( '.scroll-to-top' ).fadeIn();
        }else {
            jQuery( '.scroll-to-top' ).fadeOut();
        }
    });

    //Click event to scroll to top
    jQuery( '.scroll-to-top' ).click(function() {
        jQuery( 'html, body' ).animate({ scrollTop:0 }, 800 );
        return false;
    });

    jQuery( '.mastery-dropdown' ).click( function( evt ) {
        jQuery( this ).parent().toggleClass( 'open' );
    });
    generateMobileMenu();
    jQuery( window ).resize(function() {
        generateMobileMenu();
    });

});

// JQuery Sticy Header
jQuery( document ).ready(function( $ ) {
    var $this, $adminbar, height;
    $this = $( '.navbar-fixed-top' );
    $adminbar = $( '#wpadminbar' );

    if ( 0 !== $this.length ) {
        height = ( 0 !== $adminbar.length ) ? Math.abs( $this.height() - $adminbar.height() ) : $this.height();
        $this.parent( 'header' ).css( 'margin-bottom', height );
    }
});



/* featured image zoom function */
jQuery( document ).ready(function() {

  jQuery('.zoom-thumbnail-tile')
    // tiles mouse actions
    .on('mouseover', function(){
      jQuery(this).children('.zoom-thumbnail-tile').css({'transform': 'scale('+ jQuery(this).attr('data-scale') +')'});
    })
    .on('mouseout', function(){
      jQuery(this).children('.zoom-thumbnail-tile').css({'transform': 'scale(1)'});
    })
    .on('mousemove', function(e){
      jQuery(this).children('.zoom-thumbnail-tile').css({'transform-origin': ((e.pageX - jQuery(this).offset().left) / jQuery(this).width()) * 100 + '% ' + ((e.pageY - jQuery(this).offset().top) / jQuery(this).height()) * 100 +'%'});
    })

    // tiles set up
    .each(function(){
      jQuery(this)
        // add a tile container
        .append('<div class="zoom-thumbnail-tile single-featured"></div>')
        // some text just to show zoom level on current item in this example
        // .append('<div class="txt"><div class="x">'+ jQuery(this).attr('data-scale') +'x</div>ZOOM ON<br>HOVER</div>')
        // set up a background image for each tile based on data-image attribute
        .children('.zoom-thumbnail-tile').css({'background-image': 'url('+ jQuery(this).attr('data-image') +')', 'background-repeat':'no-repeat'});
    });
});

//# sourceMappingURL=skip-link-focus-fix.min.js.map
( function() {// jscs:ignore validateLineBreaks
	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    isIE     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1,
        eventMethod;

	if ( ( isWebkit || isOpera || isIE ) && 'undefined' !== typeof( document.getElementById ) ) {
		eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
                    element.tabIndex = -1;
                }
				element.focus();
			}
		}, false );
	}
})();


/* navbar fix on scroll */

jQuery( document ).ready(function() {
    jQuery(window).scroll(function() {

      	var header = jQuery(document).scrollTop();
      	var headerHeight = jQuery(".custom-header-media").height();
        

      	if (header > headerHeight) {
            jQuery('.enable-navbar-fixed-top').addClass('navbar-fixed-top');

        		jQuery('.enable-navbar-fixed-top').fadeIn();


      	} else {
            jQuery('.enable-navbar-fixed-top').removeClass('navbar-fixed-top');
      	}

    });
});
