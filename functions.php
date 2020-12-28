<?php


// Add Theme  CSS and Scripts

function add_theme_scripts()
{
  wp_enqueue_style('style', get_stylesheet_uri());
  if (is_singular() & comments_open() &  get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');


// Menu Registration


function register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('menu')
    )
  );
}
add_action('init', 'register_my_menus');


// BreadCrumb

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


//  Theme Support

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
  add_theme_support('post-formats',  array('aside', 'gallery', 'quote', 'image', 'video'));


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
}

add_action('widgets_init', 'woo_sidebar_registration');



// Our custom post type function
function create_posttype()
{

  register_post_type(
    'portfolio',
    // CPT Options
    array(
      'labels' => array(
        'name' => __('Portfolio'),
        'singular_name' => __('Portfolio'),
        'add_new'        => ('Add New Portfolio'),
      ),
      'public' => true,
      'has_archive' => true,
      'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail',),
      'rewrite' => array('slug' => 'portfolio'),
      'show_in_rest' => true,

    )
  );
}


add_action('init', 'create_posttype');


// Creating the widget For Custom Post Type (Portfolio)
class portfolio_widget extends WP_Widget
{

  function __construct()
  {
    parent::__construct(

      // Base ID of your widget
      'portfolio_widget',

      // Widget name will appear in UI
      __('portfolio_widget', 'portfolio_widget_domain'),

      // Widget description
      array('description' => __('Get All Portfolio Listing', 'portfolio_widget_domain'),)
    );
  }

  // Creating widget front-end

  public function widget($args, $instance)
  {
    $title = apply_filters('widget_title', $instance['title']);

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if (!empty($title))
      echo $args['before_title'] . $title . $args['after_title'];

    // This is where We run the code and display the Portfolio Listing
    global $post;
    add_image_size('realty_widget_size', 85, 45, false);
    $listings = new WP_Query();
    $listings->query('post_type=portfolio &posts_per_page=' . $numberOfListings);
    if ($listings->found_posts > 0) {
      echo '<ul class="realty_widget">';
      while ($listings->have_posts()) {
        $listings->the_post();
        $image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'realty_widget_size') : '<div class="noThumb"></div>';
        $listItem = '<li>' . $image;
        $listItem .= '<a href="' . get_permalink() . '">';
        $listItem .= get_the_title() . '</a>';
        // $listItem .= '<br><span style="color:red">Added ' . get_the_date() . '</span></li>';
        echo $listItem;
      }
      echo '</ul>';
      wp_reset_postdata();
    } else {
      echo '<p style="padding:25px;">No listing found</p>';
    }
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form($instance)
  {
    if (isset($instance['title'])) {
      $title = $instance['title'];
    } else {
      $title = __('New title', 'portfolio_widget_domain');
    }
    // Widget admin form
?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
<?php
  }

  // Updating widget replacing old instances with new
  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    return $instance;
  }

  // Class  ends here
}


// Register and load the widget
function portfolio_widget_widget()
{
  register_widget('portfolio_widget');
}
add_action('widgets_init', 'portfolio_widget_widget');
