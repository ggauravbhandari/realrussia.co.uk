"use strict";
class CRELAdvancedHeading extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                link: '.crel-advanced-heading__title__link',
				hint: '.crel-advanced-heading__title__link__icon_hover-popup__inner',
				titleBadge: '.crel-advanced-heading__title__text'
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $link: this.$element.find( selectors.link ),
			$hint: this.$element.find( selectors.hint ),
			$titleBadge: this.$element.find( selectors.titleBadge ),
        };
    }

    bindEvents() {
        this.elements.$link.on( 'click', this.copyLink.bind( this ) );
    }
	
    copyLink( event ) {
        event.preventDefault();
		
		// set link in the input to the right 
		// use link instead of URL object for IE support
		let url = document.createElement('a');
		url.href = location.href;
		url.hash = this.elements.$titleBadge.prop( 'id' );
		
		// Create temporary input and copy text from it 
		let tempInput = document.createElement("input");
		tempInput.value = url.href;
		document.body.appendChild(tempInput);
		tempInput.select();
		document.execCommand("copy");
		document.body.removeChild(tempInput);
		
		// change hint text 
		let $hintEl = this.elements.$hint;
		let copied = this.elements.$link.data( 'copied' );
		let copy_text = this.elements.$link.data( 'copy_text' );
		
		$hintEl.text( copied );
		$hintEl.closest('.crel-advanced-heading__title__link').find('.crel-advanced-heading__title__link__icon').addClass('crel-active');
		$hintEl.closest('.crel-advanced-heading--anchorLink-hover').addClass('crel-active');
		
		setTimeout(function(){
			$hintEl.text( copy_text );
			$hintEl.closest('.crel-advanced-heading__title__link').find('.crel-advanced-heading__title__link__icon').removeClass('crel-active');
			$hintEl.closest('.crel-advanced-heading--anchorLink-hover').removeClass('crel-active');
		}, 2000);
   }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( CRELAdvancedHeading, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/crel-advanced-heading.default', addHandler );
} );