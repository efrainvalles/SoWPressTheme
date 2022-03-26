
<?php

// Check for empty string allowing for a value of `0`

function remove_default_post_type($args, $postType) {
    if ($postType === 'post') {
        $args['public']                = false;
        $args['show_ui']               = false;
        $args['show_in_menu']          = false;
        $args['show_in_admin_bar']     = false;
        $args['show_in_nav_menus']     = false;
        $args['can_export']            = false;
        $args['has_archive']           = false;
        $args['exclude_from_search']   = true;
        $args['publicly_queryable']    = false;
        $args['show_in_rest']          = false;
    }

    return $args;
}
add_filter('register_post_type_args', 'remove_default_post_type', 0, 2);

function remove_default_post2_type($args, $postType) {
    if ($postType === 'page') {
        $args['public']                = false;
        $args['show_ui']               = false;
        $args['show_in_menu']          = false;
        $args['show_in_admin_bar']     = false;
        $args['show_in_nav_menus']     = false;
        $args['can_export']            = false;
        $args['has_archive']           = false;
        $args['exclude_from_search']   = true;
        $args['publicly_queryable']    = false;
        $args['show_in_rest']          = false;
    }

    return $args;
}
add_filter('register_post_type_args', 'remove_default_post2_type', 0, 2);

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
 
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'press' ) );
    return $query;
}

add_action('save_post', function($post_id){
    $post = get_post($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $field_name = 'article_name';
    $field2_name = 'article_publisher';
    $field3_name = 'article_link';

    // Do not save meta for a revision or on autosave
    if ( $post->post_type != 'press' || $is_revision )
        return; 

    // Do not save meta if fields are not present,
    // like during a restore.
    if( !isset($_POST[$field_name]) )
        return;
    if( !isset($_POST[$field2_name]) )
        return;
    if( !isset($_POST[$field3_name]) )
        return;
    // Secure with nonce field check
    if( ! check_admin_referer('press_nonce', 'press_nonce') )
        return;

    // Clean up data
    $field_value = trim($_POST[$field_name]);
    $field2_value = trim($_POST[$field2_name]);
    $field3_value = trim($_POST[$field3_name]);
    // Do the saving and deleting
    if( ! empty_str( $field_value )){
        update_post_meta($post_id, $field_name, $field_value);
    } elseif( empty_str( $field_value ) ) {
        delete_post_meta($post_id, $field_name);
    }
    if( ! empty_str( $field2_value )){
        update_post_meta($post_id, $field2_name, $field2_value);
    } elseif( empty_str( $field2_value ) ) {
        delete_post_meta($post_id, $field2_name);

    }
    if( ! empty_str( $field3_value )){
        update_post_meta($post_id, $field3_name, $field3_value);
    } elseif( empty_str( $field3_value ) ) {
        delete_post_meta($post_id, $field3_name);

    }
});


function empty_str( $str ) {
    return ! isset( $str ) || $str === "";
}




function press_meta_box(WP_Post $post) {
    add_meta_box('press_meta', 'Press Details', function() use ($post){
        $field_name = 'article_name';
        $field_value = get_post_meta($post->ID, $field_name, true);
        $field2_name = 'article_publisher';
        $field2_value = get_post_meta($post->ID, $field2_name, true);
        $field3_name = 'article_link';
        $field3_value = get_post_meta($post->ID, $field3_name, true);
        wp_nonce_field('press_nonce', 'press_nonce');
        ?>
        <table class="form-table">
            <tr>
                <th> <label for="<?php echo $field_name; ?>">Article Name</label></th>
                <td>
                    <input id="<?php echo $field_name; ?>"
                           name="<?php echo $field_name; ?>"
                           type="text"
                           value="<?php echo esc_attr($field_value); ?>"
                    />
                </td>
            </tr>
            <tr>
                <th> <label for="<?php echo $field2_name2; ?>">Publisher Name</label></th>
                <td>
                    <input id="<?php echo $field2_name; ?>"
                           name="<?php echo $field2_name; ?>"
                           type="text"
                           value="<?php echo esc_attr($field2_value); ?>"
                    />
                </td>
            </tr>
            <tr>
                <th> <label for="<?php echo $field3_name2; ?>">Article Link</label></th>
                <td>
                    <input id="<?php echo $field3_name; ?>"
                           name="<?php echo $field3_name; ?>"
                           type="text"
                           value="<?php echo esc_attr($field3_value); ?>"
                    />
                </td>
            </tr>
        </table>
        <?php
    });
}






add_action( 'init', function() {
    $labels = xcompile_post_type_labels('Press', 'Presses');
    $type = 'press';
    $arguments = [
        'register_meta_box_cb' => 'press_meta_box',
        'public' => true, // Allow access to post type
        'description' => 'A Custom Post Type for School of Whales.', // Add a description
        'menu_icon' => 'dashicons-media-document',
        'menu_position' => 5,
        'has_archive' => true,
        'rewrite' => [ 'slug' => 'presses' ],
        'labels'  => $labels // Set the primary label
    ];
    register_post_type( $type, $arguments );
});


function xcompile_post_type_labels($singular = 'Press', $plural = 'Presses') {
    $p_lower = strtolower($plural);
    $s_lower = strtolower($singular);

    return [
        'name' => $plural,
        'singular_name' => $singular,
        'has_archive' => true,
        'rewrite' => [ 'slug' => 'presses' ],
        'add_new_item' => "New $singular",
        'edit_item' => "Edit $singular",
        'view_item' => "View $singular",
        'view_items' => "View $plural",
        'search_items' => "Search $plural",
        'not_found' => "No $p_lower found",
        'not_found_in_trash' => "No $p_lower found in trash",
        'parent_item_colon' => "Parent $singular",
        'all_items' => "All $plural",
        'archives' => "$singular Archives",
        'attributes' => "$singular Attributes",
        'insert_into_item' => "Insert into $s_lower",
        'uploaded_to_this_item' => "Uploaded to this $s_lower",
    ];
}



function sow_theme_support(){
    // Adds tittle tag 
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'sow_theme_support');

function sow_menus(){

    $locations = array(
        'primary' => "Desktop Primary Left Sidebar",
        'footer' => "Footer Menu Items"
    );

    register_nav_menus($locations);

}

add_action('init','sow_menus');


function sow_register_styles(){

    $version = wp_get_theme()->get( 'Version' );
    wp_enqueue_style('sow-style',get_template_directory_uri() . "/style.css", array('sow-bootstrap'), $version,'all');
    wp_enqueue_style('sow-bootstrap',"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), '4.4.1','all');
    wp_enqueue_style('sow-fontawesome',"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0','all');
}

add_action( 'wp_enqueue_scripts', 'sow_register_styles');


function sow_register_scripts(){

   wp_enqueue_script('sow-jquery',"https://code.jquery.com/jquery-3.4.1.slim.min.js", array(), '3.4.1',true);
   wp_enqueue_script('sow-popper',"https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js", array(), '1.16.0',true);
   wp_enqueue_script('sow-bootstrap',"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js", array(), '4.4.1',true);
   wp_enqueue_script('sow-main-js',get_template_directory_uri(). "/assets/js/main.js", array(), '0.1.1',true);
}

add_action( 'wp_enqueue_scripts', 'sow_register_scripts');


function sow_widget_areas(){

    register_sidebar(
        array(
            'before_title' => '',
            'after_title' => '',
            'before_widget'=> '',
            'after_widget' => '',
        ),
        array(
            'name' => 'Sidebar Area',
            'id' => 'sidebar-1',
            'description' => 'Sidebar Widget Area'

        )
    );

}

add_action( 'widgets_init', 'sow_widget_areas')

?>