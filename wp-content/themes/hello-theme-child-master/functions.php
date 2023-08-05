<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

function ele_disable_page_title( $return ) {
    return false;
}
add_filter( 'hello_elementor_page_title', 'ele_disable_page_title' );



///////////// asaweb Gerald
function include_footer_php_file()
{
    // only do it for 2 pages that have the forms
    $post_id = get_the_ID();
    if ($post_id == 2849 || $post_id == 2924) {
        include get_stylesheet_directory() . '/js/forms.class.php';
    }
}

add_action('wp_footer', 'include_footer_php_file');
///////////// asaweb Gerald