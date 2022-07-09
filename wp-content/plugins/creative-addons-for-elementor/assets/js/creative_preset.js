"use strict";
!(function( $, elementor ){
	// elementor here is predefined Elementor object, $ - jQuery as usual

	// Add functions  extend means that we will get Select controls, add our to old and return result - like PHP extends classes 
	
	let creativePreset = elementor.modules.controls.Select.extend({
		
		onReady: function () {
            
        },
		onRender: function () {
            this.constructor.__super__.onRender.apply(this, arguments);
			this.addResetButton();
        },
		// Before our select we will always add reset button 
		addResetButton: function () {
            let e = this;
			
			$('body').off("click", '.crel-reset-design');
            $('body').on("click", '.crel-reset-design', function () {
				// Trigger elementor reset for current openned panel 
				let opt = elementor.getPanelView().getCurrentPageView().getOption("editedElementView");
				// $e - some global elementor var that can trigger hooks 
				$e.run("document/elements/reset-style", { container: opt.getContainer() });
				
				// Reset select 
				$('[class*=crel_Generic__Presets] select').val('');
				// Reset select in elementor object 
				e.setSettingsModel("");
            });
			
		},
		// Change hook - main thing there 
		onBaseInputChange: function (e) {
			let $select = $(e.currentTarget);
			let val = $select.val();
			let data = {};
			
			$select.find('option').each(function(){
				if ( $(this).val() == val ) {
					data = $(this).data('value');
				}
			});
			
			if ( typeof data == 'undefined' ) {
				return;
			}
			
			// object with all controls that we have 
			let controls = this.getElementSettingsModel().controls;
			let self = this;
			let newOptions = {};
			let selfName = self.model.get("name"); // current select name 
			newOptions[$select.data('setting')] = val;
			
			console.log(controls)
			$.each(controls, function (name, el) {
				// if we look on not-current-select element and we should change it 
					
				if ( selfName !== name && ( typeof data[name] !== 'undefined' ) ) {
					if ( el.is_repeater ) {
						//console.log(name)
						
						
						let group = self.getElementSettingsModel().get(name).clone();
						
						group.each(function( groupEl, index ) {
							if ( typeof data[name][index] !== 'undefined' ) {
								$.each( groupEl.controls, function( grElIndex, El ){
									
									if ( self.isStyleTransferControl( El ) && typeof data[name][index][grElIndex] !== 'undefined' ) {
										group.at( index ).set(grElIndex, data[name][index][grElIndex]);
									}
								});
							}
						});
						newOptions[name] = group;
						
						
					} else if ( self.isStyleTransferControl(el) ) {
						newOptions[name] = data[name];
					}
				}
			});
			
			// update values 
			this.getElementSettingsModel().setExternalChange(newOptions);
			
			// trigger update screen 
            this.container.render();
			$e.components.get('document/save').footerSaver.activateSaveButtons(document, true);
		},
		// settings of the current openned panel 
		getElementSettingsModel: function () {
            return this.container.settings;
        },
		
		// check control if we need it 
		isStyleTransferControl: function(e){
			return ( typeof e !== 'undefined' ) && e.style_transfer ? e.style_transfer : "content" !== e.tab || e.selectors || e.prefix_class || e.force_preset;
		},
	});
	
	// Add functions to the select control  https://developers.elementor.com/creating-a-new-control/
	// Here we change elementor class to elementor+our functions, add some our events to Elementor Select input 
	elementor.addControlView( 'creative_preset', creativePreset );
	
})( window.jQuery, window.elementor);

jQuery(document).ready(function($) {
	// Regular wp scripts 
	/** Presets v2 */
	$(document).on( 'change', '[data-setting=crel_presets_v2_general]', function(){
		let container = $(this).closest('#elementor-controls');
		let that = $(this);
		
		container.find('.crel-preset-v2__select').each(function(){
			
			$(this).find('select').val('');
			
			if ( that.val() && $(this).hasClass( that.val() ) ) {
				$(this).css({ 'display' : 'flex' });
				$(this).find('select').val( $(this).find('option').eq(0).val() );
				$(this).find('select').trigger('change');
				
				if ( $(this).hasClass('style') ) {
					crel_presets_selectchange($(this).find('select'));
					
				}
			} else {
				$(this).css({ 'display' : 'none' });
			}

		});
	});
	
	$(document).on( 'change', '.crel-preset-v2__select.style select', function(){
		crel_presets_selectchange($(this))
	});
	
	function crel_presets_selectchange( $select ) {
		let option = false;
		let val = $select.val();
		
		$select.find('option').each(function(){
			if ( $(this).val() == val ) {
				option = $(this);
			}
		});
		
		if ( ! option ) {
			return true;
		}
		
		option.closest('#elementor-controls').find('.crel-preset-v2__select.color').each(function(){
			
			if ( $(this).css('display') !== 'flex' ) {
				return true;
			}
			
			// check only visible  and check first visible 
			let check = false;
			
			$(this).find('option').each(function(){
				if ( ! option.data('colors') || !$(this).val() || ~option.data('colors').indexOf( $(this).val() ) ) {
					// found 	
					$(this).show();
					
					if ( ! check ) {
						
						check = true;
						let select = $(this).closest('select');
						select.val($(this).val());
						
						// let give elementor run all hooks and draw front
						setTimeout(function(){
							select.trigger( 'change' );
						}, 50);
					}
				} else {
					
					$(this).hide();
				}
			});
			
		});
	}
	/** End presets v2 */
});