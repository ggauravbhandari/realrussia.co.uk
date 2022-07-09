<?php
/*
 * Add my new menu to the Admin Control Panel
 */
// Hook the 'admin_menu' action hook, run the function named 'ch_Add_My_Admin_Link()'
add_action( 'admin_menu', 'ch_Add_My_Admin_Link' );
// Add a new top level menu link to the ACP
function ch_Add_My_Admin_Link()
{
  add_menu_page('search-tour', 'Search Tour', 'manage_options', 'search-tour', 'viewFile' );
  add_submenu_page( 'search-tour', 'Tour Carousel', 'Tour Carousel', 'manage_options', 'tour-carousel', 'tourCardView');
  add_submenu_page( 'search-tour', 'Feature Tour Plugin','Feature Tour Plugin', 'manage_options', 'feature-tour-plugin', 'featureTourPluginView');
 
}

function viewFile()
{
  require_once plugin_dir_path(__FILE__).'custom-header.php';
}

function ch_assets() {
    wp_register_style('ch_assets', plugins_url('../assets/css/jquery.multiselect.css',__FILE__ ));
    wp_enqueue_style('ch_assets');
    wp_register_style('jQueryRangePikercss', 'https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css');
    wp_enqueue_style('jQueryRangePikercss');
    wp_register_style('dataTablecss', 'https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css');
    wp_enqueue_style('dataTablecss');
    wp_enqueue_script( 'ch_assets', plugins_url('../assets/js/jquery.min.js', __FILE__ ));
    wp_enqueue_script('ch_assets');
    wp_register_script( 'ch_assets1', plugins_url('../assets/js/jquery.multiselect.js',__FILE__ ));
    wp_enqueue_script('ch_assets1');
    wp_register_script( 'jQueryRangePiker', 'https://code.jquery.com/ui/1.11.3/jquery-ui.js');
    wp_enqueue_script('jQueryRangePiker');
    wp_register_script( 'dataTableJs', 'https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js');
    wp_enqueue_script('dataTableJs');
}

add_action( 'admin_init','ch_assets');

function search_filter_form_submit() {
    global $wpdb;
    $data['title']= (!empty($_POST['title'])) ? $_POST['title']:'';
    $data['max_country_filter']= (!empty($_POST['max_country_filter'])) ? $_POST['max_country_filter']:0;   
    $data['passenger']= (!empty($_POST['passenger'])) ? 1:0;
    $data['country']= (!empty($_POST['country'])) ? 1:0;
    $data['theme']= (!empty($_POST['theme'])) ? 1:0;
    $data['date']= (!empty($_POST['date'])) ? 1:0;
    $data['num_of_passenger']= (!empty($_POST['num_of_passenger']) && !empty($_POST['passenger'])) ? $_POST['num_of_passenger']:0;
    $data['country_id']= (!empty($_POST['country_id']) && !empty($_POST['country'])) ? implode(',', $_POST['country_id']):'';
    $data['theme_id']= (!empty($_POST['theme_id']) && !empty($_POST['theme'])) ? $_POST['theme_id'] :'';
    $data['date_from']= (!empty($_POST['date']) && !empty($_POST['date_from'])) ? date('Y-m-d',strtotime($_POST['date_from'])):'';
    $data['date_to']= (!empty($_POST['date']) && !empty($_POST['date_to'])) ? date('Y-m-d',strtotime($_POST['date_to'])):'';

    
    $wpdb->insert( 'tblsearch_option', $data);
     $lastid = $wpdb->insert_id;

    // redirect after insert alert
    wp_redirect(admin_url('admin.php?page=search-tour&chid='.$lastid));
    die();

    // This is where you will control your form after it is submitted, you have access to $_POST here.

}

// Use your hidden "action" field value when adding the actions
add_action( 'admin_post_ch_search_option_form', 'search_filter_form_submit' );

add_action( 'admin_post_filter_delete_event', function () {
  global $wpdb;
  // Remove the event with specified eventid
  if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $wpdb->delete('tblsearch_option', array( 'id' => $id ) );
  }
  $redirect = add_query_arg( 'message', 'deleted', admin_url('admin.php?page=search-tour') );
    wp_redirect( $redirect );
    die();
});

function getFilterDataById(){
  global $wpdb;
  $id = $_POST['id'];
  $result = $wpdb->get_row( "SELECT * FROM tblsearch_option where id = $id ");
  echo json_encode(array('status'=>0,'data'=>$result));

}

add_action( 'admin_post_getFilterDataById', 'getFilterDataById' );

function search_filter_edit() {
    global $wpdb;
    $data['title']= (!empty($_POST['title'])) ? $_POST['title']:'';
    $data['max_country_filter']= (!empty($_POST['max_country_filter'])) ? $_POST['max_country_filter']:0;   
    $data['passenger']= (!empty($_POST['passenger'])) ? 1:0;
    $data['country']= (!empty($_POST['country'])) ? 1:0;
    $data['theme']= (!empty($_POST['theme'])) ? 1:0;
    $data['date']= (!empty($_POST['date'])) ? 1:0;
    $data['num_of_passenger']= (!empty($_POST['num_of_passenger']) && !empty($_POST['passenger'])) ? $_POST['num_of_passenger']:0;
    $data['country_id']= (!empty($_POST['country_id']) && !empty($_POST['country'])) ? implode(',', $_POST['country_id']):'';
    $data['theme_id']= (!empty($_POST['theme_id']) && !empty($_POST['theme'])) ? $_POST['theme_id'] :'';
    $data['date_from']= (!empty($_POST['date']) && !empty($_POST['date_from'])) ? date('Y-m-d',strtotime($_POST['date_from'])):'';
    $data['date_to']= (!empty($_POST['date']) && !empty($_POST['date_to'])) ? date('Y-m-d',strtotime($_POST['date_to'])):'';
    $id = $_POST['id'];
    $wpdb->update('tblsearch_option', $data,array( 'id' => $id ));

    // redirect after insert alert
    //wp_redirect(admin_url('admin.php?page=search-tour&msg=Updated Successfully'));
    $redirect = add_query_arg( 'message', 'updated', admin_url('admin.php?page=search-tour') );
    wp_redirect( $redirect );
    die();

}

add_action( 'admin_post_ch_search_option_edit_form', 'search_filter_edit' );


// tour card
function tourCardView()
{
  require_once plugin_dir_path(__FILE__).'custom-tour-card.php';
}

function tourCardOptionSubmit() {
    global $wpdb;
    $data['heading']= $_POST['heading'];
    $data['type']= $_POST['type'];
    if ($_POST['type'] == 'tour') {
      $data['tour_id']= (!empty($_POST['tour_id'])) ? implode(',', $_POST['tour_id']) : '';
    }
    else{
      $data['theme_id']= $_POST['theme_id'];
    }
    
    $data['num_of_passenger']= 1;
    $data['is_carousel']= 0;
    $data['is_image_visible']= 0;
    
    $data['is_heading_visible']= (!empty($_POST['is_heading_visible'])) ? 1:0;
    $data['is_flag_visible']= (!empty($_POST['is_flag_visible'])) ? 1:0;
    $data['is_country_visible']= (!empty($_POST['is_country_visible'])) ? 1:0;
    $data['is_description_visible']= (!empty($_POST['is_description_visible'])) ? 1:0;
    $data['is_price_visible']= (!empty($_POST['is_price_visible'])) ? 1:0;
    $data['is_wishlist_icon_visible']= (!empty($_POST['is_wishlist_icon_visible'])) ? 1:0;
    $data['is_share_icon_visible']= (!empty($_POST['is_share_icon_visible'])) ? 1:0;
    $data['is_label_visible']= (!empty($_POST['is_label_visible'])) ? 1:0;
    $data['is_learn_more_visible']= (!empty($_POST['is_learn_more_visible'])) ? 1:0;

    $wpdb->insert( 'tbltourcardplugin', $data);
    $lastid = $wpdb->insert_id;
    // redirect after insert alert
    wp_redirect(admin_url('admin.php?page=tour-carousel&tid='.$lastid));
}

// Use your hidden "action" field value when adding the actions
add_action( 'admin_post_tourcard_submit_form', 'tourCardOptionSubmit' );

add_action( 'admin_post_tour_card_delete', function () {
  global $wpdb;
  // Remove the event with specified eventid
  if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $wpdb->delete('tbltourcardplugin', array( 'id' => $id ) );
  }
  $redirect = add_query_arg( 'message', 'deleted', admin_url('admin.php?page=tour-carousel') );
    wp_redirect( $redirect );
    die();
});

add_action( 'admin_post_tourcard_update_form', function () {
    global $wpdb;
    $data['heading']= $_POST['heading'];
    $data['type']= $_POST['type'];
    if ($_POST['type'] == 'tour') {
      $data['tour_id']= (!empty($_POST['tour_id'])) ? implode(',', $_POST['tour_id']) : '';
    }
    else{
      $data['theme_id']= $_POST['theme_id'];
    }
    $data['num_of_passenger']= 1;
    $data['is_carousel']= 0;
    $data['is_image_visible']= 0;
    $data['is_heading_visible']= (!empty($_POST['is_heading_visible'])) ? 1:0;
    $data['is_flag_visible']= (!empty($_POST['is_flag_visible'])) ? 1:0;
    $data['is_country_visible']= (!empty($_POST['is_country_visible'])) ? 1:0;
    $data['is_description_visible']= (!empty($_POST['is_description_visible'])) ? 1:0;
    $data['is_price_visible']= (!empty($_POST['is_price_visible'])) ? 1:0;
    $data['is_wishlist_icon_visible']= (!empty($_POST['is_wishlist_icon_visible'])) ? 1:0;
    $data['is_share_icon_visible']= (!empty($_POST['is_share_icon_visible'])) ? 1:0;
    $data['is_label_visible']= (!empty($_POST['is_label_visible'])) ? 1:0;
    $data['is_learn_more_visible']= (!empty($_POST['is_learn_more_visible'])) ? 1:0;

    $id = $_POST['id'];
    $wpdb->update('tbltourcardplugin', $data,array( 'id' => $id ));
    // redirect after insert alert
    $redirect = add_query_arg( 'message', 'updated', admin_url('admin.php?page=tour-carousel') );
    wp_redirect( $redirect );
});

//Feature Tour Plugin
function featureTourPluginView()
{
  require_once plugin_dir_path(__FILE__).'feature-tour-plugin.php';
}

add_action( 'admin_post_feature_tour_plugin_submit_form', function() {
    global $wpdb;
    $data['title']= !empty($_POST['title'])? $_POST['title']:'';
    $data['tour_id']= (!empty($_POST['tour_id'])) ? implode(',', $_POST['tour_id']) : '';
    $data['is_display_banner']= (!empty($_POST['is_display_banner'])) ? 1:0;
    
    $wpdb->insert( 'tblfeaturetourplugin', $data);
    $lastid = $wpdb->insert_id;
    // redirect after insert alert
    wp_redirect(admin_url('admin.php?page=feature-tour-plugin&tid='.$lastid));
});

add_action( 'admin_post_feature_tour_plugin_update_form', function() {
    global $wpdb;
    //print_r($_POST);exit;
    $data['title']= !empty($_POST['title'])? $_POST['title']:'';
    $data['tour_id']= (!empty($_POST['tour_id'])) ? implode(',', $_POST['tour_id']) : '';
    $data['is_display_banner']= (!empty($_POST['is_display_banner'])) ? 1:0;
    $id = $_POST['id'];
    $wpdb->update('tblfeaturetourplugin', $data,array( 'id' => $id ));
    //echo $wpdb->last_query;exit;

    $lastid = $wpdb->insert_id;
    // redirect after insert alert
    $redirect = add_query_arg( 'message', 'updated', admin_url('admin.php?page=feature-tour-plugin') );
    wp_redirect( $redirect );
});

add_action( 'admin_post_feature_tour_plugin_delete', function () {
  global $wpdb;
  // Remove the event with specified eventid
  if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $wpdb->delete('tblfeaturetourplugin', array( 'id' => $id ) );
  }
  $redirect = add_query_arg( 'message', 'deleted', admin_url('admin.php?page=feature-tour-plugin') );
    wp_redirect( $redirect );
    die();
});
//Theme Card plugin
function themeCardPluginView()
{
  require_once plugin_dir_path(__FILE__).'theme-card-plugin.php';
}
add_action( 'admin_post_theme_card_plugin_submit_form', function() {
    global $wpdb;
    $data['theme_id']= (!empty($_POST['theme_id'])) ? implode(',', $_POST['theme_id']) : '';
    
    $wpdb->insert( 'tblthemecardplugin', $data);
    $lastid = $wpdb->insert_id;
    // redirect after insert alert
    wp_redirect(admin_url('admin.php?page=theme-card-plugin&tid='.$lastid));
});

add_action( 'admin_post_theme_card_plugin_update_form', function() {
    global $wpdb;
    print_r($_POST);
    $data['theme_id']= (!empty($_POST['theme_id'])) ? implode(',', $_POST['theme_id']) : '';
    $id = $_POST['id'];
    $wpdb->update('tblthemecardplugin', $data,array( 'id' => $id ));

    $lastid = $wpdb->insert_id;
    // redirect after insert alert
    $redirect = add_query_arg( 'message', 'updated', admin_url('admin.php?page=theme-card-plugin') );
    wp_redirect( $redirect );
});

add_action( 'admin_post_theme_card_plugin_delete', function () {
  global $wpdb;
  // Remove the event with specified eventid
  if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $wpdb->delete('tblthemecardplugin', array( 'id' => $id ) );
  }
  $redirect = add_query_arg( 'message', 'deleted', admin_url('admin.php?page=theme-card-plugin') );
    wp_redirect( $redirect );
    die();
});






