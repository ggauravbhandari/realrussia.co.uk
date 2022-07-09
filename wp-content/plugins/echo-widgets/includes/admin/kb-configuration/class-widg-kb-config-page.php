<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display Widgets configuration on KB Configuration page
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class WIDG_KB_Config_Page {

	public function __construct() {
        add_filter( WIDG_KB_Core::WIDG_KB_ARTICLE_PAGE_ADD_ON_LINKS, array( $this, 'get_widget_menu' ), 10, 3 );
        add_action( WIDG_KB_Core::WIDG_KB_ARTICLE_PAGE_ADD_ON_MENU_CONTENT, array( $this, 'display_widget_menu_content' ) );
        add_action( WIDG_KB_Core::WIDG_KB_ARTICLE_CONFIG_SIDEBAR_CONTENT, array( $this, 'display_widget_sidebar_content' ) );
		
		WIDG_KB_Wizard::register_all_wizard_hooks();
	}

	public function get_widget_menu( $article_page_add_on_links, $kb_article_page_layout, $kb_config ) {
        return $article_page_add_on_links + array( 10 => 'WIDGETS' );
    }

    /**
     * Show configuration within Sidebar content (right side of the menu) if applicable
     *
     * @param $kb_config
     */
    public function display_widget_menu_content( $kb_config ) {

		$sections = array();

		// only v1 article structure uses old sidebar
	    // latest KB Core has KB Sidebar included
	    if ( class_exists('Echo_Knowledge_Base') && version_compare(Echo_Knowledge_Base::$version, '6.0.0', '<') ) {
		    $sections[] = array(
			    'heading' => 'KB Sidebar Location',
			    'form_elements' => array(
				    array(
					    'id'   => 'mega-menu-main-page-layout',
					    'html' => $this->get_sidebar_location_html( $kb_config )
				    )
			    )
		    );
	    }

		$sections[] = array(
            'heading' => 'Search Style Presets',
            'form_elements' => array(
	            array(
		            'id'   => 'widget-search-presets',
		            'html' => $this->get_search_presets_html( $kb_config )
	            )
            )
        );
	    $sections[] = array(
            'heading' => 'Widget Documentation',
            'form_elements' => array(
	            array(
		            'id'   => 'widget-documentation',
		            'html' => '<a target="_blank" href="https://www.echoknowledgebase.com/documentation/kb-widgets-overview/" class="eckb-external-link">Click here</a>'
	            )
            )
        );

        $this->mega_menu_item_custom_html_content( array(
            'id'       => 'eckb-mm-ap-links-widgets',
            'sections' => $sections
        ) );
    }

    public function display_widget_sidebar_content( $kb_config ) {      ?>

        <div class="ep'.'kb-config-sidebar" id="widg-config-widget-sidebar">
            <div class="ep'.'kb-config-sidebar-options">                <?php
                $feature_specs = WIDG_KB_Config_Specs::get_fields_specification();
                $add_on_config = widg_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_config['id'] );
                $form          = new WIDG_KB_Config_Elements();

	            $form->option_group( $feature_specs, array(
		            'option-heading'    => 'Search Widget / Shortcode',
		            'class'             => 'widg-widgets-sidebar-config',
		            'inputs'            => array(
			            '0' => $form->text( $feature_specs['widg_search_results_limit'] + array(
					            'value'             => $add_on_config['widg_search_results_limit'],
					            'input_group_class' => 'config-col-12',
					            'label_class'       => 'config-col-4',
					            'input_class'       => 'config-col-2'
				            ) ),
		            )
	            ));

                $form->option_group( $feature_specs, array(
                    'option-heading'    => 'CSS Resets / Defaults',
                    'class'             => 'widg-widgets-sidebar-config',
                    'inputs'            => array(
                        '0' => $form->checkbox( $feature_specs['widg_widget_css_reset'] + array(
                                'value'             => $add_on_config['widg_widget_css_reset'],
                                'id'                => 'widg_widget_css_reset',
                                'input_group_class' => 'config-col-12',
                                'label_class'       => 'config-col-5',
                                'input_class'       => 'config-col-6'
                            ) ),
                        '1' => $form->checkbox( $feature_specs['widg_widget_css_defaults'] + array(
                                'value'             => $add_on_config['widg_widget_css_defaults'],
                                'id'                => 'widg_widget_css_defaults',
                                'input_group_class' => 'config-col-12',
                                'label_class'       => 'config-col-5',
                                'input_class'       => 'config-col-6'
                            ) ),
	                    '2' => $form->checkbox( $feature_specs['widg_shortcode_css_reset'] + array(
			                    'value'             => $add_on_config['widg_shortcode_css_reset'],
			                    'id'                => 'widg_shortcode_css_reset',
			                    'input_group_class' => 'config-col-12',
			                    'label_class'       => 'config-col-5',
			                    'input_class'       => 'config-col-6'
		                    ) ),
	                    '3' => $form->checkbox( $feature_specs['widg_shortcode_css_defaults'] + array(
			                    'value'             => $add_on_config['widg_shortcode_css_defaults'],
			                    'id'                => 'widg_shortcode_css_defaults',
			                    'input_group_class' => 'config-col-12',
			                    'label_class'       => 'config-col-5',
			                    'input_class'       => 'config-col-6'
		                    ) )
                    )


                ));
                                ?>
            </div>
        </div>      <?php
    }

    /**
     * Display configuration for Echo KB Sidebar
     *
     * @param $kb_config
     * @return string
     */
    private function get_sidebar_location_html( $kb_config ) {

        $form = new WIDG_KB_Config_Elements();
        $feature_specs = WIDG_KB_Config_Specs::get_fields_specification();

        $add_on_config = widg_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_config['id'] );

        ob_start();

        echo  $form->radio_buttons_vertical( array('name' => 'widgets_sidebar_location', 'label' => '') + $feature_specs['widgets_sidebar_location'] + array(
                'current'           => $add_on_config['widgets_sidebar_location'],
                'input_group_class' => 'config-col-12',
                'main_label_class'  => 'config-col-12',
                'input_class'       => '',
                'radio_class'       => 'config-col-12' ) );

        echo '<a href="' . admin_url( 'widgets.php' ) . '" target="_blank">' . esc_html__( 'Configure KB Sidebar', 'echo-widgets' ) . '</a>';

        return ob_get_clean();
    }
	
	/**
	 * Display configuration for Search Preset style options
	 *
	 * @param $kb_config
	 * @return string
	 */
	private function get_search_presets_html( $kb_config ) {

		$form = new WIDG_KB_Config_Elements();
		$feature_specs = WIDG_KB_Config_Specs::get_fields_specification();

		$add_on_config = widg_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_config['id'] );

		ob_start();

		echo  $form->dropdown( array('name' => 'widg_search_preset_styles', 'label' => '') + $feature_specs['widg_search_preset_styles'] + array(
				'current'           => $add_on_config['widg_search_preset_styles'],
				'input_group_class' => 'config-col-12',
				'main_label_class'  => 'config-col-12',
				'input_class'       => '',
				'radio_class'       => 'config-col-12' ) );

		echo '<a href="https://www.echoknowledgebase.com/documentation/search-shortcode/" target="_blank">' . esc_html__( 'View different styles', 'echo-widgets' ) . '</a>';

		return ob_get_clean();
	}

    private function mega_menu_item_custom_html_content( $args = array() ) {

        echo '<div class="' . WIDG_KB_Core::WIDG_KB_MM_LINKS . ' ' . ( empty($args['class']) ? '' : $args['class'] ) . '" id="' . $args['id'] . '-list' . '">';
        foreach( $args['sections'] as $section ) {

            echo '<section>';
            echo '<h3>' . $section['heading'] . '</h3>';

            foreach ( $section['form_elements'] as $html ) {
                echo '<div id="' . $html['id'] . '">';
                echo $html['html'];
                echo '</div>';
            }

            echo '</section>';

        }
        echo '</div>';
    }
}
