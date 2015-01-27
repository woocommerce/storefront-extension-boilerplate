/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	wp.customize( 'seb_color_picker', function( value ) {
		value.bind( function( to ) {
			$( 'h1, h2, h3, h4, h5, h6' ).css( 'background-color', to );
		} );
	} );
} )( jQuery );
