<?php

class Elementor_pp_filterable_post extends \Elementor\Widget_Base {

	public function get_name() {
		return 'pp_filterable_post';
	}

	public function get_title() {
		return esc_html__( 'Filterable post', 'pp' );
	}

	public function get_icon() {
		return 'eicon-filter';
	}

	public function get_categories() {
		return [ 'pp-widgets' ];
	}

	public function get_script_depends() {
        wp_enqueue_script( 'filter-scripts', plugins_url( '../assets/js/filter-scripts.js', __FILE__ ) );
        wp_localize_script('filter-scripts', 'ajax_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'preloader' => sprintf('<img class="preloader" src="%s"/>', plugins_url( 'pureprofile-addon/assets/css/ajax-loader.gif')),
        ));

		return [
            'filter-scripts'
		];
    }

	public function get_style_depends() {
		wp_register_style( 'filterable-post', plugins_url( '../assets/css/filterable-post.css', __FILE__ ) );

		return [
            'filterable-post'
		];

	}

    protected function register_controls() {

		$this->start_controls_section(
			'filterable_post',
			[
				'label' => __( 'Posts', 'pp' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'chose_col',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Select coloumn', 'pp' ),
				'options' => [
					'2' => esc_html__( '2', 'pp' ),
					'3' => esc_html__( '3', 'pp' ),
					'4' => esc_html__( '4', 'pp' ),
					'5' => esc_html__( '5', 'pp' ),
				],
				'default' => '3',
			]
		);

        $this->add_control(
			'chose_ppposts',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Select Post per page', 'pp' ),
				'options' => [
					'3' => esc_html__( '3', 'pp' ),
					'6' => esc_html__( '6', 'pp' ),
					'9' => esc_html__( '9', 'pp' ),
					'12' => esc_html__( '12', 'pp' ),
				],
				'default' => '9',
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
            'filterable_style',
			[
                'label' => __( 'Box Style', 'pp' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // $this->add_control(
		// 	'width',
		// 	[
		// 		'label' => esc_html__( 'Box specing Left', 'plugin-name' ),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 'px', '%' ],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 0,
		// 				'max' => 100,
		// 				'step' => 1,
		// 			],
		// 			'%' => [
		// 				'min' => 0,
		// 				'max' => 100,
		// 			],
		// 		],
		// 		'default' => [
		// 			'unit' => 'px',
		// 			'size' => 20,
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .post .content' => 'padding: {{SIZE}}{{UNIT}};',
		// 		],
        //         'separator' => 'before',
		// 	]
		// );

        $this->add_responsive_control(
			'Box spacing',
			[
				'label' => esc_html__( 'Box spacing', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .post .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Box Background', 'plugin-name' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .post .elementor-post__card',
			]
		);

        $this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .post .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section(
            'filter_menu',
			[
                'label' => __( 'Filter style', 'pp' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Category Title', 'elementor' ),
                'name' => 'cat_typography',
                'selector' => '{{WRAPPER}} .display-cats-tags .display-cats span',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label' => esc_html__( 'Category Color', 'pp' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .display-cats-tags .display-cats span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'filterae_style',
			[
                'label' => __( 'Content style', 'pp' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Category style', 'elementor' ),
                    'name' => 'category_typography',
                    'selector' => '{{WRAPPER}} .category a'
                ]
            );

            $this->add_control(
                'cats_color',
                [
                    'label' => esc_html__( 'Category Color', 'pp' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .post .category a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Title style', 'elementor' ),
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .post .content .post-title',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .post .content .post-title' => 'color: {{VALUE}}',
                    ],
                ]
            );

            
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Excerpt style', 'elementor' ),
                    'name' => 'excerpt_typography',
                    'selector' => '{{WRAPPER}} .post .content p'
                ]
            );

            $this->add_control(
                'exc_color',
                [
                    'label' => esc_html__( 'Excerpt Color', 'pp' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .post .excerpt_title > p' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'bottom_style',
			[
                'label' => __( 'Bottom', 'pp' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Date style', 'elementor' ),
                'name' => 'date_typography',
                'selector' => '{{WRAPPER}} .post .post-bottom p'
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__( 'Date Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post .post-bottom p' => 'color: {{VALUE}}',
                ],

                'separator' => 'after',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icon_background',
				'label' => esc_html__( 'Icon Background', 'plugin-name' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .post .post-bottom a',
			]
		);

        $this->end_controls_section();

	}

    protected function render() {
        
		$settings = $this->get_settings_for_display(); ?>
            <div class="filter-wrapper">
                <div class="filter-items-wrapper">
                    <p>Filter by</p>
                    <div class="filter-items">
                        <div class="filter-options">
                            <h2 data-title="topic">Topic <span class="icon-arrow"></span></h2>
                            <h2 data-title="type">Type <span class="icon-arrow"></span></h2>
                            <h2 style="display: none; " class="clear-filter">Clear all <span class="close-icon"></span></h2>
                        </div>

                        <div class="display-cats-tags">
                            <div id="post_topic">
                                <div class="display-cats cats-tags-style" data-target="topic">
                                <?php $cats = get_categories(); if(count($cats) > 0) : foreach($cats as $cat) : ?>
                                    <div class="cat-tag" data-col="<?php echo $settings['chose_col']; ?>" data-ppp="<?php echo $settings['chose_ppposts']; ?>" data-id="<?php echo $cat->term_id; ?>"><span><?php echo $cat->name; ?></span> <i class="close-icon"></i></div>
                                <?php endforeach; endif; ?>
                                </div>
                            </div>
                            
                            <div id="post_type">
                                <div class="display-cats cats-tags-style" data-target="type">
                                <?php $cats = get_tags(); if(count($cats) > 0) : foreach($cats as $cat) : ?>
                                    <div class="cat-tag" data-col="<?php echo $settings['chose_col']; ?>" data-ppp="<?php echo $settings['chose_ppposts']; ?>" data-tag="<?php echo $cat->term_id; ?>"><span><?php echo $cat->name; ?></span> <i class="close-icon"></i></div>
                                <?php endforeach; endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="filterable-posts">
                    <div class="display-posts post-col-<?php echo $settings['chose_col']; ?>">
                        <?php 

                        $ppp = $settings['chose_ppposts'];

                        $query = new WP_Query( [
                            'post_type'      => 'post',
                            'posts_per_page' => $ppp,
                        ] );

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

                        <?php endwhile; wp_reset_postdata(); else:  _e( 'Sorry, no posts matched your criteria.', 'pp' ); endif; ?>

                    </div>
                </div>
            </div>
		<?php
	}

    protected function content_template() {
		?>
        <h1>Filterable post</h1>
		<?php
	}
}