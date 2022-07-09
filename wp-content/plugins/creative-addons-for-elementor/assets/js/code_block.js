"use strict";
(function($){
	class CRELCodeBlock extends elementorModules.frontend.handlers.Base {
		getDefaultSettings() {
			return {
				selectors: {
					code: '.crel-code-block-container code',
					wrap: '.crel-code-block-container'
				},
			};
		}

		getDefaultElements() {
			const selectors = this.getSettings( 'selectors' );
			return {
				$code: this.$element.find( selectors.code ),
				$wrap: this.$element.find( selectors.wrap ),
			};
		}

		bindEvents() {
		   this.initView( this );
			this.elements.$wrap.ready( function(){
				if ( typeof CRELPrism == 'undefined' ) {
					return;
				}

				CRELPrism.highlightAll();
			} );
		}

		initView( event ) {

			if ( typeof CRELPrism == 'undefined' ) {
				return;
			}

			// run prism 
			CRELPrism.highlightAll( true, function( e ){
				$(this).closest('.crel-code-block-container').removeClass('crel-loading');
			});
		}
	}

	$( window ).on( 'elementor/frontend/init', () => {

	   const addHandler = ( $element ) => {
		   elementorFrontend.elementsHandler.addHandler( CRELCodeBlock, {
			   $element,
		   } );
	   };

	   elementorFrontend.hooks.addAction( 'frontend/element_ready/crel-code-block.default', addHandler );
	});

	// close fullscreen by press Esc
	$(document).on('keyup', function( e ){
		if ( $( '.crel-code-block-container--fullscreen' ).length && e.keyCode === 27 ) {
			$( '.crel-code-block-container--fullscreen' ).removeClass( 'crel-code-block-container--fullscreen' )
		}
	});
	
	// expand to fullscreen 
	$(document).on('click', '.crel-code-block__control-expand', function(){
		$(this).closest( '.crel-code-block-container' ).toggleClass( 'crel-code-block-container--fullscreen' );
	});
	
	// add help text 
	$(document).on('mouseenter', '.crel-code-block__control-expand, .crel-code-block__control-copy', function(){
		$(this).closest('.crel-code-block__control-panel').find('.crel-code-block__control-panel__help-text').text( $(this).data('help') );
	});
	
	$(document).on('mouseleave', '.crel-code-block__control-expand, .crel-code-block__control-copy', function() {
		$(this).closest('.crel-code-block__control-panel').find('.crel-code-block__control-panel__help-text').text('');
	});
	
	// copy function 
	$(document).on('click', '.crel-code-block__control-copy', function( event ){
		event.preventDefault();
		
		$(this).closest('.crel-code-block-container').find('.crel-block-original-code').select();
		document.execCommand("copy");
		
		let textWrap = $(this).closest('.crel-code-block__control-panel').find('.crel-code-block__control-panel__help-text');
		let text = $(this).data('copied');
		textWrap.text( text );
		
		setTimeout( function(){
			if ( textWrap.text() == text ) {
				textWrap.text( '' );
			}
		}, 4000 );
		
	});
	
	// replace brackets if exists 
	$('.crel-replace-brackets').each( function(){
		let text = $(this).text();
		
		text = text.replaceAll( '%crel_bracket_open%', '[' ).replaceAll( '%crel_bracket_close%', ']' );
		
		$(this).text( text );
		$(this).closest('.crel-code-block-container').find('.crel-block-original-code').val(text).html(text);
	} );
})(jQuery);