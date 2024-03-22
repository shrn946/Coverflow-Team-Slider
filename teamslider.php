<?php
/*
Plugin Name: Simple Coverflow Team Slider for WordPress
Description: This plugin adds a team slider to your WordPress website. [team_slider]
Version: 1.0
Author: Hassan Naqvi
*/

// Enqueue necessary scripts and styles
function team_slider_enqueue_scripts() {
    // Add Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/js/swiper.min.js', array(), '4.4.2', true);
    
    // Add custom script
    wp_enqueue_script('team-slider-custom-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), '1.0', true);
    
    // Add Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css', array(), '4.4.2');

    // Add normalize.css
    wp_enqueue_style('normalize-css', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css', array(), '5.0.0');
    
    // Add custom style
    wp_enqueue_style('team-slider-custom-style', plugin_dir_url(__FILE__) . 'style.css', array(), '1.0');
}

add_action('wp_enqueue_scripts', 'team_slider_enqueue_scripts');


// Step 1: Define custom post type without permalink
// Define custom post type without single page
function register_team_slider_post_type() {
    // Register custom post type
    register_post_type('team_slider',
        array(
            'labels' => array(
                'name' => __('Team Slider'),
                'singular_name' => __('Team Slider')
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'team-slider', 'with_front' => false),
            'supports' => array('title', 'thumbnail'),
            'publicly_queryable' => false, // Disable single page
        )
    );

    // Add meta box for designation field
    add_action('add_meta_boxes_team_slider', 'add_team_slider_meta_box');
    function add_team_slider_meta_box() {
        add_meta_box(
            'team_slider_designation',
            __('Designation'),
            'render_team_slider_designation_meta_box',
            'team_slider',
            'normal',
            'default'
        );
    }

    // Render meta box for designation field
    function render_team_slider_designation_meta_box($post) {
        $designation = get_post_meta($post->ID, 'designation', true);
        ?>
        <label for="designation"><?php _e('Designation:'); ?></label>
        <input type="text" id="designation" name="designation" value="<?php echo esc_attr($designation); ?>" />
        <?php
    }

    // Save designation field data
    add_action('save_post_team_slider', 'save_team_slider_meta_data');
    function save_team_slider_meta_data($post_id) {
        if (array_key_exists('designation', $_POST)) {
            update_post_meta(
                $post_id,
                'designation',
                sanitize_text_field($_POST['designation'])
            );
        }
    }

    // Display team slider
    function display_team_slider() {
        $args = array(
            'post_type' => 'team_slider',
            'posts_per_page' => -1,
        );

        $team_query = new WP_Query($args);

        if ($team_query->have_posts()) {
            echo '<div class="swiper-container">';
            echo '<div class="swiper-wrapper">';

            while ($team_query->have_posts()) {
                $team_query->the_post();
                $designation = get_post_meta(get_the_ID(), 'designation', true);
                ?>
                <div class="swiper-slide">
                    <div class="picture">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="detail">
                        <h3><?php the_title(); ?></h3>
                        <span><?php echo $designation; ?></span>
                    </div>
                </div>
                <?php
            }

            echo '</div>';
            echo '<div class="swiper-pagination"></div>';
            echo '</div>';

            wp_reset_postdata();
        }
    }
	

    // Add shortcode to display team slider
    function team_slider_shortcode() {
        ob_start();
        display_team_slider();
        return ob_get_clean();
    }
    add_shortcode('team_slider', 'team_slider_shortcode');
}

// Register team slider post type
add_action('init', 'register_team_slider_post_type');
