<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if plugin upgrade to a new version requires any actions like database upgrade
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ELAY_Upgrades {

	public function __construct() {
        // will run after plugin is updated but not always like front-end rendering
		add_action( 'admin_init', array( 'ELAY_Upgrades', 'update_plugin_version' ) );
		add_filter( 'eckb_plugin_upgrade_message', array( 'ELAY_Upgrades', 'display_upgrade_message' ) );
        add_action( 'eckb_remove_upgrade_message', array( 'ELAY_Upgrades', 'remove_upgrade_message' ) );
	}

    /**
     * If necessary run plugin database updates
     */
    public static function update_plugin_version() {

        $last_version = ELAY_Utilities::get_wp_option( 'elay_version', null );
		if ( empty($last_version) ) {
			ELAY_Utilities::save_wp_option( 'elay_version', Echo_Elegant_Layouts::$version, true );
			return;
		}

        // if plugin is up-to-date then return
        if ( version_compare( $last_version, Echo_Elegant_Layouts::$version, '>=' ) ) {
            return;
        }

		// since we need to upgrade this plugin, on the Overview Page show an upgrade message
	    ELAY_Utilities::save_wp_option( 'elay_show_upgrade_message', true, true );

        // upgrade the plugin
        self::invoke_upgrades( $last_version );

        // update the plugin version
        $result = ELAY_Utilities::save_wp_option( 'elay_version', Echo_Elegant_Layouts::$version, true );
        if ( is_wp_error( $result ) ) {
	        ELAY_Logging::add_log( 'Could not update plugin version', $result );
            return;
        }
    }

    /**
     * Invoke each database update as necessary.
     *
     * @param $last_version
     */
    private static function invoke_upgrades( $last_version ) {

        // update all KBs
        $all_kb_ids = elay_get_instance()->kb_config_obj->get_kb_ids();
        foreach ( $all_kb_ids as $kb_id ) {

	        $add_on_config = elay_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );

	        $update_config = self::run_upgrade( $add_on_config, $last_version );

	        // store the updated KB data
	        if ( $update_config ) {
            	elay_get_instance()->kb_config_obj->update_kb_configuration( $kb_id, $add_on_config );
	        }
        }
    }

	public static function run_upgrade( &$add_on_config, $last_version ) {

		$update_config = false;
    	if ( version_compare( $last_version, '1.2.1', '<' ) ) {
			self::upgrade_to_v121( $add_on_config, $add_on_config['id'] );
			$update_config = true;
		}

		if ( version_compare( $last_version, '1.6.0', '<' ) ) {
			self::upgrade_to_v160( $add_on_config, $add_on_config['id'] );
			$update_config = true;
		}

		if ( version_compare( $last_version, '2.6.0', '<' ) ) {
			self::upgrade_to_v260( $add_on_config, $add_on_config['id'] );
			$update_config = false;  // updating KB Core only
		}
		
		if ( version_compare( $last_version, '2.6.1', '<' ) ) {
			self::upgrade_to_v261( $add_on_config, $add_on_config['id'] );
			$update_config = false;  // updating KB Core only
		}

		if ( version_compare( $last_version, '2.8.0', '<' ) ) {
			self::upgrade_to_v280( $add_on_config );
			$update_config = true;
		}

		return $update_config;
	}

	private static function upgrade_to_v280( &$add_on_config ) {

		if ( ! empty($add_on_config['grid_section_font_size']) ) {

			switch ( $add_on_config['grid_section_font_size'] ) {
				case 'section_xsmall_font':
					$grid_section_typography = '15';
					$grid_section_description_typography = '12';
					$grid_section_article_typography = '10';
					break;
				case 'section_small_font':
					$grid_section_typography = '18';
					$grid_section_description_typography = '14';
					$grid_section_article_typography = '12';
					break;
				case 'section_medium_font':
					$grid_section_typography = '21';
					$grid_section_description_typography = '17';
					$grid_section_article_typography = '14';
					break;
				case 'section_large_font':
					$grid_section_typography = '24';
					$grid_section_description_typography = '19';
					$grid_section_article_typography = '16';
					break;
				default:
					$grid_section_typography = '21';
					$grid_section_description_typography = '16';
					$grid_section_article_typography = '12';
					break;
			}

			$add_on_config['grid_section_typography'] = array_merge( ELAY_Typography::$typography_defaults, array( 'font-size' => $grid_section_typography ) );
			$add_on_config['grid_section_description_typography'] = array_merge( ELAY_Typography::$typography_defaults, array( 'font-size' => $grid_section_description_typography ) );
			$add_on_config['grid_section_article_typography'] = array_merge( ELAY_Typography::$typography_defaults, array( 'font-size' => $grid_section_article_typography ) );
		}

		if ( ! empty($add_on_config['sidebar_section_font_size']) ) {

			switch ( $add_on_config['sidebar_section_font_size'] ) {
				case 'section_xsmall_font':
					$sidebar_section_category_typography        = '13';
					$sidebar_section_category_typography_desc   = '10';
					$sidebar_section_body_typography            = '10';
					break;
				case 'section_small_font':
					$sidebar_section_category_typography = '16';
					$sidebar_section_category_typography_desc = '12';
					$sidebar_section_body_typography = '12';
					break;
				case 'section_medium_font':
					$sidebar_section_category_typography = '18';
					$sidebar_section_category_typography_desc = '14';
					$sidebar_section_body_typography = '14';
					break;
				case 'section_large_font':
					$sidebar_section_category_typography = '21';
					$sidebar_section_category_typography_desc = '16';
					$sidebar_section_body_typography = '16';
					break;
				default:
					$sidebar_section_category_typography = '18';
					$sidebar_section_category_typography_desc = '14';
					$sidebar_section_body_typography = '14';
					break;

			}

			$add_on_config['sidebar_section_category_typography'] = array_merge( ELAY_Typography::$typography_defaults, array( 'font-size' => $sidebar_section_category_typography ) );
			$add_on_config['sidebar_section_category_typography_desc'] = array_merge( ELAY_Typography::$typography_defaults, array( 'font-size' => $sidebar_section_category_typography_desc ) );
			$add_on_config['sidebar_section_body_typography'] = array_merge( ELAY_Typography::$typography_defaults, array( 'font-size' => $sidebar_section_body_typography ) );
		}
	}

	private static function upgrade_to_v261( &$add_on_config, $kb_id ) {
		
		if ( ! class_exists('Echo_Knowledge_Base') || version_compare( Echo_Knowledge_Base::$version, '7.0.0', '<' ) ) {
			return;
		}
		
		$kb_config = ELAY_KB_Core::get_kb_config_or_default( $kb_id );
		$elay_config = $add_on_config;

		$main_page = $kb_config['kb_main_page_layout'];
		if ( $main_page == 'Grid' ) {
			$kb_config['width'] = str_replace( 'elay', 'epkb', $elay_config['grid_width'] );
		}

		ELAY_KB_Core::update_kb_configuration( $kb_id, $kb_config );
	}
	
	private static function upgrade_to_v260( &$add_on_config, $kb_id ) {

		if ( ! class_exists('Echo_Knowledge_Base') || version_compare( Echo_Knowledge_Base::$version, '7.0.0', '<' ) ) {
			return;
		}

		$kb_config = ELAY_KB_Core::get_kb_config_or_default( $kb_id );
		$elay_config = $add_on_config;

		$main_page = $kb_config['kb_main_page_layout'];
		if ( $main_page == 'Grid' || $main_page == 'Sidebar' ) {

			$prefix = $main_page == 'Grid' ? 'grid_' : 'sidebar_';

			$kb_config['search_title_font_color'] = $elay_config[$prefix . 'search_title_font_color'];
			$kb_config['search_background_color'] = $elay_config[$prefix . 'search_background_color'];
			$kb_config['search_text_input_background_color'] = $elay_config[$prefix . 'search_text_input_background_color'];
			$kb_config['search_text_input_border_color'] = $elay_config[$prefix . 'search_text_input_border_color'];
			$kb_config['search_btn_background_color'] = $elay_config[$prefix . 'search_btn_background_color'];
			$kb_config['search_btn_border_color'] = $elay_config[$prefix . 'search_btn_border_color'];

			$kb_config['search_layout'] = str_replace( 'elay', 'epkb', $elay_config[$prefix . 'search_layout'] ) ;

			$kb_config['search_input_border_width'] = $elay_config[$prefix . 'search_input_border_width'];
			$kb_config['search_box_padding_top'] = $elay_config[$prefix . 'search_box_padding_top'];
			$kb_config['search_box_padding_bottom'] = $elay_config[$prefix . 'search_box_padding_bottom'];
			$kb_config['search_box_padding_left'] = $elay_config[$prefix . 'search_box_padding_left'];
			$kb_config['search_box_padding_right'] = $elay_config[$prefix . 'search_box_padding_right'];
			$kb_config['search_box_margin_top'] = $elay_config[$prefix . 'search_box_margin_top'];
			$kb_config['search_box_margin_bottom'] = $elay_config[$prefix . 'search_box_margin_bottom'];
			$kb_config['search_box_input_width'] = $elay_config[$prefix . 'search_box_input_width'];

			if ( $main_page == 'Sidebar' ) {
				$kb_config['search_box_results_style'] = $elay_config[$prefix . 'search_box_results_style'];
			}

			$kb_config['search_title'] = $elay_config[$prefix . 'search_title'];
			$kb_config['search_box_hint'] = $elay_config[$prefix . 'search_box_hint'];
			$kb_config['search_button_name'] = $elay_config[$prefix . 'search_button_name'];
			$kb_config['search_results_msg'] = $elay_config[$prefix . 'search_results_msg'];
		}

		if ( $kb_config['kb_article_page_layout'] == 'Sidebar' ) {

			$prefix = 'sidebar_';

			$kb_config['article_search_title_font_color'] = $elay_config[$prefix . 'search_title_font_color'];
			$kb_config['article_search_background_color'] = $elay_config[$prefix . 'search_background_color'];
			$kb_config['article_search_text_input_background_color'] = $elay_config[$prefix . 'search_text_input_background_color'];
			$kb_config['article_search_text_input_border_color'] = $elay_config[$prefix . 'search_text_input_border_color'];
			$kb_config['article_search_btn_background_color'] = $elay_config[$prefix . 'search_btn_background_color'];
			$kb_config['article_search_btn_border_color'] = $elay_config[$prefix . 'search_btn_border_color'];

			$kb_config['article_search_layout'] = str_replace( 'elay', 'epkb', $elay_config[$prefix . 'search_layout'] ) ;

			$kb_config['article_search_input_border_width'] = $elay_config[$prefix . 'search_input_border_width'];
			$kb_config['article_search_box_padding_top'] = $elay_config[$prefix . 'search_box_padding_top'];
			$kb_config['article_search_box_padding_bottom'] = $elay_config[$prefix . 'search_box_padding_bottom'];
			$kb_config['article_search_box_padding_left'] = $elay_config[$prefix . 'search_box_padding_left'];
			$kb_config['article_search_box_padding_right'] = $elay_config[$prefix . 'search_box_padding_right'];
			$kb_config['article_search_box_margin_top'] = $elay_config[$prefix . 'search_box_margin_top'];
			$kb_config['article_search_box_margin_bottom'] = $elay_config[$prefix . 'search_box_margin_bottom'];
			$kb_config['article_search_box_input_width'] = $elay_config[$prefix . 'search_box_input_width'];
			$kb_config['article_search_box_results_style'] = $elay_config[$prefix . 'search_box_results_style'];

			$kb_config['article_search_title'] = $elay_config[$prefix . 'search_title'];
			$kb_config['article_search_box_hint'] = $elay_config[$prefix . 'search_box_hint'];
			$kb_config['article_search_button_name'] = $elay_config[$prefix . 'search_button_name'];
			$kb_config['article_search_results_msg'] = $elay_config[$prefix . 'search_results_msg'];

			$kb_config['article_search_box_collapse_mode'] = $elay_config[$prefix . 'search_box_collapse_mode'];
		}

		$new_intro_text = '<h2>Welcome to our Knowledge Base.</h2>
                        <h3 style="color: red;"><strong>To edit this welcome text, open this page in the frontend Editor.</strong></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>';

		if ( isset( $kb_config['sidebar_main_page_intro_text'] ) && strpos( $kb_config['sidebar_main_page_intro_text'], 'To edit this welcome text go to the Text Wizard') !== false ) {
			$kb_config['sidebar_main_page_intro_text'] = $new_intro_text;
		}

		ELAY_KB_Core::update_kb_configuration( $kb_id, $kb_config );
	}
	
	private static function upgrade_to_v160( &$add_on_config, $kb_id ) {

		$kb_config_value = ELAY_KB_Core::get_value( $kb_id, 'search_title' );
		$add_on_config['grid_search_title'] = $kb_config_value;
		$add_on_config['sidebar_search_title'] = $kb_config_value;

		$kb_config_value = ELAY_KB_Core::get_value( $kb_id, 'search_box_hint' );
		$add_on_config['grid_search_box_hint'] = $kb_config_value;
		$add_on_config['sidebar_search_box_hint'] = $kb_config_value;

		$kb_config_value = ELAY_KB_Core::get_value( $kb_id, 'search_button_name' );
		$add_on_config['grid_search_button_name'] = $kb_config_value;
		$add_on_config['sidebar_search_button_name'] = $kb_config_value;
	}

	private static function upgrade_to_v121( &$add_on_config, $kb_id ) {
		$add_on_config['grid_category_icon']           = str_replace( 'ep_icon', 'ep_font_icon', $add_on_config['grid_category_icon'] );
		$add_on_config['sidebar_expand_articles_icon'] = str_replace( 'ep_icon', 'ep_font_icon', $add_on_config['sidebar_expand_articles_icon'] );

		// update stored icons
		$new_categories_icons = array();
		$categories_icons = ELAY_Utilities::get_kb_option( $kb_id, 'elay_categories_icon', array(), true );
		foreach( $categories_icons as $category_id => $icon_name ) {
			$new_categories_icons[$category_id] = str_replace( 'ep_icon', 'ep_font_icon', $icon_name );
		}

		$result = ELAY_Utilities::save_kb_option( $kb_id, 'elay_categories_icon', $new_categories_icons, true );
		if ( is_wp_error( $result ) ) {
			ELAY_Logging::add_log( 'Could not update plugin version', $result );
		}
	}

    /**
     * Show upgrade message on Overview Page.
     *
     * @param $output
     * @return string
     */
	public static function display_upgrade_message( $output ) {

		if ( ELAY_Utilities::get_wp_option( 'elay_show_upgrade_message', false ) ) {

			$plugin_name = '<strong>' . __('Elegant Layouts', 'echo-knowledge-base') . '</strong>';
			$output .= '<p>' . $plugin_name . ' ' . sprintf( esc_html( _x( 'add-on was updated to version %s.',
									' version number, link to what is new page', 'echo-knowledge-base' ) ),
									Echo_Elegant_Layouts::$version ) . '</p>';
		}

		return $output;
	}
    
    public static function remove_upgrade_message() {
        delete_option('elay_show_upgrade_message');
    }
}
