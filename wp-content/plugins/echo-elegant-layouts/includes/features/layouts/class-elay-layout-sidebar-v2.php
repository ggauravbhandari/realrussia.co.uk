<?php

/**
 *  Outputs the Sidebar Layout for knowledge base - both Main Page (Sidebar Layout) and Article Page (Sidebar layout).
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ELAY_Layout_Sidebar_v2 extends ELAY_Layout {

	private $article_content = '';
	private $displayed_article_ids = array();

	public function __construct() {
		add_action( 'eckb-article-v2-search-box', array($this, 'generate_search_box_V2') );
		add_action( 'eckb-article-v2-elay_sidebar', array($this, 'generate_sidebar_V2') );
		add_filter( 'eckb_main_page_sidebar_intro_text', array($this, 'get_main_page_sidebar_intro_text'), 10, 2 );
	}

	/**
	 * Display Search form
	 * @param $args
	 */
	public function generate_search_box_V2( $args ) {
		$this->article_content = null;
		$this->display_kb_page( $args['config'] ); // only sets variables
		$this->get_search_form();
	}

	/**
	 * Display ELAY sidebar
	 *
	 * @param $args
	 */
	public function generate_sidebar_V2( $args ) {

		$this->sidebar_loaded = true;

		// setup demo data if needed
		$is_builder_on = false;
		$article_seq = array();
		$categories_seq = array();
		if ( ! empty($GLOBALS['epkb-articles-seq-data']) && ! empty($GLOBALS['epkb-categories-seq-data']) ) {
			$is_builder_on = true;
			$article_seq = $GLOBALS['epkb-articles-seq-data'];
			$categories_seq = $GLOBALS['epkb-categories-seq-data'];
		}
		
		if ( ! empty($_REQUEST['action']) && $_REQUEST['action'] == 'epkb_wizard_update_order_view' ) {
			$is_builder_on = true;
		}
		
		if ( ELAY_Utilities::post('epkb-wizard-demo-data', false, false) ) {
			$is_builder_on = true;
			$demo_data = ELAY_KB_Core::get_category_demo_data( 'Sidebar', $this->kb_config );
			$categories_seq = $demo_data['category_seq'];
			$article_seq = $demo_data['article_seq'];
		}
		
		$this->display_kb_page( $args['config'], $is_builder_on, $article_seq, $categories_seq ); // only sets variables
		$this->display_sidebar_V2();
	}

	public function generate_sidebar_CSS_V2( $kb_config ) {

		// Container
		$container_background_Color     = $kb_config['sidebar_background_color'];
		$container_border_Color         = $kb_config['sidebar_section_border_color'];
		$container_border_Width         = $kb_config['sidebar_section_border_width'];
		$container_border_Radius        = $kb_config['sidebar_section_border_radius'];
		$sidebar_side_bar_height        = $kb_config['sidebar_side_bar_height'];

		// Category Heading
		$catHeading_alignment           = $kb_config['sidebar_section_head_alignment'];
		$catHeading_dividerThickness    = $kb_config['sidebar_section_divider_thickness'];
		$catHeading_paddingTop          = $kb_config['sidebar_section_head_padding_top'];
		$catHeading_paddingBottom       = $kb_config['sidebar_section_head_padding_bottom'];
		$catHeading_paddingLeft         = $kb_config['sidebar_section_head_padding_left'];
		$catHeading_paddingRight        = $kb_config['sidebar_section_head_padding_right'];
		$catHeading_dividerColor        = $kb_config['sidebar_section_divider_color'];
		$catHeading_BackgroundColor     = $kb_config['sidebar_section_head_background_color'];

		// Category Heading - Inner
		$catHeadingInner_fontColor      = $kb_config['sidebar_section_head_font_color'];
		$catHeadingInner_TextAlignment  = $kb_config['sidebar_section_head_alignment'];
		$catHeadingInner_DescColor      = $kb_config['sidebar_section_head_description_font_color'];

		// Category Body
		$catBodyContainer_paddingTop    = $kb_config['sidebar_section_body_padding_top'];
		$catBodyContainer_paddingBottom = $kb_config['sidebar_section_body_padding_bottom'];
		$catBodyContainer_paddingLeft   = $kb_config['sidebar_section_body_padding_left'];
		$catBodyContainer_paddingRight  = $kb_config['sidebar_section_body_padding_right'];

		$catBodyContainer_BodyHeight    = $kb_config['sidebar_section_body_height'];

		// Article
		$article_Font_color             = $kb_config['sidebar_article_font_color'];
		$article_Font_Active_color      = $kb_config['sidebar_article_active_font_color'];
		$article_Font_BackgroundColor   = $kb_config['sidebar_article_active_background_color'];

		// Category Main Category

		// Category Sub Category
		$catBodySubCatArticleMargin     = $kb_config['sidebar_article_list_margin'];		
		
		// Theme class for the themes wizard 

		?>
		<style>

			/* Container */
			#elay-sidebar-container-v2 {
				background-color:   <?php echo $container_background_Color.';' .PHP_EOL; ?>
				border-color:       <?php echo $container_border_Color.';' .PHP_EOL; ?>
				border-width:       <?php echo $container_border_Width.'px;' .PHP_EOL; ?>
				border-radius:      <?php echo $container_border_Radius.'px;' .PHP_EOL; ?>
				<?php if ( $this->kb_config['sidebar_side_bar_height_mode'] == 'side_bar_fixed_height' ) { ?>
				overflow:       auto;
				max-height:     <?php echo $sidebar_side_bar_height.'px;' .PHP_EOL; ?>
				<?php } ?>
			}

			/* Category Heading */
			#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container {
				text-align:                 <?php echo $catHeading_alignment.';' .PHP_EOL; ?>
				border-width:               <?php echo $catHeading_dividerThickness.'px;' .PHP_EOL; ?>
				padding-top:                <?php echo $catHeading_paddingTop.'px;' .PHP_EOL; ?>
				padding-bottom:             <?php echo $catHeading_paddingBottom.'px;' .PHP_EOL; ?>
				padding-left:               <?php echo $catHeading_paddingLeft.'px;' .PHP_EOL; ?>
				padding-right:              <?php echo $catHeading_paddingRight.'px;' .PHP_EOL; ?>
				border-bottom-color:        <?php echo $catHeading_dividerColor.';' .PHP_EOL; ?>
				background-color:           <?php echo $catHeading_BackgroundColor.';' .PHP_EOL; ?>
			}			<?php
			
			if ( $catHeading_alignment == 'right' ) { ?>
				#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container .elay-sidebar__heading__inner__name {
					flex-direction: row-reverse;
				}
				.elay_sidebar_expand_category_icon {
					padding-left: 5px !important;
					padding-right: 0px !important;
				}			<?php 
			} else if( $catHeading_alignment == 'center' ) { ?>
				#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container .elay-sidebar__heading__inner__name {
					justify-content: center;
				}			<?php 
			} ?>

			/* First Category Heading */
			#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat:first-child .elay-sidebar__cat__top-cat__heading-container {
				border-top-left-radius:     <?php echo $container_border_Radius.'px;' .PHP_EOL; ?>
				border-top-right-radius:    <?php echo $container_border_Radius.'px;' .PHP_EOL; ?>
			}
			/* Last Category Heading */
			#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat:last-child .elay-sidebar__cat__top-cat__heading-container {
				border-bottom-left-radius:     <?php echo $container_border_Radius.'px;' .PHP_EOL; ?>
				border-bottom-right-radius:    <?php echo $container_border_Radius.'px;' .PHP_EOL; ?>
			}

			#elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name,
			#elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__cat-name,
			#elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name>a {
				color:                  <?php echo $catHeadingInner_fontColor.';' .PHP_EOL; ?>
				text-align:             <?php echo $catHeadingInner_TextAlignment.';' .PHP_EOL; ?>
			}
			#elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__desc p {
				color:                  <?php echo $catHeadingInner_DescColor.';' .PHP_EOL; ?>
				text-align:             <?php echo $catHeadingInner_TextAlignment.';' .PHP_EOL; ?>
			}

			/* Category Body */
			#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__body-container {
				padding-top:            <?php echo $catBodyContainer_paddingTop.'px;' .PHP_EOL; ?>
				padding-bottom:         <?php echo $catBodyContainer_paddingBottom.'px;' .PHP_EOL; ?>
				padding-left:           <?php echo $catBodyContainer_paddingLeft.'px;' .PHP_EOL; ?>
				padding-right:          <?php echo $catBodyContainer_paddingRight.'px;' .PHP_EOL;

				if ( $this->kb_config['sidebar_section_box_height_mode'] == 'section_min_height' ) { ?>
					min-height:             <?php echo $catBodyContainer_BodyHeight.';' .PHP_EOL;
				} else if ( $this->kb_config['sidebar_section_box_height_mode'] == 'section_fixed_height' ) { ?>
					overflow: auto;
					height:             <?php echo $catBodyContainer_BodyHeight.';' .PHP_EOL;
				}	?>

			}

			/* Category Main Category */
			#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__body-container .elay-sidebar__body__main-cat {}

			/* Category Sub Category */
			#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__body-container .elay-sidebar__body__sub-cat {
				padding-left:           <?php echo $catBodySubCatArticleMargin.'px;' .PHP_EOL; ?>
			}

			/* Article */
			.elay-sidebar__cat__top-cat__body-container .elay-articles .elay-article-title {
				color:                      <?php echo $article_Font_color.';' .PHP_EOL; ?>
			}
			.elay-sidebar__cat__top-cat__body-container .elay-articles .active {
				 color:                      <?php echo $article_Font_Active_color.';' .PHP_EOL; ?>
				 background-color:           <?php echo $article_Font_BackgroundColor.';' .PHP_EOL; ?>
			}
			.elay-sidebar__cat__top-cat__body-container .elay-articles .active .elay-article-title {
				color:                      <?php echo $article_Font_Active_color.';' .PHP_EOL; ?>
			}



		</style>		<?php
	}

	/** @noinspection PhpUnusedParameterInspection */
	public function get_main_page_sidebar_intro_text( $content, $kb_id ) {
		return elay_get_instance()->kb_config_obj->get_value( $kb_id, 'sidebar_main_page_intro_text', '' );
	}

	/**
	 * Filter categories and articles based on authorization
	 */
	private function control_access() {
		if ( class_exists('AMGR_Access_Utilities', false) ) {
			$kb_groups_set = AMGR_Access_Utilities::get_main_page_group_sets( $this->kb_id, $this->category_seq_data, $this->articles_seq_data );
			if ( $kb_groups_set === null || ( empty($kb_groups_set['categories_seq_data']) && empty($kb_groups_set['articles_seq_data']) ) ) {
				echo AMGR_Access_Reject::reject_user_access( $this->kb_id );
				return;
			}

			$this->category_seq_data = $kb_groups_set['categories_seq_data'];
			$this->articles_seq_data = $kb_groups_set['articles_seq_data'];
		}
	}

	/**
	 * DISPLAY SIDEBAR
	 * For each CATEGORY display: a) its articles and b) top-level SUB-CATEGORIES with its articles
	 */
	private function display_sidebar_V2() {

		// Show message that KB is under construction if there is no any article with category
		if ( ! $this->has_categorized_article() ) {
			$this->under_construction_message();
			return;
		}

		// protect Sidebar
		$this->control_access();

		// Reformat Class Names
		$boxShadow      = '';
		$slimScrollbar  = '';

		if ( ! empty($this->kb_config['sidebar_section_box_shadow'] ) ) {
			switch ($this->kb_config['sidebar_section_box_shadow']) {
				case 'section_light_shadow':
					$boxShadow = 'elay-sidebar--light-shadow';
					break;
				case 'section_medium_shadow':
					$boxShadow = 'elay-sidebar--medium-shadow';
					break;
				case 'section_bottom_shadow':
					$boxShadow = 'elay-sidebar--bottom-shadow';
					break;
			}
		}

		if ( ! empty($this->kb_config['sidebar_scroll_bar'] ) ) {
			switch ($this->kb_config['sidebar_scroll_bar']) {
				case 'slim_scrollbar':
					$slimScrollbar = 'elay-sidebar--slim-scrollbar';
					break;
				case 'default_scrollbar':
					$slimScrollbar = '';
					break;
			}
		}



		$sidebar_top_categories_collapsed_Class = '';
		$sidebar_top_categories_collapsed = $this->kb_config['sidebar_top_categories_collapsed'];
		if ( $sidebar_top_categories_collapsed == 'on' ) {
			$sidebar_top_categories_collapsed_Class = 'elay-sidebar--TopCat-on';
		}
		
		
		$this->generate_sidebar_CSS_V2( $this->kb_config );		?>

		<section id="elay-sidebar-container-v2" class="elay-sidebar--reset <?php echo $boxShadow . ' ' . $slimScrollbar . ' ' . $sidebar_top_categories_collapsed_Class . ' ';?>">

			<ul class="elay-sidebar__cat-container">  			<?php

				/** DISPLAY TOP CATEGORIES and ARTICLES */
				$section_count = 0;
				$this->displayed_article_ids = array();

				foreach ( $this->category_seq_data as $category_id => $subcategories ) {   ?>

					<li id="elay-top-cat-id-<?php echo $category_id;?> " class="elay-sidebar__cat__top-cat"> 				<?php
						$this->display_section_heading_V2( $category_id );
						$this->display_section_body_V2( $subcategories, $category_id ); 			?>
					</li>  				<?php
					$section_count++;

				}  	?>

			</ul>

		</section>   		<?php
	}

	private function display_section_heading_V2( $category_id ) {

		$section_divider = $this->kb_config['sidebar_section_divider'] == 'on' ? ' sidebar_section_divider' : '' ;

		$category_name = isset($this->articles_seq_data[$category_id][0]) ? $this->articles_seq_data[$category_id][0] : 'Uncategorized';
		$category_desc = isset($this->articles_seq_data[$category_id][1]) && $this->kb_config['sidebar_section_desc_text_on'] == 'on' ? $this->articles_seq_data[$category_id][1] : '';
		$box_category_data = $this->is_builder_on ? 'data-kb-category-id=' . $category_id . ' data-kb-type=category ' : '';

		$class1 = $this->get_css_class( '::sidebar_expand_articles_icon, elay_sidebar_expand_category_icon' );

		$sidebar_top_categories_collapsed = $this->kb_config['sidebar_top_categories_collapsed'];

		$topClassCollapse = $this->kb_config['sidebar_top_categories_collapsed'] == 'on' ? ' elay-top-class-collapse-on' : '';

		$categoryIcon = '';


		$top_category_style = $this->get_inline_style(
			'typography:: sidebar_section_category_typography'
		);
		$top_category_desc_style = $this->get_inline_style(
			'typography:: sidebar_section_category_typography_desc'
		);

		if ( $sidebar_top_categories_collapsed == 'on' ) {
			$categoryIcon = '<span '.$class1.'></span>';
		}			?>

		<div class="elay-sidebar__cat__top-cat__heading-container <?php echo $topClassCollapse.' '.$section_divider; ?>">
			<div class="elay-sidebar__heading__inner" <?php echo $box_category_data; ?>>

				<!-- CATEGORY ICON -->
				<div class="elay-sidebar__heading__inner__name">
					<?php echo $categoryIcon; ?>
					<h2 class="elay-sidebar__heading__inner__cat-name" <?php echo $top_category_style; ?>><?php echo $category_name; ?></h2>
				</div>


				<!-- CATEGORY DESC -->				<?php
				if ( $category_desc ) { ?>
					<div class="elay-sidebar__heading__inner__desc">
						<p <?php echo $top_category_desc_style; ?>><?php echo $category_desc; ?></p>
					</div>
					<?php
				}			?>
			</div>
		</div>		<?php
	}

	private function display_section_body_V2( $subcategories, $category_id ) {
		$top_category_body_style = $this->get_inline_style(
			'typography:: sidebar_section_body_typography'
		);		?>

		<div class="elay-sidebar__cat__top-cat__body-container" <?php echo $top_category_body_style; ?>>  <?php

			$sub_category_list = is_array($subcategories) ? $subcategories : array();

			/** DISPLAY TOP-CATEGORY ARTICLES LIST */
			if (  $this->kb_config['sidebar_show_articles_before_categories'] != 'off' ) {
				$this->display_articles_list( 1, $category_id, ! empty($sub_category_list) );
			}

			if ( $sub_category_list ) {     ?>
				<ul class="elay-sidebar__body__sub-cat eckb-sub-category-ordering"><?php

					/** DISPLAY SUB-CATEGORIES */
					foreach ( $sub_category_list as $sub_category_id => $sub_sub_categories ) {
						$sub_category_name = isset($this->articles_seq_data[$sub_category_id][0]) ?
							$this->articles_seq_data[$sub_category_id][0] : 'Category.';

						$class1 = $this->get_css_class( '::sidebar_expand_articles_icon, elay_sidebar_expand_category_icon' );
						$style1 = $this->get_inline_style( 'color:: sidebar_section_category_icon_color' );
						$style2 = $this->get_inline_style( 'color:: sidebar_section_category_font_color,typography:: sidebar_section_subcategory_typography, display:inline-block' );

						$box_sub_category_data = $this->is_builder_on ? 'data-kb-category-id=' . $sub_category_id  . ' data-kb-type=sub-category ' : '';  	?>

						<li>
							<div class="elay-category-level-2-3" <?php echo $this->get_inline_style( 'padding-bottom:: sidebar_article_list_spacing,padding-top::sidebar_article_list_spacing' ); ?><?php echo $box_sub_category_data; ?>>
								<span <?php echo $class1 . ' ' . $style1; ?> ></span>
								<a class="elay-category-level-2-3__cat-name" ><h3 <?php echo $style2; ?>><?php echo $sub_category_name; ?></h3></a>
							</div>    <?php

							/** DISPLAY SUB-CATEGORY ARTICLES LIST */
							if (  $this->kb_config['sidebar_show_articles_before_categories'] != 'off' ) {
								$this->display_articles_list( 2, $sub_category_id, ! empty($sub_sub_categories) );
							}

							$this->display_sub_sub_categories( $sub_sub_categories );

							/** DISPLAY SUB-CATEGORY ARTICLES LIST */
							if (  $this->kb_config['sidebar_show_articles_before_categories'] == 'off' ) {
								$this->display_articles_list( 2, $sub_category_id, ! empty( $sub_sub_categories ) );
							}               ?>
						</li>   	<?php

					}  //foreach  ?>

				</ul>			<?php
			}

			/** DISPLAY TOP-CATEGORY ARTICLES LIST */
			if (  $this->kb_config['sidebar_show_articles_before_categories'] == 'off' ) {
				$this->display_articles_list( 1, $category_id, ! empty($sub_category_list) );
			}   ?>
		</div>  	<?php
	}

	private function display_sub_sub_categories( $sub_sub_categories, $level = 'sub-', $levelNum = 4 ) {

		$level .= 'sub-';

		$sub_category_styles =  'padding-left::   sidebar_article_list_margin';

		$sub_category_list = is_array($sub_sub_categories) ? $sub_sub_categories : array();
		if ( $sub_category_list ) {     ?>
			<ul class="elay-sub-sub-category eckb-sub-sub-category-ordering" <?php echo $this->get_inline_style( $sub_category_styles ); ?>>   					<?php

				/** DISPLAY SUB-SUB-CATEGORIES */
				foreach ( $sub_category_list as $sub_sub_category_id => $sub_sub_category_list ) {
					$sub_category_name = isset($this->articles_seq_data[$sub_sub_category_id][0]) ?
												$this->articles_seq_data[$sub_sub_category_id][0] : 'Category.';

					$class1 = $this->get_css_class( '::sidebar_expand_articles_icon, elay_sidebar_expand_category_icon' );
					$style1 = $this->get_inline_style( 'color:: sidebar_section_category_icon_color' );
					$style2 = $this->get_inline_style( 'color:: sidebar_section_category_font_color' );

					$box_sub_category_data = $this->is_builder_on ? 'data-kb-category-id=' . $sub_sub_category_id  . ' data-kb-type='.$level.'category ' : '';  	?>

					<li>
						<div class="elay-category-level-2-3" <?php echo $this->get_inline_style( 'padding-bottom:: sidebar_article_list_spacing, padding-top::sidebar_article_list_spacing' ); ?> <?php echo $box_sub_category_data; ?>>
							<span <?php echo $class1 . ' ' . $style1; ?> ></span>
							<a class="elay-category-level-2-3__cat-name" <?php echo $style2; ?> >
								<h<?php echo $levelNum; ?>><?php echo $sub_category_name; ?></h<?php echo $levelNum; ?> >
							</a>
						</div>    <?php
						
						/** DISPLAY SUB-SUB-CATEGORY ARTICLES LIST */
						if (  $this->kb_config['sidebar_show_articles_before_categories'] != 'off' ) {
							$this->display_articles_list( 3, $sub_sub_category_id, ! empty($sub_sub_category_list), $level );
						}
						
						/** RECURSION DISPLAY SUB-SUB-...-CATEGORIES */
						if ( ! empty($sub_sub_category_list) && strlen($level) < 20 ) {
							$levelNum++;
							$this->display_sub_sub_categories( $sub_sub_category_list, $level, $levelNum );
						}
						
						/** DISPLAY SUB-SUB-CATEGORY ARTICLES LIST */
						if (  $this->kb_config['sidebar_show_articles_before_categories'] == 'off' ) {
							$this->display_articles_list( 3, $sub_sub_category_id, ! empty($sub_sub_category_list), $level );
						}   ?>
					</li>   	<?php

				}  //foreach  			?>

			</ul>			<?php
		}
	}

	/**
	 * Display list of articles that belong to given subcategory
	 *
	 * @param $level
	 * @param $category_id
	 * @param bool $sub_category_exists - if true then we don't want to show "Articles coming soon" if there are no articles because
	 *                                   we have at least categories listed. But sub-category should always have that message if no article present
	 * @param string $sub_sub_string
	 */
	private function display_articles_list( $level, $category_id, $sub_category_exists=false, $sub_sub_string = '' ) {

		// retrieve articles belonging to given (sub) category if any
		$articles_list = array();
		if ( isset($this->articles_seq_data[$category_id]) ) {
			$articles_list = $this->articles_seq_data[$category_id];
			unset($articles_list[0]);
			unset($articles_list[1]);
		}

		// return if we have no articles and will not show 'Articles coming soon' message
		$articles_coming_soon_msg = $this->kb_config['sidebar_category_empty_msg'];
		if ( empty($articles_list) && ( $sub_category_exists || empty($articles_coming_soon_msg) ) ) {
			return;
		}

		$sub_category_styles = '';
		if ( $level == 1 ) {
			$data_kb_type = 'article';
			$sub_category_styles .= is_rtl() ? 'padding-right:: sidebar_article_list_margin,' : 'padding-left:: sidebar_article_list_margin,';
		} else if ( $level == 2 ) {
			$sub_category_styles .= is_rtl() ? 'padding-right:: sidebar_article_list_margin,' : 'padding-left:: sidebar_article_list_margin,';
			$data_kb_type = 'sub-article';
		} else {
			$sub_category_styles .=  is_rtl() ? 'padding-right:: sidebar_article_list_margin,' : 'padding-left:: sidebar_article_list_margin';
			$data_kb_type = empty($sub_sub_string) ? 'sub-sub-article' : $sub_sub_string . 'article';
		}

        $class = 'class="' . ( $level == 1 ? 'elay-sidebar__body__main-cat ' : '' ) . 'elay-articles eckb-articles-ordering"'; 	?>

		<ul <?php echo $class . ' ' . $this->get_inline_style( $sub_category_styles ); ?>> <?php

			if ( empty($articles_list) ) {
				echo '<li '.$this->get_inline_style( 'padding-bottom:: sidebar_article_list_spacing,padding-top::sidebar_article_list_spacing' ) . 'class="elay-articles-coming-soon">' .
                            esc_html__( $articles_coming_soon_msg, 'echo-elegant-layouts' ) . '</li>';
			}

			$article_num = 0;
			$article_data = '';

			$nof_articles_displayed = isset($_GET['wizard-on']) ? 9999 : $this->kb_config['sidebar_nof_articles_displayed'];

			// show list of articles in this category
			foreach ( $articles_list as $article_id => $article_title ) {
				$article_num++;
				$this->displayed_article_ids[$article_id] = isset($this->displayed_article_ids[$article_id]) ? $this->displayed_article_ids[$article_id] + 1 : 1;
				$seq_no = $this->displayed_article_ids[$article_id];
				$hide_class = $article_num > $nof_articles_displayed ? 'elay-hide-elem' : '';
				$style2 = 'id="sidebar_link_' . $article_id . ( $seq_no > 1 ? '_' . $seq_no : '' ) . '"';
				if ( $this->is_builder_on ) {
					$article_data = $this->is_builder_on ? 'data-kb-article-id=' . $article_id . ' data-kb-type=' . $data_kb_type : '';
				}

				/** DISPLAY ARTICLE LINK */      ?>
				<li class="<?php echo $hide_class; ?>" <?php echo $article_data . ' ' . $style2 . ' ' . $this->get_inline_style( 'padding-bottom:: sidebar_article_list_spacing,padding-top::sidebar_article_list_spacing' ); ?> >   <?php
					$article_link_data = 'class="elay-sidebar-article" ' . 'data-kb-article-id=' . $article_id;
                    $this->single_article_link( $article_title, $article_id, $article_link_data, 'sidebar_', $seq_no ); ?>
				</li> <?php
			}

			// if article list is longer than initial article list size then show expand/collapse message
			if ( count($articles_list) > $nof_articles_displayed ) {	?>
				<li class="elay-show-all-articles">
					<span class="elay-show-text">
						<span><?php echo esc_html__( $this->kb_config['sidebar_show_all_articles_msg'], 'echo-elegant-layouts' ) . '</span> ( ' . ( count( $articles_list ) - $nof_articles_displayed ); ?> )
					</span>
					<span class="elay-hide-text elay-hide-elem"><?php esc_html_e( $this->kb_config['sidebar_collapse_articles_msg'], 'echo-elegant-layouts' ); ?></span>
				</li>					<?php
			}  ?>

		</ul> <?php
	}

}
