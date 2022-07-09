<?php

/**
 * Setup of widgets
 *
 * @copyright   Copyright (c) 2018, Echo Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class WIDG_Widgets {

	public function __construct() {

	    // do not run on KB Configuration page
        if ( isset($_REQUEST['page']) && $_REQUEST['page'] == WIDG_KB_Core::WIDG_KB_CONFIGURATION_PAGE && ! isset($_REQUEST['wizard-search']) && ! isset($_REQUEST['wizard-features']) ) {
            return;
        }

		add_action( 'widgets_init', array($this, 'register_widgets') );

		// prepare for KB Article Page output
		add_action( 'eckb-article-left-sidebar', array($this, 'display_article_left_sidebar'), 20, 2 );
		add_action( 'eckb-article-right-sidebar', array($this, 'display_article_right_sidebar'), 20, 2 );
		add_filter( 'eckb-article-page-container-classes', array($this, 'add_article_sidebar_classes'), 10, 3 );

		// latest KB Core has KB Sidebar included
		if ( class_exists('Echo_Knowledge_Base') && version_compare(Echo_Knowledge_Base::$version, '6.4.0', '<') ) {
			add_action( 'widgets_init', array($this, 'register_kb_sidebar') );
		}
    }

	/**
	 * Display LEFT SIDEBAR on KB Article Pages
	 *
	 * @param $kb_id
	 * @param $kb_config
	 */
    function display_article_left_sidebar( $kb_id, $kb_config=array() ) {
		
		if ( is_array($kb_id) && isset($kb_id['config']) ) {
			$kb_config = $kb_id['config'];
			$kb_id = $kb_config['id'];
		}
		
		// OLD KB Core hook does not send KB Config
		if ( empty($kb_config) ) {
			$kb_config = WIDG_KB_Core::get_kb_config_or_default( $kb_id );
		}
		
    	// old KB Sidebar is incompatible with v2 article structure
    	if ( WIDG_KB_Core::is_article_structure_v2( $kb_config) ) {
    		return;
	    }

        $add_on_config = widg_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
        if ( $add_on_config['widgets_sidebar_location'] != 'left-sidebar' ) {
            return;
        }   ?>

        <div id="eckb-widget-left-sidebar" class="widg-widget-reset widg-widget-defaults">            <?php
            dynamic_sidebar( 'eckb_articles_sidebar' );            ?>
        </div>    <?php
    }

	/**
	 * Display RIGHT SIDEBAR on KB Article Pages
	 *
	 * @param $kb_id
	 * @param $kb_config
	 */
    function display_article_right_sidebar( $kb_id, $kb_config=array() ) {
		
		if ( is_array($kb_id) && isset($kb_id['config']) ) {
			$kb_config = $kb_id['config'];
			$kb_id = $kb_config['id'];
		}
		
		// OLD KB Core hook does not send KB Config
		if ( empty($kb_config) ) {
			$kb_config = WIDG_KB_Core::get_kb_config_or_default( $kb_id );
		}
	    // old KB Sidebar is incompatible with v2 article structure
	    if ( WIDG_KB_Core::is_article_structure_v2( $kb_config) ) {
		    return;
	    }

        $add_on_config = widg_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
        if ( $add_on_config['widgets_sidebar_location'] != 'right-sidebar' ) {
            return;
        }   ?>

        <div id="eckb-widget-right-sidebar" class="widg-widget-reset widg-widget-defaults">            <?php
            dynamic_sidebar( 'eckb_articles_sidebar' );            ?>
        </div>    <?php
	}
	
	/**
	 * If sidebar is on then add sidebar specific class to KB Article Pages
	 *
	 * @param $output
	 * @param $kb_id
	 * @param $kb_config
	 *
	 * @return array
	 */
    function add_article_sidebar_classes( $output, $kb_id, $kb_config=array() ) {

    	if ( empty($kb_config) ) {
    		return $output;
	    }

	    // old KB Sidebar is incompatible with v2 article structure
	    if ( WIDG_KB_Core::is_article_structure_v2( $kb_config) ) {
		    return $output;
	    }

        $add_on_config = widg_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
        if ( $add_on_config['widgets_sidebar_location'] == 'no-sidebar' ) {
            return $output;
        } else if ( $add_on_config['widgets_sidebar_location'] == 'left-sidebar' ) {
            return $output + array('eckb-article-left-sidebar-on');
        } else if ( $add_on_config['widgets_sidebar_location'] == 'right-sidebar' ) {
            return $output + array('eckb-article-right-sidebar-on');
        }

        return $output;
    }

	/**
	 * Register KB widgets
	 */
	public function register_widgets() {
		register_widget( 'WIDG_Recent_Articles_Widget' );
		register_widget( 'WIDG_Category_Articles_Widget' );
		register_widget( 'WIDG_Tag_Articles_Widget' );
		register_widget( 'WIDG_Categories_List_Widget' );
		register_widget( 'WIDG_Tags_List_Widget' );
		register_widget( 'WIDG_Search_Articles_Widget' );
	}

    /**
     * Register KB areas for widgets to be added to
     */
	public function register_kb_sidebar() {

	    // add KB sidebar area
        register_sidebar( array(
            'name'          => __('Echo KB Articles Sidebar', 'echo-knowledge-base'),
            'id'            => 'eckb_articles_sidebar',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ) );
    }
}
