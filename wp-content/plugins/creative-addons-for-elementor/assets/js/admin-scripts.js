jQuery(document).ready(function($) {

	// Settings Page - Tab Toggle
	if( $( '.crel-dashboard__tabs' ).length > 0 ) {

		$( '.crel-dashboard-tabs__nav__item' ).on( 'click', function(e){

			e.preventDefault();

			//Get ID of Nav item
			let navID = $( this ).attr( 'id' );


			// Remove all active classes
			$( '.crel-dashboard-tabs__nav__item' ).removeClass( 'crel-dashboard-tabs__nav__item--active' );
			$( '.crel-dashboard-tabs__content__panel' ).removeClass( 'crel-dashboard-tabs__content__panel--active' );

			// Add Class to clicked on tab
			$( this ).addClass( 'crel-dashboard-tabs__nav__item--active' );

			// Show Tab Content for active Tab
			$( '#'+navID+'-content' ).addClass( 'crel-dashboard-tabs__content__panel--active' );

		})

	}


	// Settings page - Save widgets 
	
	function saveWidgets() {
		let data = {
			action: 'crel-save-widgets',
			crel_settings_nonce: $('#crel_settings_nonce').val(),
			inactive_widgets: []
		};
		
		$('.crel-dashboard-tabs__content__panel__body__widgets .crel-dashboard-widget-container input[type=checkbox]:not(:checked)').each(function(){
			data.inactive_widgets.push( $(this).prop('name') );
		});
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: data,
			beforeSend: function (xhr) {
				crelAddLoader( $('.crel-dashboard__tabs__content') );
				$('#crel-nav-widgets-content .crel-dashboard__save-settings').text( crel_vars.saving_config );
				$('#crel-nav-widgets-content .crel-dashboard__save-settings').prop( 'disabled', 'disabled' );
				$('#crel-nav-widgets-content .crel-dashboard__saving-error').text( '' );
			}
		}).done(function( response ){
			
			if ( response.status == 'error' ) {
				$('#crel-nav-widgets-content .crel-dashboard__saving-error').text( response.message );
			} else {
				$('#crel-nav-widgets-content .crel-dashboard__save-settings').text( crel_vars.saved_config );
				
				setTimeout(function(){
					$('#crel-nav-widgets-content .crel-dashboard__save-settings').text( crel_vars.save_config );
				}, 1000);
				
			}
		
			$('#crel-nav-widgets-content .crel-dashboard__save-settings').prop( 'disabled', false );
			
		}).always(function(){
			crelRemoveLoader( $('.crel-dashboard__tabs__content') );
		});
	}
	
	$('#crel-nav-widgets-content .crel-dashboard__save-settings').on( 'click', saveWidgets );
	
	
	// Settings page - Save widgets 
	
	function saveGlobals() {
		let data = {
			action: 'crel-switch-to-globals',
			crel_settings_nonce: $('#crel_settings_nonce').val(),
			switch_to_globals: $('#switch_to_globals:checked').length
		}
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: data,
			beforeSend: function (xhr) {
				crelAddLoader( $('.crel-dashboard__tabs__content') );
				$('#crel-nav-settings-content .crel-dashboard__save-settings').text( crel_vars.saving_config );
				$('#crel-nav-settings-content .crel-dashboard__save-settings').prop( 'disabled', 'disabled' );
				$('#crel-nav-settings-content .crel-dashboard__saving-error').text( '' );
			}
		}).done(function( response ){
			
			if ( response.status == 'error' ) {
				$('#crel-nav-settings-content .crel-dashboard__saving-error').text( response.message );
			} else {
				$('#crel-nav-settings-content .crel-dashboard__save-settings').text( crel_vars.saved_config );
				
				setTimeout(function(){
					$('#crel-nav-settings-content .crel-dashboard__save-settings').text( crel_vars.save_config );
				}, 1000);
				
			}
		
			$('#crel-nav-settings-content .crel-dashboard__save-settings').prop( 'disabled', false );
			
		}).always(function(){
			crelRemoveLoader( $('.crel-dashboard__tabs__content') );
		});
	}
	
	$('#crel-nav-settings-content .crel-dashboard__save-settings').on( 'click', saveGlobals );
	
	// $el - jQuery element, wrapper where we will paste loader
	function crelAddLoader( $el ) {
		$el.css({'position' : 'relative'});
		$el.append(`
			<div class="crel-packman">
				<div class="crel-packman--background"></div>
				<div class="crel-packman--image"></div>
			</div>
		`);
	}
	
	function crelRemoveLoader() {
		$('.crel-packman').remove();
	}

	/*****************************************************************************
	/  Debug PAGE
	/*****************************************************************************/
	$( '#crel-nav-debug-content #crel_toggle_debug' ).on( 'click', function() {

		var postData = {
			action: 'crel_toggle_debug',
			_wpnonce_crel_toggle_debug: $('#_wpnonce_crel_toggle_debug').val()
		};

		var msg;

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: postData,
			beforeSend: function (xhr)
			{
				crelAddLoader( $('.crel-dashboard__tabs__content') );
			}
		}).done(function (response)
		{
			window.location.href = window.location.href + '&tab=debug';
		}).always(function(){
			//crelRemoveLoader( $('.crel-dashboard__tabs__content') );

		});
	});
	
	/** Presets Library */
	
	$('.crel-dashboard-presets__header .crel-dashboard-widget-container').on( 'click', function(){
		$('.crel-dashboard-presets__header .crel-dashboard-widget-container').removeClass('crel-dashboard-widget-container--active');
		$(this).addClass('crel-dashboard-widget-container--active');
		$('.crel-dashboard-presets__widget-preview').removeClass('crel-dashboard-presets__widget-preview--active');
		$('.' + $(this).data('name')).addClass('crel-dashboard-presets__widget-preview--active');
		
		// notification box 
		$('.crel-dashboard-presets__preset-previews').removeClass('crel-dashboard-presets__widget-preview--active');
	});
	
	function savePresets() {
		let data = {
			action: 'crel-save-presets',
			crel_settings_nonce: $('#crel_settings_nonce').val(),
			inactive_presets: {}
		}
		
		$('.crel-dashboard-presets__widgets-preview__wrap input[type=checkbox]:not(:checked)').each(function(){
			
			if ( typeof data.inactive_presets[$(this).data('widget')] == 'undefined' ) {
				data.inactive_presets[$(this).data('widget')] = [];
			}
			
			data.inactive_presets[$(this).data('widget')].push( $(this).data('preset') );
			
		});

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: data,
			beforeSend: function (xhr) {
				crelAddLoader( $('.crel-dashboard__tabs__content') );
				$('#crel-nav-presets-content .crel-dashboard__save-settings').text( crel_vars.saving_config );
				$('#crel-nav-presets-content .crel-dashboard__save-settings').prop( 'disabled', 'disabled' );
				$('#crel-nav-presets-content .crel-dashboard__saving-error').text( '' );
			}
		}).done(function( response ){
			
			if ( response.status == 'error' ) {
				$('#crel-nav-presets-content .crel-dashboard__saving-error').text( response.message );
			} else {
				$('#crel-nav-presets-content .crel-dashboard__save-settings').text( crel_vars.saved_config );
				
				setTimeout(function(){
					$('#crel-nav-presets-content .crel-dashboard__save-settings').text( crel_vars.save_config );
				}, 1000);
				
			}
		
			$('.crel-dashboard__save-settings').prop( 'disabled', false );
			
		}).always(function(){
			crelRemoveLoader( $('.crel-dashboard__tabs__content') );
		});
	}
	
	$('#crel-nav-presets-content .crel-dashboard__save-settings').on( 'click', function(){
		savePresets();
	});

	// PREVIEW POPUP
	(function(){
		//Open Popup larger Image
		$( '.crel_img_zoom' ).on( 'click', function( e ){

			e.preventDefault();
			e.stopPropagation();

			$( '#crel-admin-page-wrap' ).find( '.image_zoom' ).remove();

			var img_src;
			var img_tag = $( this ).find( 'img' );
			if ( img_tag.length > 1 ) {
				img_src = $(img_tag[0]).is(':visible') ? $(img_tag[0]).attr('src') :
					( $(img_tag[1]).is(':visible') ? $(img_tag[1]).attr('src') : $(img_tag[2]).attr('src') );

			} else {
				img_src = $( this ).find( 'img' ).attr( 'src' );
			}

			$( this ).after('' +
				'<div id="crel_image_zoom" class="image_zoom">' +
				'<img src="' + img_src + '" class="image_zoom">' +
				'<span class="close icon_close"></span>'+
				'</div>' + '');

			//Close Plugin Preview Popup
			$('html, body').on( 'click', function() {
				
				$( '#crel_image_zoom' ).remove();
				$('html, body').off('click');
				
			});
		});
	})();

	// featured image pop up
	(function(){
		var crel = $( '.crel-dashboard' );

		//Open Popup larger Image
		crel.find( '.featured_img' ).on( 'click', function( e ){

			e.preventDefault();
			e.stopPropagation();

			crel.find( '.image_zoom' ).remove();

			var img_src;
			var img_tag = $( this ).find( 'img' );
			if ( img_tag.length > 1 ) {
				img_src = $(img_tag[0]).is(':visible') ? $(img_tag[0]).attr('src') :
					( $(img_tag[1]).is(':visible') ? $(img_tag[1]).attr('src') : $(img_tag[2]).attr('src') );

			} else {
				img_src = $( this ).find( 'img' ).attr( 'src' );
			}

			$( this ).after('' +
				'<div id="crel_image_zoom" class="image_zoom">' +
				'<img src="' + img_src + '" class="image_zoom">' +
				'<span class="close icon_close"></span>'+
				'</div>' + '');

			//Close Plugin Preview Popup
			$('html, body').on( 'click.crel', function() {
				
				$( '#crel_image_zoom' ).remove();
				$('html, body').off('click.crel');
				
			});
		});
	})();
});