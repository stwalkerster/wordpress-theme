<?php

register_sidebar(array(
    'name' => 'Alternate Page Sidebar',
    'id' => 'sidebar-pagealternate',
    'description' => 'The sidebar for the alternate page template',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
));

register_sidebar(array(
    'name' => 'Events Crew Sidebar',
    'id' => 'sidebar-eventscrew',
    'description' => 'The sidebar for the events crew page template',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
));

register_sidebar(array(
    'name' => 'Ingress Sidebar',
    'id' => 'sidebar-ingress',
    'description' => 'The sidebar for the ingress page template',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
));

register_sidebar(array(
    'name' => 'Footer area',
    'id' => 'sidebar-footer',
    'description' => 'The footer widget area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
));


if (!function_exists('twentyeleven_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override twentyeleven_setup() in a child theme, add your own twentyeleven_setup to your child theme's
     * functions.php file.
     *
     * @uses load_theme_textdomain() For translation/localization support.
     * @uses add_editor_style() To style the visual editor.
     * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
     *    and backgrounds, and post formats.
     * @uses register_nav_menus() To add support for navigation menus.
     * @uses register_default_headers() To register the default custom header images provided with the theme.
     * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_setup()
    {

        /* Make Twenty Eleven available for translation.
         * Translations can be added to the /languages/ directory.
         * If you're building a theme based on Twenty Eleven, use a find and replace
         * to change 'twentyeleven' to the name of your theme in all the template files.
         */
        load_theme_textdomain('twentyeleven', get_template_directory() . '/languages');

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Load up our theme options page and related code.
        require(get_template_directory() . '/inc/theme-options.php');

        // Grab Twenty Eleven's Ephemera widget.
        require(get_template_directory() . '/inc/widgets.php');

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support('automatic-feed-links');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menu('primary', __('Primary Menu', 'twentyeleven'));

        // Add support for a variety of post formats
        add_theme_support('post-formats', array('aside', 'link', 'gallery'/*, 'status'*/, 'quote', 'image', 'video' /*, 'chat'*//*, 'audio'*/));

        $theme_options = twentyeleven_get_theme_options();
        if ('dark' == $theme_options['color_scheme'])
            $default_background_color = '1d1d1d';
        else
            $default_background_color = 'f1f1f1';

        // Add support for custom backgrounds.
        add_theme_support('custom-background', array(
            // Let WordPress know what our default background color is.
            // This is dependent on our current color scheme.
            'default-color' => $default_background_color,
        ));

        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
        add_theme_support('post-thumbnails');

        // Add support for custom headers.
        $custom_header_support = array(
            // The default header text color.
            'default-text-color' => '000',
            // The height and width of our custom header.
            'width' => apply_filters('twentyeleven_header_image_width', 1000),
            'height' => apply_filters('twentyeleven_header_image_height', 288),
            // Support flexible heights.
            'flex-height' => true,
            // Random image rotation by default.
            'random-default' => true,
            // Callback for styling the header.
            'wp-head-callback' => 'twentyeleven_header_style',
            // Callback for styling the header preview in the admin.
            'admin-head-callback' => 'twentyeleven_admin_header_style',
            // Callback used to display the header preview in the admin.
            'admin-preview-callback' => 'twentyeleven_admin_header_image',
        );

        add_theme_support('custom-header', $custom_header_support);

        if (!function_exists('get_custom_header')) {
            // This is all for compatibility with versions of WordPress prior to 3.4.
            define('HEADER_TEXTCOLOR', $custom_header_support['default-text-color']);
            define('HEADER_IMAGE', '');
            define('HEADER_IMAGE_WIDTH', $custom_header_support['width']);
            define('HEADER_IMAGE_HEIGHT', $custom_header_support['height']);
            add_custom_image_header($custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback']);
            add_custom_background();
        }

        // We'll be using post thumbnails for custom header images on posts and pages.
        // We want them to be the size of the header image that we just defined
        // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
        set_post_thumbnail_size($custom_header_support['width'], $custom_header_support['height'], true);

        // Add Twenty Eleven's custom image sizes.
        // Used for large feature (header) images.
        add_image_size('large-feature', $custom_header_support['width'], $custom_header_support['height'], true);
        // Used for featured posts if a large-feature doesn't exist.
        add_image_size('small-feature', 500, 300);

        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        $headerImages = array(
            'leapfrogscreen' => array(
                'url' => get_stylesheet_directory_uri() . '/images/header/leapfrogscreen.jpg',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/leapfrogscreen.jpg',
                'description' => 'zero88 Leap Frog (screen)'
            ),
            'leapfrog' => array(
                'url' => get_stylesheet_directory_uri() . '/images/header/leapfrog.JPG',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/leapfrog.JPG',
                'description' => 'zero88 Leap Frog'
            ),
            'openmic' => array(
                'url' => get_stylesheet_directory_uri() . '/images/header/openmic.jpg',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/openmic.jpg',
                'description' => 'Open Mic'
            ),
            'gb4' => array(
                'url' => get_stylesheet_directory_uri() . '/images/header/gb4.jpg',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/gb4.jpg',
                'description' => 'GB4'
            ),
            'ingress' => array(
                'url' => get_stylesheet_directory_uri() . '/images/header/ingress.jpg',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/ingress.jpg',
                'description' => 'Ingress Scanner'
            ),

            'sunset' => array(
                'url' => get_stylesheet_directory_uri() . '/images/header/sunset.jpg',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/sunset.jpg',
                'description' => 'Sunset over Edinburgh'
            ),
        );

        $now = new DateTime();
        if ($now->format('n') == 12) {
            // Christmas images
            $headerImages['edimound'] = array(
                'url' => get_stylesheet_directory_uri() . '/images/header/christmas/edimound.jpg',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/christmas/thumbs/edimound.jpg',
                'description' => 'Edinburgh\'s Christmas from The Mound'
            );

            $headerImages['edicastle'] = array(
                'url' => get_stylesheet_directory_uri() . '/images/header/christmas/edicastle.JPG',
                'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/christmas/thumbs/edicastle.JPG',
                'description' => 'Edinburgh Castle from Calton Hill'
            );
        }

        register_default_headers($headerImages);
    }
endif; // twentyeleven_setup


add_filter('body_class', 'adjust_body_class', 20, 2);

function adjust_body_class($wp_classes, $extra_classes)
{
    if (is_page_template('page-alt.php') || is_page_template('page-eventscrew.php') || is_page_template('page-ingress.php')) {
        // Filter the body classes
        foreach ($wp_classes as $key => $value) {
            if ($value == 'singular') {
                unset($wp_classes[$key]);
            }
        }
    }

    // Add the extra classes back untouched
    return array_merge($wp_classes, (array)$extra_classes);
}

function my_theme_custom_upload_mimes($existing_mimes)
{
    // add webm to the list of mime types
    $existing_mimes['kml'] = 'application/vnd.google-earth.kml+xml';
    $existing_mimes['kmz'] = 'application/vnd.google-earth.kmz';
    $existing_mimes['svg'] = 'image/svg+xml';

    // return the array back to the function with our added mime type
    return $existing_mimes;
}

add_filter('mime_types', 'my_theme_custom_upload_mimes');

global $stwalkerster_ed_variable_name;
$stwalkerster_ed_variable_name = array(
    'ed_current_location' => 'Current location',
    'ed_distance_from_jaques' => 'Distance from Eol Prou RS-T d3-94',
    'ed_incident_count' => 'Incident count',
    'ed_jumps_made' => 'Jumps made so far',
    'ed_jumps_remaining' => 'Jumps remaining (best case)',
    'ed_madness' => 'Space madness',
);

function stw_ed_stat($name)
{
    $header = stw_get_ed($name);
    $value = get_post_meta(get_the_ID(), $name, true);

    echo "<tr><td>$header</td><td>$value</td></tr>";
}

function stw_get_ed($name)
{
    global $stwalkerster_ed_variable_name;

    return $stwalkerster_ed_variable_name[$name];
}

add_image_size('full-width', 1000, 288, true);

add_filter('image_size_names_choose', 'stw_custom_sizes');

function stw_custom_sizes($sizes)
{
    return array_merge($sizes, array(
        'stw-full-width' => __('Full-page width'),
    ));
}

