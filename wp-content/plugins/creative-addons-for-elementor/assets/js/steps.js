"use strict";
class CRELSteps extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                link: '.crel-step-header__title__link',
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $link: this.$element.find( selectors.link ),
        };
    }

    bindEvents() {
        this.elements.$link.on( 'click', this.copyLink.bind( this ) );
    }
	
    copyLink( event ) {
        event.preventDefault();
		
		let $stepWrap = jQuery(event.target).closest('.crel-step');
		
		// set link in the input to the right 
		// use link instead of URL object for IE support
		let url = document.createElement('a');
		url.href = location.href;
		url.hash = $stepWrap.prop( 'id' );
		
		// Create temporary input and copy text from it 
		let tempInput = document.createElement("input");
		tempInput.value = url.href;
		document.body.appendChild(tempInput);
		tempInput.select();
		document.execCommand("copy");
		document.body.removeChild(tempInput);
		
		// change hint text 
		let $hintEl = $stepWrap.find('.crel-step-header__title__link__icon_hover-popup__inner');
		let copied = $stepWrap.find('.crel-step-header__title__link').data( 'copied' );
		let copy_text = $stepWrap.find('.crel-step-header__title__link').data( 'copy_text' );
		
       $hintEl.text( copied );
		
		setTimeout(function(){
			$hintEl.text( copy_text );
		}, 2000);
   }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( CRELSteps, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/crel-steps.default', addHandler );
} );