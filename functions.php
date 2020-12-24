<?php


function add_theme_scripts()
{
  wp_enqueue_style('style', get_stylesheet_uri());
  if (is_singular() & comments_open() &  get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');


function register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('menu')
    )
  );
}
add_action('init', 'register_my_menus');

function the_breadcrumb()
{
  if (!is_home()) {
    echo '<a href="';
    echo get_option('home');
    echo '">';
    bloginfo('name');
    echo "</a>» ";
    if (is_category() || is_single()) {
      the_category('title_li=');
      if (is_single()) {
        echo " » ";
        the_title();
      }
    } elseif (is_page()) {
      echo the_title();
    }
  }
}


function woo_theme_support()
{
  // Custom background color.
  add_theme_support(
    'custom-background',
    array(
      'default-color' => 'f5efe0',
    )
  );

  // Set content-width.
  global $content_width;
  if (!isset($content_width)) {
    $content_width = 580;
  }

  /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
  add_theme_support('post-thumbnails');

  // Set post thumbnail size.
  set_post_thumbnail_size(1200, 9999);

  // Add custom image size used in Cover Template.

  // Custom logo.
  $logo_width  = 120;
  $logo_height = 90;

  // If the retina setting is active, double the recommended width and height.
  if (get_theme_mod('retina_logo', false)) {
    $logo_width  = floor($logo_width * 2);
    $logo_height = floor($logo_height * 2);
  }

  add_theme_support(
    'custom-logo',
    array(
      'height'      => $logo_height,
      'width'       => $logo_width,
      'flex-height' => true,
      'flex-width'  => true,
    )
  );

  /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
  add_theme_support('title-tag');

  /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
      'navigation-widgets',
    )
  );
}

add_action('after_setup_theme', 'woo_theme_support');

function woo_sidebar_registration()
{

  // Arguments used in all register_sidebar() calls.
  $shared_args = array(
    'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
    'after_title'   => '</h2>',
    'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
    'after_widget'  => '</div></div>',
  );

  // Footer #1.
  register_sidebar(
    array_merge(
      $shared_args,
      array(
        'name'        => esc_html__('Footer #1', 'Woo theme'),
        'id'          => 'sidebar-1',
        'description' => esc_html('Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty'),
      )
    )
  );

  // Footer #2.
  register_sidebar(
    array_merge(
      $shared_args,
      array(
        'name'        => __('Footer #2', 'Woo Theme'),
        'id'          => 'sidebar-2',
        'description' => __('Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty'),
      )
    )
  );
}

add_action('widgets_init', 'woo_sidebar_registration');
