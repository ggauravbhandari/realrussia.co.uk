jQuery(document).ready(function($) {
	$('body').on( 'click', '.elementor-control-crel_kbCategories_redirect_to_category a', function(){
		let url_template = $(this).data('url_template');
		
		if ( typeof url_template == 'undefined' ) {
			url_template = $(this).prop('href');
			$(this).data( 'url_template', url_template );
		}
		
		let current_kb_id  = 1;
		
		try {
			// Magic place with current openned widget settings 
			current_kb_id = elementor.getPanelView().getCurrentPageView().getOption("editedElementView").container.settings.attributes.crel_kb_id;
		} 
		catch(e) {}
		
		url_template = url_template.replace( /crel_kb_id/gi, current_kb_id );
		$(this).prop( 'href', url_template );
		
	});
	
	/** Promo block for the KB widgets */
	
	// this will trigger when elementor dialog will be openned/closed and we can delete our class from it 
	let observer = new MutationObserver(function(mutations) {
		
		if ( mutations[0].attributeName == 'style' ) {
			$('#elementor-element--promotion__dialog').addClass('crel-promo-invisible');
		}
		// "show" event 
		if ( $('#elementor-element--promotion__dialog').is(":visible") ) {
			return true;
		}
		
		// "hide" event 
		$('#elementor-element--promotion__dialog').removeClass('crel-promo-popup');
	});
	
	let hideEventDefined = false;
	
	$(document).on('mousedown', '.elementor-element--promotion', function(){ 
		$('body').addClass('crel-mouse-drag');
	});
	
	$(document).on('mouseup', '.elementor-element--promotion', function(){ 
		$('body').removeClass('crel-mouse-drag');
	});
	// Function for the promo text for blocked widgets 
	$(document).on('click', '.elementor-element--promotion', function(){ 
		
		// set event to see when popup will be hided to set back styles and button 
		if ( !hideEventDefined ) {
			observer.observe( document.querySelector('#elementor-element--promotion__dialog'), {
				attributes: true
			});
		}
		
		if ( $(this).closest('#elementor-panel-category-creative_addons_category').length ) {
			
			// crel promo block 
			$('#elementor-element--promotion__dialog').addClass('crel-promo-popup');

			// change text 
			$('#elementor-element--promotion__dialog .dialog-buttons-message').html( crel_promo.message );
			
			// get link url 
			
			let $icon = $(this).find('.icon .crelfont');
			let link = crel_promo.link_url_2; // just in case if something go wrong
			
			if ( typeof crel_promo.link_urls !== 'undefined' ) {
				for ( let n in crel_promo.link_urls ) {
					if ( $icon.hasClass(n) ) {
						link = crel_promo.link_urls[n];
					}
				}
			}
			
			// add link if it have no link 
			$('#elementor-element--promotion__dialog .crel-dialog-buttons-action').remove();
			$('#elementor-element--promotion__dialog .dialog-buttons-buttons-wrapper').append('<a href="' + crel_promo.link_url + '" class="dialog-button dialog-action dialog-buttons-action elementor-button elementor-button-success crel-dialog-buttons-action" ' + crel_promo.link_target + '>' + crel_promo.link_title + '</a>');
			$('#elementor-element--promotion__dialog .dialog-buttons-buttons-wrapper').append('<a href="' + link + '" class="dialog-button dialog-action dialog-buttons-action elementor-button elementor-button-success crel-dialog-buttons-action" target="_blank">' + crel_promo.link_title_2 + '</a>');
			
		} else {
			// other promo blocks 
			$('#elementor-element--promotion__dialog').removeClass('crel-promo-popup');
		}
		
		// anyway make it visible and check position  TODO remove position check after elementor will fix it
		let left = Math.round( $(this).offset().left + $(this).width() + 15 );
		let top = Math.round( $(this).offset().top - 7 );

		$('#elementor-element--promotion__dialog').css({
			'top' : top,
			'left' : left
		});
		$('#elementor-element--promotion__dialog').removeClass('crel-promo-invisible');
	});
	
  	
	/** End Promo widgets */
	
	
	/** Advanced Lists */
	// Disable align buttons in wysiwyg editor
	tinymce.on('AddEditor', function (e) {
		
		setTimeout(function(){ // need to wait when all toolbars will created, 50ms enough, 100 just in case
			
			if ( ! $(e.editor.container).closest('.elementor-control-crel_advancedLists__list_text').length ) {
				// check once more for low-end computers
				setTimeout( function(){
					
					if ( ! $(e.editor.container).closest('.elementor-control-crel_advancedLists__list_text').length ) {
						return;
					}
					
					let panelButtons = e.editor.theme.panel.controlIdLookup;
			
					for ( let button in panelButtons ) {
						
						if ( panelButtons[button].settings.icon == 'alignleft' 
							|| panelButtons[button].settings.icon == 'alignright' 
							|| panelButtons[button].settings.icon == 'aligncenter' 
							|| panelButtons[button].settings.icon == 'numlist'
							|| panelButtons[button].settings.icon == 'blockquote' ) {
							panelButtons[button].$el.hide();
						}
					}
				}, 1000 );
				
				return;
			}
			
			let panelButtons = e.editor.theme.panel.controlIdLookup;
			
			for ( let button in panelButtons ) {
				if ( panelButtons[button].settings.icon == 'alignleft' 
					|| panelButtons[button].settings.icon == 'alignright' 
					|| panelButtons[button].settings.icon == 'aligncenter' 
					|| panelButtons[button].settings.icon == 'numlist'
					|| panelButtons[button].settings.icon == 'blockquote' ) {
					panelButtons[button].$el.hide();
				}
			}
	
		}, 100);
	});
	
	/** End Advanced Lists */
	
	/** KB Search */
	// Prevent search in admin 
	$('body').on('submit', '.crel-search-box__search-form', false);
	
	/** End KB Search */
	
	/** Steps */
	$('#elementor-preview-iframe').load(function () {
	 
        $('#elementor-preview-iframe').contents().on('click', function (e) {
			let $el = $(e.target);

			if ( $el.closest('.crel-steps-container').length == 0 ) {
				return true;
			}
			
			// activate needed tab on the editor panel 
			let stepWrap = $el.closest('.crel-step');
			
			if ( stepWrap.length == 0 ) {
				return true;
			}
			
			// calculate number of the step 
			let stepsWrap = $el.closest('.crel-steps-container');
			let i = 0;
			
			stepsWrap.find('.crel-step').each(function(){
				if ( $(this).prop('id') == stepWrap.prop('id') ) {
					return false;
				}
				
				i++;
			});
			
			// open editor panel if it is closed 
			if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
				$('#elementor-mode-switcher-inner label').trigger('click');
			}
			
			// open tab 
			$('.elementor-tab-control-content a').trigger('click');
			
			// check steps panel openned
			if ( !$('.elementor-control-crel_steps__steps_section_content').hasClass('elementor-open') ) {
				$('.elementor-control-crel_steps__steps_section_content').trigger('click');
			}
			
			// delay to be shure that all elementor events finished
			setTimeout(function(){
				
				let field = $('#elementor-controls').find('.elementor-repeater-fields-wrapper').find('.elementor-repeater-fields').eq(i);
				
				if ( field.length && ( field.find('.editable').length == 0 ) ) {
					field.find('.elementor-repeater-row-item-title').trigger('click');
					$('#elementor-panel-content-wrapper').scrollTop( 50 * i + 150 );
					
				}
				
				if ( field.length && typeof e.originalEvent.path[0] !== 'undefined' && field.find( '.elementor-control-title_tab' ).length ) {
					// open needed tab 
					if ( $(e.originalEvent.path[0]).hasClass('crel-step-header__title__text') ) {
						field.find( '.elementor-control-title_tab' ).trigger('click');
					}
					
					if ( $(e.originalEvent.path[0]).hasClass('elementor-text-editor') ) {
						field.find( '.elementor-control-text_tab' ).trigger('click');
					}
					
					if ( e.originalEvent.path[0].tagName.toLowerCase() == 'img' ) {
						field.find( '.elementor-control-image_tab' ).trigger('click');
					}
				}
				
			}, 100);
			
        });
    });
	
	// Update image size after upload a new image in steps editor // TODO remove this after elementor will fix this bug
	elementor.channels.editor.on('imagesManager:detailsReceived', function () { 
		if ( $('.elementor-control-crel_steps__list').length == 0 ) {
			return;
		}
		
		$('.elementor-control-crel_steps__list [data-setting=image_size]').trigger('change')
	});
	
	/** End Steps */
	
	/** Image Guide */
	
	const crel_image_guide_drag = function ($element) {
		return {
			initialize: function () {
                $element.prototype.initialize.apply(this, arguments),
                this.listenTo(elementor.channels.dataEditMode, "switch", this.toggleSpotDragMode);						
                this.listenTo(this.model.get("editSettings"), "change:activeItemIndex", this.onEditSettingsChange);
            },
			
			// basic function that will called after render, turn on draggable mode 
			onRender: function () {
                $element.prototype.onRender.call(this);
				this.toggleSpotDragMode();
            },
			
			// turn off when deactivate 
			onDestroy: function () {
                this.deactivateSpotDragMode();
				$element.prototype.onDestroy.call(this);
            },
					
			// add draggable classes 
			activateSpotDragMode: function () {
                this.ui.spotHandle.draggable({ addClasses: false });
            },
			
			deactivateSpotDragMode: function () {
                this.ui.spotHandle.draggable("instance") && this.ui.spotHandle.draggable("destroy");
            },
			
			// prevent spots moving when the user hide edit panel 
			toggleSpotDragMode: function() {
				let editMode = ( "edit" === elementor.channels.dataEditMode.request("activeMode") );
				this.deactivateSpotDragMode();
			
				if ( editMode && elementor.userCan("design") ) {
					this.activateSpotDragMode();
				}
			},
			
			// define selector for image Guide
			ui: function () {
                let selector = $element.__super__.ui.call(this);
				selector.spotHandle = '> .elementor-widget-container .crel-image-guide__spot';
				selector.listItemHandle = '> .elementor-widget-container .crel-image-guide__list-item';
				selector.imageHandle = '> .elementor-widget-container .crel-image-guide__image-spots';
                return selector;
            },
			
			// add active class to the spot on the preview which we are editing on the edit panel
			onEditSettingsChange: function(e) {
				this.$el
                    .find('[data-index="' + (e.get("activeItemIndex") - 1) + '"]')
                    .addClass("crel-image-guide__spot--active")
                    .siblings(".crel-image-guide__spot--active")
                    .removeClass("crel-image-guide__spot--active");
			},
			
			// add our events for drag and to open needed spot on the edit panel 
			events: function() {
                let allEvents = $element.__super__.events.call(this);
				allEvents["click @ui.spotHandle"] = "onClickSpot";
				allEvents["dragstart @ui.spotHandle"] = "openSelectedSpot";
				allEvents["dragstop @ui.spotHandle"] = "onDragSpotHandle";
				allEvents["click @ui.listItemHandle"] = "onClickListItem";
				allEvents["click @ui.imageHandle"] = "onClickImage";
				
				return allEvents;
            },
			
			onMouseDown: function onMouseDown(event) {
				
				// open editor panel if it is closed 
				if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
					$('#elementor-mode-switcher-inner label').trigger('click');
				}
				
				this.model.trigger("request:edit");
			},
			
			// event when the user clicked on the spot - open edit panel 
			onClickSpot: function (e) {
                e.preventDefault();
				
				this.openSelectedSpot(e);
            },
			
			openSelectedSpot: function (e) {
                e.stopPropagation();
				
				// open editor panel if it is closed 
				if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
					$('#elementor-mode-switcher-inner label').trigger('click');
				}
				
				this.model.trigger("request:edit");
				
                let spot = this.getSpotByIndex(e.currentTarget.getAttribute("data-index"));
				
				if ( ! spot ) {
					return;
				}
				
                let itemTitle = spot.ui.itemTitle;
                
				if ( ! itemTitle.parent().next().hasClass("editable") ) {
					itemTitle.trigger('click');
				}
				
				// check tab 
				if ( typeof e.originalEvent.path !== 'undefined' && typeof e.originalEvent.path[0] !== 'undefined' && $(e.originalEvent.path[0]).hasClass('crel-image-guide__list-text') ) {
					itemTitle.parent().next().find('.elementor-control-spots_tabs .elementor-control-text_tab').trigger('click');
				} else {
					itemTitle.parent().next().find('.elementor-control-spots_tabs .elementor-control-icon_tab .elementor-panel-tab-heading').trigger('click');
				}
				
				// scroll to needed place
				setTimeout( function() {
					$('#elementor-panel-content-wrapper').animate({
						scrollTop: $('.elementor-control-crel_image_guide__spots').position().top - $('#elementor-panel-page-editor').position().top + itemTitle.closest('.elementor-repeater-fields').position().top
					}, 200);
				}, 100);
            },
			
			getSpotByIndex: function ( i ) {
				let view = this.getSpotsView()
				if ( typeof view  !== 'undefined' ) return view.children.findByIndex( i );
				
				return false;
            },
			
			getControlViewByName: function ( name ) {
                return elementor
                          .getPanelView()
                          .getCurrentPageView()
                          .children.find( function (child) {
							return child.model.get("name") === name;
                          });
            },
					
			// get "view" of the panel with spots 
			getSpotsView: function () {
				
				let panel = this.model.get("editSettings").get("panel");
				
				// check tab 
				if ( panel.activeTab !== 'content' ) {
					$('.elementor-tab-control-content').trigger('click');
				}
				
				if ( "crel_image_guide_spots_section" !== panel.activeSection ) {
					this.getControlViewByName("crel_image_guide_spots_section").ui.heading.trigger('click'); // select widget
				}
				
                return this.getControlViewByName("crel_image_guide__spots");
            },
			
			// main function to translate coordinates to editor 
			onDragSpotHandle: function ( e, spot ) {
				e.stopPropagation();
				
				let deviceMode = "desktop" === elementorFrontend.getCurrentDeviceMode() ? "" : "_" + elementorFrontend.getCurrentDeviceMode(),
				helper = spot.helper,
				el = this.getEditModel().getSetting("crel_image_guide__spots").at(helper.data("index")),
				position_data = {},
				offsetX = elementorFrontend.config.is_rtl ? ( helper.offsetParent().width() -  spot.position.left - helper.outerWidth( true ) ) : spot.position.left,
				offsetY = spot.position.top,
				xUnit = el.get("crel_image_guide__spot_X" + deviceMode).unit,
				yUnit = el.get("crel_image_guide__spot_Y" + deviceMode).unit;
				
				offsetX = ((100 * offsetX) / helper.offsetParent().width() ).toFixed(2);
				offsetY = ((100 * offsetY) / helper.offsetParent().height()).toFixed(2); 
				
				position_data["crel_image_guide__spot_X" + deviceMode] = { size: offsetX, unit: xUnit };
				position_data["crel_image_guide__spot_Y" + deviceMode] = { size: offsetY, unit: yUnit };
				
				el.setExternalChange(position_data);
				
				this.renderStyles();
				
				let timer = setTimeout(function () {
					helper.css({ top: "", left: "", right: "", bottom: "", width: "", height: "" });
					clearTimeout(timer); // run once 
				}, 250);
				
				$('#elementor-panel-saver-button-publish, #elementor-panel-saver-button-save-options').removeClass('elementor-disabled');
			},
			
			// open panel on click on the kist item
			onClickListItem: function( e ) {
				e.preventDefault();
				this.openSelectedSpot(e);
			} ,
			
			// open image setting when click on image 
			onClickImage: function( e ) {
				e.preventDefault();
				e.stopPropagation();
				
				// open editor panel if it is closed 
				if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
					$('#elementor-mode-switcher-inner label').trigger('click');
				}
				
				this.model.trigger("request:edit");
				
				let panel = this.model.get("editSettings").get("panel");
				
				// check tab 
				if ( panel.activeTab !== 'content' ) {
					$('.elementor-tab-control-content').trigger('click');
				}
				
				if ( "crel_image_guide_image_section" !== panel.activeSection ) {
					this.getControlViewByName("crel_image_guide_image_section").ui.heading.trigger('click'); // select widget
				}
				
				// scroll to needed place 
				setTimeout( function() {
					$('#elementor-panel-content-wrapper').animate({
						scrollTop: $('.elementor-control-crel_image_guide_image_section').position().top - $('#elementor-panel-page-editor').position().top
					}, 200);
				}, 100);
			}
		}
	}
	
    elementor.hooks.addFilter("element/view", function (e, widget) {
        return ( "widget" === widget.get("elType") && "crel-image-guide" === widget.get("widgetType") ) ? e.extend(crel_image_guide_drag(e)) : e;
    }); 
	
	/** End Image Guide */
	
	/** Text and Image */
	
	const crel_text_image_helper = function ($element) {
		return {
			initialize: function () {
                $element.prototype.initialize.apply(this, arguments);
            },
			
			onEditSettingsChange: function(e) {
				
			},
			
			getControlViewByName: function ( name ) {
                return elementor
                          .getPanelView()
                          .getCurrentPageView()
                          .children.find( function (child) {
							return child.model.get("name") === name;
                          });
            },
			
			// define selectors for events 
			ui: function () {
                let selector = $element.__super__.ui.call(this);
				selector.imgHandle = '> .elementor-widget-container .crel-text-image-img';
				selector.textHandle = '> .elementor-widget-container .crel-text-image-body';
                return selector;
            },
			
			// add our events for drag and to open needed spot on the edit panel 
			events: function() {
                let allEvents = $element.__super__.events.call(this);
				allEvents["click @ui.imgHandle"] = "onClickImage";
				allEvents["click @ui.textHandle"] = "onClickText";
				return allEvents;
            },
			
			// open image setting when click on image 
			onClickImage: function( e ) {
				e.preventDefault();
				e.stopPropagation();
				
				// open editor panel if it is closed 
				if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
					$('#elementor-mode-switcher-inner label').trigger('click');
				}
				
				this.model.trigger("request:edit");
				
				let panel = this.model.get("editSettings").get("panel");
				
				// check tab 
				if ( panel.activeTab !== 'content' ) {
					$('.elementor-tab-control-content').trigger('click');
				}
				
				if ( ! $('.elementor-control-crel_text_image__section_image').hasClass('elementor-open') ) {
					$('.elementor-control-crel_text_image__section_image').trigger('click');
				}
				
				// scroll to needed place 
				setTimeout( function() {
					$('#elementor-panel-content-wrapper').animate({
						scrollTop: $('.elementor-control-crel_text_image__section_image').position().top - $('#elementor-panel-page-editor').position().top
					}, 200);
				}, 100);
			},
			
			onClickText: function( e ) {
				e.preventDefault();
				e.stopPropagation();
				
				// open editor panel if it is closed 
				if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
					$('#elementor-mode-switcher-inner label').trigger('click');
				}
				
				this.model.trigger("request:edit");
				
				let panel = this.model.get("editSettings").get("panel");
				
				// check tab 
				if ( panel.activeTab !== 'content' ) {
					$('.elementor-tab-control-content').trigger('click');
				}
				
				if ( ! $('.elementor-control-crel_text_image__section_description').hasClass('elementor-open') ) {
					$('.elementor-control-crel_text_image__section_description').trigger('click');
				}
				
				// scroll to needed place 
				setTimeout( function() {
					$('#elementor-panel-content-wrapper').animate({
						scrollTop: $('.elementor-control-crel_text_image__section_description').position().top - $('#elementor-panel-page-editor').position().top
					}, 200);
				}, 100);
			}
		}
	}
	
	elementor.hooks.addFilter("element/view", function (e, widget) {
        return ( "widget" === widget.get("elType") && "crel-text-image" === widget.get("widgetType") ) ? e.extend(crel_text_image_helper(e)) : e;
    }); 
	
	elementor.channels.editor.on('change', function (e) {
		
		if ( typeof e.$el !== 'undefined' ) {
			
			if ( e.$el.hasClass('elementor-control-crel_text_image__layout_type') ||
				e.$el.hasClass('elementor-control-crel_text_image__layout_type_desktop') ||
				e.$el.hasClass('elementor-control-crel_text_image__layout_type_tablet') || 
				e.$el.hasClass('elementor-control-crel_text_image__layout_type_mobile') ) {
				// update view 
				// update fake select because elementor don't update view if select have Selectors // TODO remove this after elementor will fix it 
				$('[data-setting="crel_text_image__layout_type_trigger"]').trigger('change');
			}
			
			if ( e.$el.hasClass('elementor-control-crel_image_guide__layout_type') ||
				e.$el.hasClass('elementor-control-crel_image_guide__layout_type_desktop') || 
				e.$el.hasClass('elementor-control-crel_image_guide__layout_type_tablet') || 
				e.$el.hasClass('elementor-control-crel_image_guide__layout_type_mobile') ) {
				// update view 
				// update fake select because elementor don't update view if select have Selectors // TODO remove this after elementor will fix it 
				$('[data-setting="crel_image_guide__layout_type_trigger"]').trigger('change');
			}
		}
	});
	
	/** End Text and Image */
	
	/** Code Block */
	
	const crel_code_block_helper = function ($element) {
		return {
			initialize: function () {
                $element.prototype.initialize.apply(this, arguments);
            },
			
			onEditSettingsChange: function(e) {
				
			},
			
			getControlViewByName: function ( name ) {
                return elementor
                          .getPanelView()
                          .getCurrentPageView()
                          .children.find( function (child) {
							return child.model.get("name") === name;
                          });
            },
			
			// define selectors for events 
			ui: function () {
                let selector = $element.__super__.ui.call(this);
				selector.preHandle = '> .elementor-widget-container pre';
                return selector;
            },
			
			// add our events for drag and to open needed spot on the edit panel 
			events: function() {
                let allEvents = $element.__super__.events.call(this);
				allEvents["click @ui.preHandle"] = "onClickPre";
				return allEvents;
            },
			
			// open image setting when click on image 
			onClickPre: function( e ) {
				e.preventDefault();
				e.stopPropagation();
				
				// open editor panel if it is closed 
				if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
					$('#elementor-mode-switcher-inner label').trigger('click');
				}
				
				this.model.trigger("request:edit");
				
				let panel = this.model.get("editSettings").get("panel");

				// check tab 
				if ( panel.activeTab !== 'content' ) {
					$('.elementor-tab-control-content').trigger('click');
				}
				
				if ( ! $('.elementor-control-crel_code_block__general_section_controls').hasClass('elementor-open') ) {
					$('.elementor-control-crel_code_block__general_section_controls').trigger('click');
				}
				
				// scroll to needed place 
				setTimeout( function() {
					$('#elementor-panel-content-wrapper').animate({
						scrollTop: $('.elementor-control-crel_code_block__general_section_controls').position().top - $('#elementor-panel-page-editor').position().top
					}, 200);
				}, 100);
			},
			
		}
	}
	
	elementor.hooks.addFilter("element/view", function (e, widget) {
        return ( "widget" === widget.get("elType") && "crel-code-block" === widget.get("widgetType") ) ? e.extend(crel_code_block_helper(e)) : e;
    }); 
	
	
	/** Advanced Heading  */
	
	const crel_advanced_heading_helper = function ($element) {
		return {
			
			// do we need update of the ID ( first use of the widget )
			updateId: true,
			
			initialize: function () {
                $element.prototype.initialize.apply(this, arguments);
				
				// if we have 
				if ( this.model.attributes.settings.attributes.crel_advancedHeading__linkId ) {
					this.updateId = false;
				} else {
					//this.onTouchHeading();
					
					let that = this;
					
					elementor.channels.editor.on('change', function (e) {
						
						if ( ! e.$el.find('input').length ) {
							return;
						}

						// stop changing slug if user edit it 
						if ( e.$el.find('input').data('setting') == 'crel_advancedHeading__linkId' ) {
							
							if ( e.$el.find('input').val() ) {
								that.updateId = false;
							} else {
								that.updateId = true;
							}
						// update slug if user edit settings on the panel 	
						} else {
							that.onTouchHeading();
						}
						
					});
				}
            },
			
			getControlViewByName: function ( name ) {
                return elementor
                          .getPanelView()
                          .getCurrentPageView()
                          .children.find( function (child) {
							return child.model.get("name") === name;
                          });
            },
			
			// define selectors for events 
			ui: function () {
                let selector = $element.__super__.ui.call(this);
				selector.Heading = '.crel-advanced-heading__title__text';
                return selector;
            },
			
			// add our events for drag and to open needed spot on the edit panel 
			events: function() {
                let allEvents = $element.__super__.events.call(this);
				allEvents["click @ui.Heading"] = "onTouchHeading";
				allEvents["keyup @ui.Heading"] = "onTouchHeading";
				return allEvents;
            },
				
			onTouchHeading: function( e ) {
				
				if ( typeof e != 'undefined' ) {
					// open heading panel 
					// open editor panel if it is closed 
					if ( $('#elementor-mode-switcher-preview-input').prop('checked') ) {
						$('#elementor-mode-switcher-inner label').trigger('click');
					}
					
					this.model.trigger("request:edit");
					
					let panel = this.model.get("editSettings").get("panel");
					
					// check tab 
					if ( panel.activeTab !== 'content' ) {
						$('.elementor-tab-control-content').trigger('click');
					}
					
					if ( ! $('.elementor-control-crel_advancedHeading__titleText__section_content').hasClass('elementor-open') ) {
						$('.elementor-control-crel_advancedHeading__titleText__section_content').trigger('click');
					}
					
					// scroll to needed place 
					setTimeout( function() {
						$('#elementor-panel-content-wrapper').animate({
							scrollTop: $('.elementor-control-crel_advancedHeading__title_text').position().top - $('#elementor-panel-page-editor').position().top
						}, 200);
					}, 100);
				
				}
				
				// no needs to update ID 
				if ( ! this.updateId ) {
					return;
				}
				
				// update slug from title 
				let titleEl = $('[data-setting=crel_advancedHeading__title_text]');
				let newTitle = titleEl.length ? titleEl.val() : '';
				
				// create slug from title 
				newTitle = this.createSlug( newTitle );
				
				elementor.getPanelView().getCurrentPageView().model.setSetting('crel_advancedHeading__linkId', newTitle);
				
			},
			
			createSlug: function ( str ) {
				str = str.replace(/(?![\-_])\p{P}/gu, ""); // punctuation
				str = str.replace('$',"-"); // $
				str = str.replace(/\s/g,"-"); // space

				let i = str.length;

				while ( i && ~str.search( /^(-|\d)/ ) ) { // first letter
					str = str.replace( /^(-|\d)/, '' );
					i--;
				}

				if ( str.length == 0 ) {
					str = 'crel-' + Math.floor(Math.random() * 999 );
				}

				return str;
			}
		}
	}
	
	elementor.hooks.addFilter("element/view", function (e, widget) {
        return ( "widget" === widget.get("elType") && "crel-advanced-heading" === widget.get("widgetType") ) ? e.extend(crel_advanced_heading_helper(e)) : e;
    }); 
});
