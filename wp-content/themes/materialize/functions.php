<?php
/**
 * Materialize functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Materialize
 */

if ( ! function_exists( 'materialize_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function materialize_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Materialize, use a find and replace
	 * to change 'materialize' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'materialize', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'materialize' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'materialize_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'materialize_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function materialize_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'materialize_content_width', 640 );
}
add_action( 'after_setup_theme', 'materialize_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function materialize_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'materialize' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div class="card"><section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'materialize_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function materialize_scripts() {


	wp_enqueue_script( 'materialize-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
wp_enqueue_style( 'Material-fonts', 'https://fonts.googleapis.com/icon?family=Material+Icons'); 

wp_enqueue_style( 'material-style', get_template_directory_uri() . '/css/materialize.min.css', array(), true );
wp_enqueue_style( 'materialize-style', get_stylesheet_uri() );
wp_enqueue_script( 'material-script', get_template_directory_uri() . '/js/materialize.js', array(), '1.0', false );	
wp_enqueue_script( 'material-custom', get_template_directory_uri() . '/js/scripts.js', array(), '1.0', false );

	$themecolors = get_theme_mod( 'material_colors' );
	
	// Enqueue the selected color schema
	wp_enqueue_style( 'material-colors', get_template_directory_uri() . '/css/'. $themecolors );   
	
}
add_action( 'wp_enqueue_scripts', 'materialize_scripts' );


// Add Material scripts and styles
if( !is_admin()){
	
	wp_deregister_script('jquery');
	wp_enqueue_script( 'material-jquery', 'http://code.jquery.com/jquery-2.1.3.min.js', array(), '1.0', false );

}


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';





// avatar替换

function materialize_get_avatar($avatar) {
$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"gravatar.duoshuo.com",$avatar);
return $avatar;
}
add_filter( 'get_avatar', 'materialize_get_avatar', 10, 3 );




// Add theme options

function material_controls( $wp_customize ) {

// Add a section to customizer.php
	$wp_customize->add_section( 'material_options' , 
		array(
  		'title'      => __( 'Material Options', 'materialize' ),
  		'description' => 'The following theme options are available:',
  		'priority'   => 30,
		)
	);
	
// Add setting
	$wp_customize->add_setting(
    'material_colors',
    array(
        'default' => 'blue.css',
    )
	);
	
// Add control	
	$wp_customize->add_control(
    'material_color_selector',
    array(
        'label' => 'Color Scheme',
        'section' => 'material_options',
        'settings' => 'material_colors',
        'type' => 'select',
        'choices' => array(
            'blue.css' => 'Blue',
            'red.css' => 'Red',
            'green.css' => 'Green',
            'orange.css' => 'Orange',
        ),
    )
);

}
add_action( 'customize_register', 'material_controls' );

// Check our theme options selections, and load conditional styles


Class My_Recent_Posts_Widget extends WP_Widget_Recent_Posts {
 
	function widget($args, $instance) {
	
		extract( $args );
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
				
		if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 10;
					
		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if( $r->have_posts() ) :
			
			echo $before_widget;
			if( $title ) echo $before_title . $title . $after_title; ?>
			<ul class="collection rpwidget">
				<?php while( $r->have_posts() ) : $r->the_post(); ?>				
				<li class="collection-item avatar">
					<?php echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft circle' ) ); ?>
					<span class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></span>
					<p>by <?php the_author(); ?> on <?php echo get_the_date(); ?></p>
				</li>
				<?php endwhile; ?>
			</ul>
			 
			<?php
			echo $after_widget;
		
		wp_reset_postdata();
		
		endif;
	}
}
function my_recent_widget_registration() {
  unregister_widget('WP_Widget_Recent_Posts');
  register_widget('My_Recent_Posts_Widget');
}
add_action('widgets_init', 'my_recent_widget_registration');



// Dress up the post navigation
 
add_filter( 'next_post_link' , 'my_nav_next' , 10, 4);
add_filter( 'previous_post_link' , 'my_nav_previous' , 10, 4);
 
function my_nav_next($output, $format, $link, $post ) {
 $text = ' previous post';
 $rel = 'prev';
 
 return sprintf('<a href="%1$s" rel="%3$s" rel="nofollow" class="waves-effect waves-light btn left"><span class="white-text"><i class="mdi-navigation-chevron-left left"></i>%2$s</span></a>' , get_permalink( $post ), $text, $rel );
}
 
function my_nav_previous($output, $format, $link, $post ) {
 $text = ' next post';
 $rel = 'next';
 
 return sprintf('<a href="%1$s" rel="%3$s" rel="nofollow" class="waves-effect waves-light btn right"><span class="white-text">%2$s<i class="mdi-navigation-chevron-right right"></i></span></a>' , get_permalink( $post ), $text, $rel );
}



// Custom comment functionality
 
add_filter('get_avatar','change_avatar_css');
 
function change_avatar_css($class) {
$class = str_replace("class='avatar", "class='avatar circle left z-depth-1", $class) ;
return $class;
}
 
add_filter('comment_reply_link', 'materialize_reply_link_class');
 
 
function materialize_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='waves-effect waves-light btn", $class);
    return $class;
}
 
function materialize_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
 
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
		<?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
		?>
	</div>
	<?php printf( __( '<cite class="fn">%s</cite> <span class="says">wrote:</span>' ), get_comment_author_link() ); ?>
	</div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<br />
	<?php endif; ?>
 
 
	<?php comment_text(); ?>
 
	<div class="reply right">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	<div class="clear"></div>
	</div>
	<?php endif; ?>
	<div class="divider"></div>
<?php
}