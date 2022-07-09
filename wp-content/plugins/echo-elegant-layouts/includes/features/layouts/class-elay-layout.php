<?php

/**
 *
 * BASE THEME class that every theme should extend
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
abstract class ELAY_Layout {

	protected $kb_config;
	protected $kb_id;
	protected $category_seq_data;
	protected $articles_seq_data;
	protected $is_builder_on = false;
	protected $sidebar_loaded = false;
	protected $active_theme = 'unknown';

	/**
	 * Show the KB Main page with list of categories and articles
	 *
	 * @param $kb_config
	 * @param bool $is_builder_on
	 * @param array $article_seq
	 * @param array $categories_seq
	 */
	public function display_kb_page( $kb_config, $is_builder_on=false, $article_seq=array(), $categories_seq=array() ) {

		// add configuration that is specific to Elegant Layouts
		$add_on_config = elay_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_config['id'] );
		$kb_config = array_merge( $add_on_config, $kb_config );

		$this->kb_config = $kb_config;
		$this->kb_id = $kb_config['id'];

		// category and article sequence
		if ( $is_builder_on && ! empty($article_seq) && ! empty($categories_seq) ) {
			$this->articles_seq_data = $article_seq;
			$this->category_seq_data = $categories_seq;
		} else {
			$this->category_seq_data = ELAY_Utilities::get_kb_option( $this->kb_id, ELAY_KB_Core::ELAY_CATEGORIES_SEQUENCE, array(), true );
			$this->articles_seq_data = ELAY_Utilities::get_kb_option( $this->kb_id, ELAY_KB_Core::ELAY_ARTICLES_SEQUENCE, array(), true );
		}

		// for WPML filter categories and articles given active language
		if ( ELAY_Utilities::is_wpml_enabled( $kb_config ) && ! ELAY_Utilities::post('epkb-wizard-demo-data', false, false)) {
			$this->category_seq_data = ELAY_KB_Core::apply_category_language_filter( $this->category_seq_data );
			$this->articles_seq_data = ELAY_KB_Core::apply_article_language_filter( $this->articles_seq_data );
		}

		// articles with no categories - temporary add one
		if ( isset($this->articles_seq_data[0]) ) {
			$this->category_seq_data[0] = array();
		}
		// add theme name to Div for specific targeting
		$this->active_theme = 'active_theme_' . ELAY_Utilities::get_wp_option( 'stylesheet', 'unknown' );

		$this->is_builder_on = $is_builder_on;
	}

	/**
	 * Display a link to a KB article.
	 *
	 * @param $title
	 * @param $article_id
	 * @param string $link_other
	 * @param string $prefix
	 * @param string $seq_no
	 */
	public function single_article_link( $title , $article_id, $link_other='', $prefix='', $seq_no='' ) {

		if ( empty($article_id) ) {
			return;
		}

		$class1 = $this->get_css_class( 'elay-article-title' .
                ( $this->kb_config['sidebar_article_underline'] == 'on' ? ', article_underline_effect' : '' ).
                ( $this->kb_config['sidebar_article_active_bold'] == 'on' ? ', article_active_bold' : '' )
        );
		$style1 = $this->get_inline_style( 'color:: ' . $prefix . 'article_font_color' );
		$style2 = $this->get_inline_style( 'color:: ' . $prefix . 'article_icon_color' );

		// handle any add-on content
		if ( has_filter( 'eckb_single_article_filter' ) ) {
			$result = apply_filters('eckb_single_article_filter', $article_id, array( $this->kb_id, $title, $class1, $style1, $style2 ) );
			if ( ! empty($result) && $result === true ) {
				return;
			}
		}

		$link = get_permalink( $article_id );
		$link = empty($seq_no) || $seq_no < 2 ? $link : add_query_arg( 'seq_no', $seq_no, $link );
		$link = empty($link) || is_wp_error( $link ) ? '' : $link;  ?>

		<a href="<?php echo esc_url( $link ); ?>" <?php echo $link_other; ?>>
			<span <?php echo $class1 ; ?> >
				<span class="elay-article-title__icon ep_font_icon_document" <?php echo $style2; ?>></span>
				<span class="elay-article-title__text"><?php echo esc_html( $title ); ?></span>
			</span>
		</a> <?php
	}

	/**
	 * Display a search form for ELEGANT LAYOUTS only  (MAIN or ARTICLE page)
	 */
	public function get_search_form() {

		// 1. use KB search box if available
		if ( class_exists('Echo_Knowledge_Base') && version_compare(Echo_Knowledge_Base::$version, '7.0.0', '>=') ) {
			ELAY_KB_Core::get_search_form( $this->kb_config );
			return;
		}

		// 2. use Advanced Serch box if available
		if ( ELAY_Utilities::is_advanced_search_enabled( $this->kb_config ) ) {
			do_action( 'eckb_advanced_search_box', $this->kb_config );
			return;
		}

		// 3. otherwise use old ELAY search box
		$prefix = ( $this instanceof ELAY_Layout_Sidebar || $this instanceof ELAY_Layout_Sidebar_v2 ) ? 'sidebar_' : 'grid_';

		// no search box configured or required
		if ( $this->kb_config[$prefix . 'search_layout'] == 'elay-search-form-0' ) {
			return;
		}

		$style1 = $this->get_inline_style(
			'background-color:: ' . $prefix . 'search_background_color,
			 padding-top:: ' . $prefix . 'search_box_padding_top,
			 padding-right:: ' . $prefix . 'search_box_padding_right,
			 padding-bottom:: ' . $prefix . 'search_box_padding_bottom,
			 padding-left:: ' . $prefix . 'search_box_padding_left,
			 margin-top:: ' . $prefix . 'search_box_margin_top,
			 margin-bottom:: ' . $prefix . 'search_box_margin_bottom,
			 ');

		$style2 = $this->get_inline_style(
			'background-color:: ' . $prefix . 'search_btn_background_color,
			 background:: ' . $prefix . 'search_btn_background_color, 
			 border-width:: ' . $prefix . 'search_input_border_width,
			 border-color:: ' . $prefix . 'search_btn_border_color'
			 );
		$style3 = $this->get_inline_style( 'color:: ' . $prefix . 'search_title_font_color');
		$style4 = $this->get_inline_style( 'border-width:: ' . $prefix . 'search_input_border_width, border-color:: ' . $prefix . 'search_text_input_border_color,
											background-color:: ' . $prefix . 'search_text_input_background_color, background:: ' . $prefix . 'search_text_input_background_color' );
		$class1 = $this->get_css_class( 'elay-search, :: ' . $prefix . 'search_layout' );

		$search_title_tag = empty($this->kb_config['search_title_html_tag']) ? 'div' : $this->kb_config['search_title_html_tag'];
		$search_input_width = $this->kb_config[$prefix . 'search_box_input_width'];
		$form_style = $this->get_inline_style('width:'. $search_input_width . '%' );

		$class2 = 'elay-doc-search-container';

		if ( ! empty($this->kb_config[$prefix . 'search_box_collapse_mode']) &&  $this->kb_config[$prefix . 'search_box_collapse_mode'] == 'on' ) {
			$class2 .= ' elay-doc-search-container--openned';
		}	?>

		<div class="<?php echo $class2; ?>" <?php echo $style1; ?>>

			<<?php echo $search_title_tag; ?> class="elay-doc-search-title" <?php echo $style3; ?> > <?php echo esc_html( $this->kb_config[$prefix . 'search_title'] ); ?></<?php echo $search_title_tag; ?>>
			<form id="elay_search_form" <?php echo $form_style . ' ' . $class1; ?> method="get" action="">

				<div class="elay-search-box">
					<input type="text" <?php echo $style4; ?> id="elay_search_terms" aria-label="<?php echo esc_attr( $this->kb_config['search_box_hint'] ); ?>" name="elay_search_terms" value="" placeholder="<?php echo esc_attr( $this->kb_config[$prefix . 'search_box_hint'] ); ?>" />
					<input type="hidden" id="elay_kb_id" value="<?php echo $this->kb_id; ?>"/>
					<div class="elay-search-box-button-wrap">
						<button type="submit" id="<?php echo str_replace('_', '-', $prefix); ?>elay-search-kb" <?php echo $style2; ?>><?php  echo esc_html( $this->kb_config[$prefix . 'search_button_name'] ); ?> </button>
					</div>
					<div class="loading-spinner"></div>
				</div>
				<div id="elay_search_results"></div>

			</form>

		</div> <?php

		if ( ! empty($this->kb_config[$prefix . 'search_box_collapse_mode']) &&  $this->kb_config[$prefix . 'search_box_collapse_mode'] == 'on' ) {
			return;
		} ?>

		<div class="elay-search-toggle">
			<span class="ep_font_icon_search"></span>
		</div>		<?php
	}

	/**
	 * Output inline CSS style based on configuration.
	 *
	 * @param string $styles  A list of Configuration Setting styles
	 * @return string
	 */
	public function get_inline_style( $styles ) {
		return ELAY_Utilities::get_inline_style( $styles, $this->kb_config );
	}

	/**
	 * Output CSS classes based on configuration.
	 *
	 * @param $classes
	 * @return string
	 */
	public function get_css_class( $classes ) {
		return ELAY_Utilities::get_css_class( $classes, $this->kb_config );
	}

	/**
	 * Retrieve category icons.
	 * @return array|string|null
	 */
	protected function get_category_icons( ) {

		if ( ELAY_Utilities::post('ep'.'kb-wizard-demo-data', false, false) ) {
			$demo_data = ELAY_KB_Core::get_category_demo_data( 'Grid', $this->kb_config );
			return $demo_data['category_icons'];
		}

		if ( ELAY_Utilities::get( 'ep'.'kb-editor' ) == '1' && isset($this->kb_config['theme_presets']) && $this->kb_config['theme_presets'] !== 'current' ) {
			$category_icons = ELAY_KB_Core::get_demo_category_icons( $this->kb_config, $this->kb_config['theme_presets'] );
			if ( ! empty($category_icons) ) {
				return $category_icons;
			}
		}

		return ELAY_Utilities::get_kb_option( $this->kb_config['id'], ELAY_KB_Core::ELAY_CATEGORIES_ICONS, array(), true );
	}

	/**
	 * Detect whether the current KB has any article with category
	 *
	 * @return bool
	 */
	protected function has_categorized_article() {
		if ( ! is_array( $this->articles_seq_data ) ) {
			return false;
		}

		foreach ( $this->articles_seq_data as $data ) {
			if ( count( $data ) > 2 ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Show message that KB is under construction
	 */
	protected function under_construction_message() {   ?>
		<section style="padding:25px 0;">
			<h2 style="text-align:center;"><?php _e( 'This knowledge base is under construction.', 'echo-knowledge-base' ); ?></h2>
		</section>      <?php
	}
}