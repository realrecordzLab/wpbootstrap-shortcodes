<?php

/*
* Plugin Name: Bootstrap Shortcodes
* Author: Bruno Paolillo
* Author URI:
* Version: 2.0
* Description:
*
*/

/*
* Prevent direct access to the plugin file
*
*/

if( !defined('ABSPATH') ){
  exit;
}

/**
 * Defining plugin directory
 */

define( 'PLUGIN_DIR', plugin_dir_url(__FILE__) );

/**
 * Defining allowed HTML content tags
 */

define( 'ALLOWED_TAGS', '<h1><h2><h4><p><a><i><span><div><img><button><form>' );

class BootstrapShortcodes {

  private $args;
  private $attr;
  private $class;
  private $container;
  private $col;
  private $content;
  private $id;
  private $img;
  private $images;
  private $is_section;
  private $mobile;
  private $src;
  private $tag;
  private $type;

  /**
   * Scripts enqueuequing and shortcodes loading
   */

  public function __construct()
  {
    add_action( 'wp_enqueue_scripts' , array( $this, 'initBootstrap' ) );
    add_action( 'wp_enqueue_scripts' , array( $this, 'initParallax' ) );
    add_action( 'wp_enqueue_scripts' , array( $this, 'initSwiper' ) );
    add_shortcode( 'bs-container', array( $this, 'contentWrapper' ) );
    add_shortcode( 'bs-col', array( $this, 'colWrapper' ) );
    add_shortcode( 'bs-parallax', array( $this, 'parallaxSection' ) );
    add_shortcode( 'bs-slider', array( $this, 'imageSlider' ) );
    add_shortcode( 'bs-modal', array( $this, 'modalPopup' ) );
    remove_filter( 'the_content', 'wpautop' );
  }

  /**
   * Check if Bootstrap js and css are loaded otherwise load them
   */

  public function initBootstrap() : void
  {
    if( !wp_script_is( 'popper-js' , 'enqueued' ) ){
      wp_enqueue_script( 'popper' , PLUGIN_DIR.'/js/popper.min.js', array('jquery') );
    }

    if( !wp_script_is( 'bootstrap-js' , 'enqueued' ) ){
      wp_enqueue_script( 'bootstrap' , PLUGIN_DIR.'/js/bootstrap.min.js', array('jquery') );
    }

    if( !wp_style_is( 'bootstrap-css' , 'enqueued' ) ){
      wp_enqueue_style( 'bootstrap' , PLUGIN_DIR.'/css/bootstrap.min.css' );
    }
  }

  /**
   * Check if Universal parallax library is loaded otherwise load them
   */

  public function initParallax() : void
  {
    if( !wp_script_is( 'parallax-js' , 'enqueued' ) ){
      wp_enqueue_script( 'parallax' , PLUGIN_DIR.'/js/universal-parallax.min.js' );
    }

    if( !wp_style_is( 'parallax-css' , 'enqueued' ) ){
      wp_enqueue_style( 'parallax-css' , PLUGIN_DIR.'/css/universal-parallax.min.css' );
    }
  }

  /**
   * Check if Swiper library is loaded otherwise load them
   */

  public function initSwiper() : void
  {
    if( !wp_script_is( 'swiper-js' , 'enqueued' ) ){
      wp_enqueue_script( 'swiper' , PLUGIN_DIR.'/js/swiper.min.js' );
    }

    if( !wp_style_is( 'swiper-css' , 'enqueued' ) ){
      wp_enqueue_style( 'swiper-css' , PLUGIN_DIR.'/css/swiper.min.css' );
    }
  }

  /**
   * Shortcode for Bootstrap grid containers
   * @param  array $attr - Shortcode custom params
   * @param  string $content - The content enclosed between the shortcode
   * @return string - HTML code to replace the shortcode with
   */

  public function contentWrapper( array $attr, string $content ) : string
  {
    $content = strip_tags( $content, ALLOWED_TAGS );

    extract(shortcode_atts(
      array(
        'type' => null,
        'class' => null,
        'id' => null
      ), $attr)
    );

    $container = '';

    if( $type != 'container' ){
      $container = '<div class="container-fluid '. $class .'" id="'. $id .'"><div class="row">'. do_shortcode( $content ) .'</div></div>';
    }
    else{
      $container = '<div class="container '. $class .'" id="'. $id .'"><div class="row">'. do_shortcode( $content ) .'</div></div>';
    }

    return $container;
  }

  /**
   * Shortcode for Bootstrap grid columns
   * @param  array $attr - Shortcode custom params
   * @param  string $content - The content enclosed between the shortcode
   * @return string - HTML code to replace the shortcode with
   */

  public function colWrapper( array $attr, string $content ) : string
  {
    $content = strip_tags( $content, ALLOWED_TAGS );

    extract(shortcode_atts(
      array(
        'type' => null,
        'class' => null,
        'id' => null,
        'mobile' => 'display'
      ), $attr)
    );

    $col = '';

    if( $mobile != 'hide' ){
      $col = '<div class="col-sm-'. $type .' col-md-'. $type .' col-lg-'. $type .' '. $class .'" id="'. $id .'">'. do_shortcode( $content ) .'</div>';
    }
    else{
      $col = '<div class="col-md-'. $type .' col-lg-'. $type .' d-none d-sm-none d-md-block '. $class .'" id="'. $id .'">'. do_shortcode( $content ) .'</div>';
    }

    return $col;
  }

  /**
   * Shortcode for Bootstrap Jumbotron component with parallax effect
   * @param  array $attr - Shortcode custom params
   * @param  string $content - The content enclosed between the shortcode
   * @return string - HTML code to replace the shortcode with
   */

  public function parallaxSection( array $attr, string $content ) : string
  {
    ob_start();
    $content = strip_tags( $content, ALLOWED_TAGS );

    extract(shortcode_atts(
      array(
        'img' => null,
        'class' => null,
        'id' => null,
        'is_section' => false,
      ), $attr)
    );

    if( $is_section != 'true' ){
      ?>
        <div class="jumbotron jumbotron-fluid <?php echo $class; ?>" id="<?php echo $id; ?>">
          <div class="parallax" data-parallax-image="<?php echo $img; ?>"></div>
          <div class="overlay"></div>
        </div>
       <?php
    }
    else{
      ?>
        <div class="jumbotron jumbotron-fluid <?php echo $class; ?>" id="<?php echo $id; ?>" style="height:100vh;">
          <div class="parallax" data-parallax-image="<?php echo $img; ?>"></div>
            <div class="container parallax-content">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="z-index:400;"><?php echo $content; ?></div>
              </div>
            </div>
          <div class="overlay"></div>
        </div>
      <?php
    }

    return ob_get_clean();
  }

  /**
   * Shortcode for Swiper image slider
   * @param  array $attr - Shortcode custom params
   * @param  string $content - The content enclosed between the shortcode
   * @return string - HTML code to replace the shortcode with
   */

  public function imageSlider( array $attr, string $content ) : string
  {
    ob_start();
    $content = strip_tags( $content, ALLOWED_TAGS );

    extract(shortcode_atts(
      array(
        'class' => null,
        'id' => null
      ), $attr)
    );

    $args = array(
      'post_status'    => 'inherit',
      'post_type'      => 'attachment',
      'post_mime_type' => 'image',
      'posts_per_page' => -1,
    );

    $images = new WP_Query( $args );
    $img = [];

    foreach( $images->posts as $image ){
      $img[] = wp_get_attachment_url( $image->ID );
    }

    ?>
      <div class="swiper-container <?php echo $class; ?>" id="<?php echo $id; ?>">
        <div class="swiper-wrapper">
          <?php
            foreach( $img as $src ){
          ?>
            <img class="swiper-slide img-fluid w-100" src="<?php echo $src; ?>">
          <?php
            }
          ?>
        </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
      </div>
    <?php

    return ob_get_clean();
  }


  /**
   * Shortcode for Bootstrap modal popup
   * @param  array $attr - Shortcode custom params
   * @param  string $content - The content enclosed between the shortcode
   * @return string - HTML code to replace the shortcode with
   */
  public function modalPopup( array $attr, string $content ) : string
  {
    ob_start();
    $content = strip_tags( $content, ALLOWED_TAGS );

    extract(shortcode_atts(
      array(
        'class' => null,
        'id' => null
      ), $attr)
    );
    ?>
      <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo $id; ?>">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body"><?php echo do_shortcode( $content ); ?></div>
          </div>
        </div>
      </div>
    <?php

    return ob_get_clean();
  }

}

new BootstrapShortcodes;

?>
