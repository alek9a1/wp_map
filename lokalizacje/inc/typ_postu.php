<?php

// Register Custom Post Type
function lokalizacje_post_type() {

  $labels = array(
    'name'                  => _x( 'Lokalizacje', 'Post Type General Name', 'thbusiness' ),
    'singular_name'         => _x( 'Lokalizacja', 'Post Type Singular Name', 'thbusiness' ),
    'menu_name'             => __( 'Lokalizacje', 'thbusiness' ),
    'name_admin_bar'        => __( 'Lokalizacja', 'thbusiness' ),
    'archives'              => __( 'Item Archives', 'thbusiness' ),
    'attributes'            => __( 'Item Attributes', 'thbusiness' ),
    'parent_item_colon'     => __( 'Parent Item:', 'thbusiness' ),
    'all_items'             => __( 'Wszystkie', 'thbusiness' ),
    'add_new_item'          => __( 'Add New Item', 'thbusiness' ),
    'add_new'               => __( 'Dodaj nową', 'thbusiness' ),
    'new_item'              => __( 'New Item', 'thbusiness' ),
    'edit_item'             => __( 'Edit Item', 'thbusiness' ),
    'update_item'           => __( 'Update Item', 'thbusiness' ),
    'view_item'             => __( 'View Item', 'thbusiness' ),
    'view_items'            => __( 'View Items', 'thbusiness' ),
    'search_items'          => __( 'Search Item', 'thbusiness' ),
    'not_found'             => __( 'Not found', 'thbusiness' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'thbusiness' ),
    'featured_image'        => __( 'Featured Image', 'thbusiness' ),
    'set_featured_image'    => __( 'Set featured image', 'thbusiness' ),
    'remove_featured_image' => __( 'Remove featured image', 'thbusiness' ),
    'use_featured_image'    => __( 'Use as featured image', 'thbusiness' ),
    'insert_into_item'      => __( 'Insert into item', 'thbusiness' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'thbusiness' ),
    'items_list'            => __( 'Items list', 'thbusiness' ),
    'items_list_navigation' => __( 'Items list navigation', 'thbusiness' ),
    'filter_items_list'     => __( 'Filter items list', 'thbusiness' ),
  );
  $args = array(
    'label'                 => __( 'Lokalizacja', 'thbusiness' ),
    'description'           => __( 'Lokalizajce', 'thbusiness' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
    'taxonomies'            => array( 'wojewodztwa' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'lokalizacja', $args );

}
add_action( 'init', 'lokalizacje_post_type', 0 );


// Register Custom Taxonomy
function wojewodztwa() {

  $labels = array(
    'name'                       => _x( 'Województwo', 'Taxonomy General Name', 'thbusiness' ),
    'singular_name'              => _x( 'Województwa', 'Taxonomy Singular Name', 'thbusiness' ),
    'menu_name'                  => __( 'Województwa', 'thbusiness' ),
    'all_items'                  => __( 'All Items', 'thbusiness' ),
    'parent_item'                => __( 'Parent Item', 'thbusiness' ),
    'parent_item_colon'          => __( 'Parent Item:', 'thbusiness' ),
    'new_item_name'              => __( 'New Item Name', 'thbusiness' ),
    'add_new_item'               => __( 'Add New Item', 'thbusiness' ),
    'edit_item'                  => __( 'Edit Item', 'thbusiness' ),
    'update_item'                => __( 'Update Item', 'thbusiness' ),
    'view_item'                  => __( 'View Item', 'thbusiness' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'thbusiness' ),
    'add_or_remove_items'        => __( 'Add or remove items', 'thbusiness' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'thbusiness' ),
    'popular_items'              => __( 'Popular Items', 'thbusiness' ),
    'search_items'               => __( 'Search Items', 'thbusiness' ),
    'not_found'                  => __( 'Not Found', 'thbusiness' ),
    'no_terms'                   => __( 'No items', 'thbusiness' ),
    'items_list'                 => __( 'Items list', 'thbusiness' ),
    'items_list_navigation'      => __( 'Items list navigation', 'thbusiness' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'wojewodztwa', array( 'lokalizacja' ), $args );

}
add_action( 'init', 'wojewodztwa', 0 );


 

  

function wporg_add_custom_box()
{
    $screens = ['lokalizacja'];
    foreach ($screens as $screen) {
        add_meta_box(
            'pola_box_id',           // Unique ID
            'Dane szczegółowe',  // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'wporg_add_custom_box');

    
  
function wporg_custom_box_html($post) {
$prefix = 'wpcf-';

 $fields = [
  array(
        'id' => $prefix . 'ulica',
        'type' => 'text',
        'name' => esc_html__( 'Ulica', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'ulica', true)
      ),
      array(
        'id' => $prefix . 'miejscowosc',
        'type' => 'text',
        'name' => esc_html__( 'Miejscowość', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'miejscowosc', true)
      ),
      
      array(
        'id' => $prefix . 'telefon',
        'type' => 'text',
        'name' => esc_html__( 'Telefon', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'telefon', true)
      ),
      array(
        'id' => $prefix . 'emial',
        'type' => 'text',
        'name' => esc_html__( 'Emial', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'emial', true)
      ),
      array(
        'id' => $prefix . 'pozycja',
        'type' => 'text',
        'name' => esc_html__( 'Pozycja', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'pozycja', true)
      ),
      array(
        'id' => $prefix . 'kod',
        'type' => 'text',
        'name' => esc_html__( 'Kod pocztowy', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'kod', true)
      ),
      array(
        'id' => $prefix . 'poczta-miejscowosc',
        'type' => 'text',
        'name' => esc_html__( 'Poczta Miejscowość', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'poczta-miejscowosc', true)
      )];
 
    foreach ($fields as $field) {


      echo '<input 
      placeholder="'.$field['name'].'" 
      name="'.$field['id'].'" 
      type="'.$field['type'].'" 
      id="'.$field['id'].'" 
      class"'.$field['id'].'" 
      value="'.$field['val'].'">';
       

    }

    echo '<style>

#pola_box_id input {
  padding: 20px;
  width: 100%;
  margin-bottom: 10px;
}
  
</style>';



}

add_action('add_meta_boxes', 'wporg_add_custom_box');


function wporg_save_postdata($post_id)
{
$prefix = 'wpcf-';
  $fields = [
      array(
        'id' => $prefix . 'miejscowosc',
        'type' => 'text',
        'name' => esc_html__( 'Miejscowość', 'thbusiness' ),
        'val' => get_post_meta($post->ID, $prefix . 'miejscowosc', true)
      ),
      array(
        'id' => $prefix . 'ulica',
        'type' => 'text',
        'name' => esc_html__( 'Ulica', 'thbusiness' ),
      ),
      array(
        'id' => $prefix . 'telefon',
        'type' => 'text',
        'name' => esc_html__( 'Telefon', 'thbusiness' ),
      ),
      array(
        'id' => $prefix . 'emial',
        'type' => 'text',
        'name' => esc_html__( 'Emial', 'thbusiness' ),
      ),
      array(
        'id' => $prefix . 'pozycja',
        'type' => 'text',
        'name' => esc_html__( 'Pozycja', 'thbusiness' ),
      ),
      array(
        'id' => $prefix . 'kod',
        'type' => 'text',
        'name' => esc_html__( 'Kod pocztowy', 'thbusiness' ),
      ),
      array(
        'id' => $prefix . 'poczta-miejscowosc',
        'type' => 'text',
        'name' => esc_html__( 'Poczta Miejscowość', 'thbusiness' ),
      )];

  foreach ($fields as $field) {

        update_post_meta($post_id, $field['id'], $_POST[$field['id']]);
    }


}
add_action('save_post', 'wporg_save_postdata');