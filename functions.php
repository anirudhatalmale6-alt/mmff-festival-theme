<?php
/**
 * MMFF Festival Theme Functions
 */

if (!defined('ABSPATH')) exit;

define('MMFF_VERSION', '1.0.0');
define('MMFF_DIR', get_template_directory());
define('MMFF_URI', get_template_directory_uri());

// Theme Setup
function mmff_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
    add_theme_support('custom-logo', [
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'mmff-festival'),
        'footer' => __('Footer Menu', 'mmff-festival'),
    ]);

    add_image_size('film-poster', 600, 900, true);
    add_image_size('film-card', 400, 600, true);
    add_image_size('hero-banner', 1920, 800, true);
    add_image_size('sponsor-logo', 300, 150, false);
}
add_action('after_setup_theme', 'mmff_setup');

// Enqueue Styles and Scripts
function mmff_enqueue_assets() {
    wp_enqueue_style('mmff-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800&display=swap', [], null);
    wp_enqueue_style('mmff-main', MMFF_URI . '/assets/css/main.css', [], MMFF_VERSION);
    wp_enqueue_script('mmff-main', MMFF_URI . '/assets/js/main.js', [], MMFF_VERSION, true);

    wp_localize_script('mmff-main', 'mmff_ajax', [
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mmff_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'mmff_enqueue_assets');

// ============================================
// Custom Post Type: Films
// ============================================
function mmff_register_film_cpt() {
    register_post_type('film', [
        'labels' => [
            'name' => 'Films',
            'singular_name' => 'Film',
            'add_new' => 'Add New Film',
            'add_new_item' => 'Add New Film',
            'edit_item' => 'Edit Film',
            'all_items' => 'All Films',
            'search_items' => 'Search Films',
            'not_found' => 'No films found',
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'film'],
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
    ]);

    // Film Category Taxonomy
    register_taxonomy('film_category', 'film', [
        'labels' => [
            'name' => 'Film Categories',
            'singular_name' => 'Film Category',
        ],
        'hierarchical' => true,
        'rewrite' => ['slug' => 'film-category'],
        'show_in_rest' => true,
    ]);

    // Film Year Taxonomy
    register_taxonomy('film_year', 'film', [
        'labels' => [
            'name' => 'Festival Years',
            'singular_name' => 'Festival Year',
        ],
        'hierarchical' => true,
        'rewrite' => ['slug' => 'program'],
        'show_in_rest' => true,
    ]);

    // Film Country Taxonomy
    register_taxonomy('film_country', 'film', [
        'labels' => [
            'name' => 'Countries',
            'singular_name' => 'Country',
        ],
        'hierarchical' => false,
        'rewrite' => ['slug' => 'country'],
        'show_in_rest' => true,
    ]);

    // Film Language Taxonomy
    register_taxonomy('film_language', 'film', [
        'labels' => [
            'name' => 'Languages',
            'singular_name' => 'Language',
        ],
        'hierarchical' => false,
        'rewrite' => ['slug' => 'language'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'mmff_register_film_cpt');

// Film Custom Meta Fields
function mmff_film_meta_boxes() {
    add_meta_box('film_details', 'Film Details', 'mmff_film_details_callback', 'film', 'normal', 'high');
}
add_action('add_meta_boxes', 'mmff_film_meta_boxes');

function mmff_film_details_callback($post) {
    wp_nonce_field('mmff_film_meta', 'mmff_film_meta_nonce');
    $duration = get_post_meta($post->ID, '_film_duration', true);
    $director = get_post_meta($post->ID, '_film_director', true);
    $producer = get_post_meta($post->ID, '_film_producer', true);
    $screening_date = get_post_meta($post->ID, '_film_screening_date', true);
    $screening_time = get_post_meta($post->ID, '_film_screening_time', true);
    $film_type = get_post_meta($post->ID, '_film_type', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="film_duration">Duration</label></th>
            <td><input type="text" id="film_duration" name="film_duration" value="<?php echo esc_attr($duration); ?>" placeholder="e.g. 12:16 or 01:15:00"></td>
        </tr>
        <tr>
            <th><label for="film_director">Director</label></th>
            <td><input type="text" id="film_director" name="film_director" value="<?php echo esc_attr($director); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="film_producer">Producer</label></th>
            <td><input type="text" id="film_producer" name="film_producer" value="<?php echo esc_attr($producer); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="film_type">Type</label></th>
            <td>
                <select id="film_type" name="film_type">
                    <option value="">Select Type</option>
                    <option value="documentary" <?php selected($film_type, 'documentary'); ?>>Documentary</option>
                    <option value="short" <?php selected($film_type, 'short'); ?>>Short</option>
                    <option value="feature" <?php selected($film_type, 'feature'); ?>>Feature</option>
                    <option value="experimental" <?php selected($film_type, 'experimental'); ?>>Experimental</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="film_screening_date">Screening Date</label></th>
            <td><input type="date" id="film_screening_date" name="film_screening_date" value="<?php echo esc_attr($screening_date); ?>"></td>
        </tr>
        <tr>
            <th><label for="film_screening_time">Screening Time</label></th>
            <td><input type="text" id="film_screening_time" name="film_screening_time" value="<?php echo esc_attr($screening_time); ?>" placeholder="e.g. 14:00-15:15"></td>
        </tr>
        <tr>
            <th><label for="film_trailer_url">Trailer URL</label></th>
            <td><input type="url" id="film_trailer_url" name="film_trailer_url" value="<?php echo esc_url(get_post_meta($post->ID, '_film_trailer_url', true)); ?>" class="regular-text" placeholder="https://www.youtube.com/watch?v=... or https://vimeo.com/..."></td>
        </tr>
    </table>
    <?php
}

function mmff_save_film_meta($post_id) {
    if (!isset($_POST['mmff_film_meta_nonce']) || !wp_verify_nonce($_POST['mmff_film_meta_nonce'], 'mmff_film_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['film_duration', 'film_director', 'film_producer', 'film_type', 'film_screening_date', 'film_screening_time'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    if (isset($_POST['film_trailer_url'])) {
        update_post_meta($post_id, '_film_trailer_url', esc_url_raw($_POST['film_trailer_url']));
    }
}
add_action('save_post_film', 'mmff_save_film_meta');

// ============================================
// Custom Post Type: Sponsors
// ============================================
function mmff_register_sponsor_cpt() {
    register_post_type('sponsor', [
        'labels' => [
            'name' => 'Sponsors',
            'singular_name' => 'Sponsor',
            'add_new' => 'Add New Sponsor',
            'add_new_item' => 'Add New Sponsor',
            'edit_item' => 'Edit Sponsor',
            'all_items' => 'All Sponsors',
        ],
        'public' => true,
        'has_archive' => false,
        'rewrite' => ['slug' => 'sponsor'],
        'menu_icon' => 'dashicons-awards',
        'supports' => ['title', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('sponsor_level', 'sponsor', [
        'labels' => [
            'name' => 'Sponsor Levels',
            'singular_name' => 'Sponsor Level',
        ],
        'hierarchical' => true,
        'rewrite' => ['slug' => 'sponsor-level'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'mmff_register_sponsor_cpt');

// Sponsor Meta
function mmff_sponsor_meta_boxes() {
    add_meta_box('sponsor_details', 'Sponsor Details', 'mmff_sponsor_details_callback', 'sponsor', 'normal', 'high');
}
add_action('add_meta_boxes', 'mmff_sponsor_meta_boxes');

function mmff_sponsor_details_callback($post) {
    wp_nonce_field('mmff_sponsor_meta', 'mmff_sponsor_meta_nonce');
    $url = get_post_meta($post->ID, '_sponsor_url', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="sponsor_url">Website URL</label></th>
            <td><input type="url" id="sponsor_url" name="sponsor_url" value="<?php echo esc_url($url); ?>" class="regular-text" placeholder="https://"></td>
        </tr>
    </table>
    <?php
}

function mmff_save_sponsor_meta($post_id) {
    if (!isset($_POST['mmff_sponsor_meta_nonce']) || !wp_verify_nonce($_POST['mmff_sponsor_meta_nonce'], 'mmff_sponsor_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['sponsor_url'])) {
        update_post_meta($post_id, '_sponsor_url', esc_url_raw($_POST['sponsor_url']));
    }
}
add_action('save_post_sponsor', 'mmff_save_sponsor_meta');

// ============================================
// AJAX Film Search/Filter
// ============================================
function mmff_filter_films() {
    check_ajax_referer('mmff_nonce', 'nonce');

    $args = [
        'post_type' => 'film',
        'posts_per_page' => -1,
        'orderby' => 'meta_value',
        'meta_key' => '_film_screening_date',
        'order' => 'ASC',
    ];

    $tax_query = [];

    if (!empty($_POST['year'])) {
        $tax_query[] = [
            'taxonomy' => 'film_year',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['year']),
        ];
    }

    if (!empty($_POST['category'])) {
        $tax_query[] = [
            'taxonomy' => 'film_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['category']),
        ];
    }

    if (!empty($_POST['country'])) {
        $tax_query[] = [
            'taxonomy' => 'film_country',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['country']),
        ];
    }

    if (!empty($_POST['language'])) {
        $tax_query[] = [
            'taxonomy' => 'film_language',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['language']),
        ];
    }

    if (count($tax_query) > 0) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    if (!empty($_POST['search'])) {
        $args['s'] = sanitize_text_field($_POST['search']);
    }

    if (!empty($_POST['film_type'])) {
        $args['meta_query'][] = [
            'key' => '_film_type',
            'value' => sanitize_text_field($_POST['film_type']),
        ];
    }

    $query = new WP_Query($args);
    $films = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $films[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'film-card'),
                'excerpt' => get_the_excerpt(),
                'duration' => get_post_meta(get_the_ID(), '_film_duration', true),
                'director' => get_post_meta(get_the_ID(), '_film_director', true),
                'type' => get_post_meta(get_the_ID(), '_film_type', true),
                'screening_date' => get_post_meta(get_the_ID(), '_film_screening_date', true),
                'screening_time' => get_post_meta(get_the_ID(), '_film_screening_time', true),
                'countries' => wp_get_post_terms(get_the_ID(), 'film_country', ['fields' => 'names']),
                'languages' => wp_get_post_terms(get_the_ID(), 'film_language', ['fields' => 'names']),
                'categories' => wp_get_post_terms(get_the_ID(), 'film_category', ['fields' => 'names']),
            ];
        }
    }
    wp_reset_postdata();

    wp_send_json_success($films);
}
add_action('wp_ajax_mmff_filter_films', 'mmff_filter_films');
add_action('wp_ajax_nopriv_mmff_filter_films', 'mmff_filter_films');

// ============================================
// Helper: Get Sponsors
// ============================================
function mmff_get_sponsors($level = '') {
    $args = [
        'post_type' => 'sponsor',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ];

    if ($level) {
        $args['tax_query'] = [[
            'taxonomy' => 'sponsor_level',
            'field' => 'slug',
            'terms' => $level,
        ]];
    }

    return new WP_Query($args);
}

// ============================================
// Customizer Settings
// ============================================
function mmff_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('mmff_hero', [
        'title' => 'Homepage Hero',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('mmff_hero_image', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mmff_hero_image', [
        'label' => 'Hero Background Image',
        'section' => 'mmff_hero',
    ]));

    $wp_customize->add_setting('mmff_hero_title', ['default' => 'Migration Matters Film Festival']);
    $wp_customize->add_control('mmff_hero_title', [
        'label' => 'Hero Title',
        'section' => 'mmff_hero',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mmff_hero_subtitle', ['default' => 'February 20-22, 2026 | Stockholm, Sweden']);
    $wp_customize->add_control('mmff_hero_subtitle', [
        'label' => 'Hero Subtitle',
        'section' => 'mmff_hero',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mmff_hero_tagline', ['default' => 'Where art sparks dialogue and builds an inclusive stage']);
    $wp_customize->add_control('mmff_hero_tagline', [
        'label' => 'Hero Tagline',
        'section' => 'mmff_hero',
        'type' => 'textarea',
    ]);

    // Festival Info
    $wp_customize->add_section('mmff_info', [
        'title' => 'Festival Info',
        'priority' => 31,
    ]);

    $wp_customize->add_setting('mmff_venue', ['default' => 'Bredgränd 2, 111 30 Stockholm']);
    $wp_customize->add_control('mmff_venue', [
        'label' => 'Venue Address',
        'section' => 'mmff_info',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mmff_contact_email', ['default' => 'contact@mmff.se']);
    $wp_customize->add_control('mmff_contact_email', [
        'label' => 'Contact Email',
        'section' => 'mmff_info',
        'type' => 'email',
    ]);

    // Social Links
    $wp_customize->add_section('mmff_social', [
        'title' => 'Social Links',
        'priority' => 32,
    ]);

    foreach (['instagram', 'facebook', 'twitter'] as $social) {
        $wp_customize->add_setting("mmff_{$social}_url", ['default' => '']);
        $wp_customize->add_control("mmff_{$social}_url", [
            'label' => ucfirst($social) . ' URL',
            'section' => 'mmff_social',
            'type' => 'url',
        ]);
    }
}
add_action('customize_register', 'mmff_customizer');

// Flush rewrite rules on activation
function mmff_activate() {
    mmff_register_film_cpt();
    mmff_register_sponsor_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'mmff_activate');

// Film Import Tool (admin only)
require_once get_template_directory() . '/import-films.php';
