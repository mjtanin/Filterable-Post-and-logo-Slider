<?php

class Elementor_PprofileSlider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'pp_logo_slider';
	}

	public function get_title() {
		return esc_html__( 'Logo slider', 'pp' );
	}

	public function get_icon() {
		return 'eicon-slider-device';
	}

	public function get_categories() {
		return [ 'pp-widgets' ];
	}

	public function get_script_depends() {
        
        wp_register_script( 'slick-slider', plugins_url( '../assets/js/slick.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_script( 'custom-scripts', plugins_url( '../assets/js/scripts.js', __FILE__ ), array('jquery'), false, true );

		return [
			'slick-slider',
            'custom-scripts'
		];
    }

	public function get_style_depends() {

		wp_register_style( 'slick-css', plugins_url( '../assets/css/slick.css', __FILE__ ) );
		wp_register_style( 'logo-slider-css', plugins_url( '../assets/css/logo-slider.css', __FILE__ ) );

		return [
			'slick-css',
            'logo-slider-css'
		];

	}

    protected function register_controls() {

		$this->start_controls_section(
			'_section_slides',
			[
				'label' => __( 'Slides', 'pp' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'chose_layout',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Select layout', 'pp' ),
				'options' => [
					'default' => esc_html__( 'Default', 'pp' ),
					'three_col' => esc_html__( 'Three coloumn', 'pp' ),
				],
				'default' => 'default',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} h2',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label' => __( 'Image', 'pp' ),
			]
		);

		$repeater->add_control(
			'title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'pp' ),
				'placeholder' => __( 'Type title here', 'pp' ),
				
			]
		);

		$placeholder = [
			'image' => [
				// 'url' => Utils::get_placeholder_image_src(),
			],
		];

		$this->add_control(
			'slides',
			[
				'show_label' => false,
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "Carousel Item"); #>',
				'default' => array_fill( 0, 2, $placeholder )
			]
		);

		$this->end_controls_section();

	}

    protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}
        $classes = 'three_col' == $settings['chose_layout'] ? 'pp-logo-three_slider-init' : 'pp-logo-default_slider-init';
		?>

		<div class="<?php echo $classes; ?> pp-logo-slider-init">

			<?php 

            if('three_col' == $settings['chose_layout']) : foreach ( $settings['slides'] as $slide ) : 
                $image = wp_get_attachment_image_url( $slide['image']['id'] );
    
                    if ( ! $image ) {
                        $image = $slide['image']['url'];
                    }  
                ?>

                <div class="pp-slick-slide">
					<div class="pp-slick-item">
						
                        <div class="pp-slide-image">
                            <?php if ( $image ) : ?>
                                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                            <?php endif; ?>
                        </div>

						<?php if ( $slide['title'] ) {
                            printf('<h2>%s</h2>', $slide['title']);
                        } ?>
					</div>
				</div>

			<?php endforeach; else: 
            $total = count($settings['slides']) / 2;
            $separete = array_chunk($settings['slides'], $total);
            for($i = 0; $i < count($separete); $i++) :
        
                foreach ( $separete[$i] as $slide ) :
                    
                    $image = wp_get_attachment_image_url( $slide['image']['id'] );
    
                    if ( ! $image ) {
                        $image = $slide['image']['url'];
                    } 
            ?>

                <div class="pp-slick-slide">
					<div class="pp-slick-item">
                        <div class="pp-slide-image">
                            <?php if ( $image ) : ?>
                                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                            <?php endif; ?>
                        </div>

						<?php if ( $slide['title'] ) {
                            printf('<h2>%s</h2>', $slide['title']);
                        } ?>
					</div>
				</div>

                
            <?php endforeach; endfor; endif; ?>

		</div>

		<?php
	}

    protected function content_template() {
		?>
        <div class="pp-logo-slider-init pp-logo-three_slider-init pp-logo-default_slider-init">
		<# _.each( settings.slides, function( slide ) { 
            if(settings.chose_layout == 'three_col') {

                #>
                <div class="pp-slick-slide">
                    <div class="pp-slick-item">
                        <div class="pp-slide-image">
                            <img src="{{ slide.image.url }}">
                        </div>
                        <h2>{{{ slide.title }}}</h2>
                    </div>
                </div>
                <#

            } else 
            #>
            <div class="pp-slick-slide">
                <div class="pp-slick-item">
                        <div class="pp-slide-image">
                            <img src="{{ slide.image.url }}">
                        </div>
                    <h2>{{{ slide.title }}}</h2>
                </div>
            </div>
		<# }); #>
        </div>
		<?php
	}
}