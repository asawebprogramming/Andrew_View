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

///////////// Gerald
function asa_include_footer_php_file()
{
    // only do it for 2 pages that have the forms
    $post_id = get_the_ID();
    if ($post_id == 2849 || $post_id == 2924) {
        include get_stylesheet_directory() . '/js/forms.class.php';
        // get stylesheet directory is the path to the child theme
        // forms.class.php is the file that outputs the javascript
    }
}

add_action('wp_footer', 'asa_include_footer_php_file');
///////////// Gerald

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

