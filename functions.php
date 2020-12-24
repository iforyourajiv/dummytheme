<?php


function add_theme_scripts() {
  wp_enqueue_style( 'style', get_stylesheet_uri() );
    if ( is_singular() & comments_open() &  get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

?>
