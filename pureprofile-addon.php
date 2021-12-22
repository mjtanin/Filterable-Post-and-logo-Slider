<?php
/**
 * Plugin Name: PureProfile Elementor Addon
 * Description: Custom widgets for Elementor.
 * Version:     1.0.0
 * Author:      Pureprofile Developer
 * Author URI:  
 * textdomain: pp
 */

final class PureProfile {
	/**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.2.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

	function register_pureprofile_widget() {

		require_once( __DIR__ . '/widgets/pprofile-slider.php' );
		require_once( __DIR__ . '/widgets/pp-filterable-post.php' );

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_PprofileSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_pp_filterable_post() );

	}

	function pp_add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'pp-widgets',
			[
				'title' => __( 'Pureprofile widgets', 'plugin-name' ),
				'icon' => 'fa fa-plug',
			]
		);

	}

	function __construct() {

        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', array($this, 'register_pureprofile_widget') );
        add_action( 'elementor/elements/categories_registered', array($this, 'pp_add_elementor_widget_categories') );
	}

}
PureProfile::instance();

add_action('wp_ajax_pp_post_action', 'pp_post_filter');
add_action('wp_ajax_nopriv_pp_post_action', 'pp_post_filter');

function pp_post_filter() {
    $wp_query = array(
        "post_type" => "post",
        "posts_per_page" => $_POST['ppp'],
        "order" => "ASC"
        
    );

    $terms = $_POST['terms'];

    $tag = $_POST['tag'];

    if ($tag === 'false') {
        $wp_query["category__in"] = $terms;
    };

    if ($tag === 'true') {
        $wp_query["tag__in"] = $terms;
    };


    $query = new WP_Query($wp_query);
    printf('<div class="display-posts post-col-%s">', $_POST['col']);

    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

    <article class="elementor-post elementor-grid-item post-id-<?= get_the_ID(); ?> post type-post status-publish format-standard has-post-thumbnail hentry category-research-news">
        <div class="elementor-post__card">
            <a href="<?php the_permalink(); ?>" class="media elementor-post__thumbnail__link">
                <div class="elementor-post__thumbnail elementor-fit-height">
                    <?php the_post_thumbnail(); ?>
                </div>
            </a>

            <div class="content elementor-post__text">
                <div class="excerpt_title">
                    <h3 class="elementor-post__title">
                        <div class="category"><?php the_category(', '); ?></div>
                        <a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>
                </div>
                
            </div>
            <div class="post-bottom">
                <p><?php echo get_the_date('m F, Y'); ?></p>
                <a class="elementor-post__read-more" href="<?php the_permalink(); ?>"></a>
            </div>
        </div>
    </article>

    <?php endwhile; wp_reset_postdata(); else:  _e( 'Sorry, no posts matched your criteria.', 'pp' ); endif; 
    echo '</div>';
    die();
}