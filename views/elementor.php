<?php
namespace Gshare\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Gshare_Elementor extends Widget_Base {

    public function get_name() {
        return 'gshare_elementor';
    }

    public function get_title() {
        return esc_html__( 'Gshare Elementor', 'gshare' );
    }

    public function get_icon() {
        return 'eicon-share';
    }

    public function get_keywords() {
        return [ 'gshare', 'social', 'icons'];
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {

        // -------------------  Default Section  -----------------------//
        $this->start_controls_section(
            'Global Settings',
            [
                'label' => esc_html__( 'Global Settings', 'gshare' ),
            ]
        );

        $this->add_control(
            'global_settings',
            [
                'label' => esc_html__( 'Global Settings', 'gshare' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'ON', 'gshare' ),
				'label_off' => __( 'OFF', 'gshare' ),
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'Theme',
            [
                'label' => esc_html__( 'Theme', 'gshare' ),
                'conditions' => [ 
                    'terms' => [
                        [
                            'name' => 'global_settings',
                            'operator' => '!=',
                            'value' => 'yes'
                        ]
                    ]
                 ]
            ]
        );

        $this->add_control(
			'theme',
			[
                'label' => __( 'Theme', 'gshare' ),
                'label_block' => true,
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'theme1' => [
						'title' => __( 'Theme 1', 'gshare' ),
						'icon' => 'theme1',
                    ],
					'theme5' => [
						'title' => __( 'Theme 2', 'gshare' ),
						'icon' => 'theme5',
                    ],
					'theme6' => [
						'title' => __( 'Theme 3', 'gshare' ),
						'icon' => 'theme6',
                    ],
					'theme7' => [
						'title' => __( 'Theme 4', 'gshare' ),
						'icon' => 'theme7',
                    ],
					'theme8' => [
						'title' => __( 'Theme 5', 'gshare' ),
						'icon' => 'theme8 disabled',
                    ],
					'theme11' => [
						'title' => __( 'Theme 6', 'gshare' ),
						'icon' => 'theme11 disabled',
                    ],
					'theme12' => [
						'title' => __( 'Theme 7', 'gshare' ),
						'icon' => 'theme12 disabled'
                    ],
                    'theme2' => [
						'title' => __( 'Theme 8', 'gshare' ),
						'icon' => 'theme2 disabled',
                    ],
					'theme3' => [
						'title' => __( 'Theme 9', 'gshare' ),
						'icon' => 'theme3 disabled',
                    ],
                    'theme10' => [
						'title' => __( 'Theme 10', 'gshare' ),
						'icon' => 'theme10 disabled',
                    ],
					'theme9' => [
						'title' => __( 'Theme 11', 'gshare' ),
                        'icon' => 'theme9 disabled'
                    ],
					'theme13' => [
						'title' => __( 'Theme 12', 'gshare' ),
                        'icon' => 'theme13 disabled',
                    ],
					'theme4' => [
						'title' => __( 'Theme 13', 'gshare' ),
                        'icon' => 'theme4 disabled',
                    ],
					'theme14' => [
						'title' => __( 'Theme 14', 'gshare' ),
                        'icon' => 'theme14 disabled',
                    ]
				],
				'default' => 'theme1',
                'toggle' => true,
			]
        );

        if(!defined( 'GSHARE_PRO_VERSION' )){
            $this->add_control(
                'gshare_upgrade_note',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div class="gshare-upgrade-control"><span class="gshare-upgrade-title">'.__('More style on pro', 'gshare').'</span><span class="gshare-upgrade-description">'.__('Get more great style and features on gshare pro for $39 only', 'gshare').'</span><a target="_blank" class="gshare-upgrade-btn" href="'.esc_url('https://wppool.dev/social-media-share-button').'">'.__('Go Pro', 'gshare').'</a></div>',
                    'content_classes' => 'gshare-upgrade-note'
                ]
            );
        }

        $this->end_controls_section();

        $this->start_controls_section(
            'Customize',
            [
                'label' => esc_html__( 'Customize', 'gshare' ),
                'conditions' => [ 
                    'terms' => [
                        [
                            'name' => 'global_settings',
                            'operator' => '!=',
                            'value' => 'yes'
                        ]
                    ]
                 ]
            ]
        );

        // Rounded Cornar
        $this->add_responsive_control(
            'rounded_corner',
            [
                'label' => __('Rounded Corner', 'gshare'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-block-wppool-gshare-local .wp-block-wppool-gshare .wp-block-button__link' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wp-block-wppool-gshare-local .wp-block-wppool-gshare .wp-block-file__button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon Size
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'gshare'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '16',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-block-wppool-gshare-local span.wp-block-wppool-gshare-icon__wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wp-block-wppool-gshare-local span.wp-block-wppool-gshare-icon__wrapper svg' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wp-block-wppool-gshare-local .theme11 .wp-block-wppool-gshare-icon__wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wp-block-wppool-gshare-local .theme14 .wp-block-wppool-gshare-icon__wrapper svg' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        // Font Size
        $this->add_responsive_control(
            'font_size',
            [
                'label' => __('Font Size', 'gshare'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '16',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-block-wppool-gshare-local .wp-block-wppool-gshare .wp-block-button__link .wp-block-wppool-gshare__text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Font Size
        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => __('Item Spacing', 'gshare'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-block-wppool-gshare-view__list.wp-block-wppool-gshare-local li' => 'padding: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wp-block-wppool-gshare-view__list.wp-block-wppool-gshare-local ul' => 'margin: -{{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'custom_color',
            [
                'label' => __( 'Custom Color', 'gshare' ),
                'conditions' => [ 
                    'terms' => [
                        [
                            'name' => 'global_settings',
                            'operator' => '!=',
                            'value' => 'yes'
                        ]
                    ]
                 ]
            ]
        );

        if(!defined( 'GSHARE_PRO_VERSION' )){
            $this->add_control(
                'gshare_upgrade_note_2',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div class="gshare-upgrade-control"><span class="gshare-upgrade-title">'.__('Upgrade to Pro', 'gshare').'</span><span class="gshare-upgrade-description">'.__('Get this feature and a lot more by upgrading to gshare pro for $39 only', 'gshare').'</span><a target="_blank" class="gshare-upgrade-btn" href="'.esc_url('https://wppool.dev/social-media-share-button').'">'.__('Go Pro', 'gshare').'</a></div>',
                    'content_classes' => 'gshare-upgrade-note'
                ]
            );
        } else {
            $this->add_control(
                'gshare_el_custom_color',
                [
                    'label' => __( 'Custom Color', 'gshare' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wp-block-wppool-gshare.has-colors .wp-block-wppool-gshare__button--custom.custom-el' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare__button--custom.custom-el.theme1:hover, {{WRAPPER}} .wp-block-wppool-gshare__button--custom.custom-el.theme14:hover' => '-webkit-filter: saturate(1.5) brightness(1.2); filter: saturate(1.5) brightness(1.2);',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme4:hover .wp-block-wppool-gshare__text, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme4:focus .wp-block-wppool-gshare__text' => 'color: white',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme5' => 'background-color: transparent',
                        '{{WRAPPER}} .wp-block-wppool-gshare__button--custom.custom-el.theme5 .wp-block-wppool-gshare-icon__wrapper:before' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme5 .wp-block-wppool-gshare__text' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme5:hover .wp-block-wppool-gshare__text' => 'color: white',
                        '{{WRAPPER}} .wp-block-wppool-gshare__button--custom.custom-el.theme6:hover' => '-webkit-filter: saturate(1.5) brightness(1.2); filter: saturate(1.5) brightness(1.2);',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3 span.wp-block-wppool-gshare-icon__wrapper i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3 span.wp-block-wppool-gshare-icon__wrapper svg' => 'fill: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3 .wp-block-wppool-gshare__icon, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3 .wp-block-wppool-gshare__text' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:hover, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:focus' => 'background-color: {{VALUE}} !important',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:hover span.wp-block-wppool-gshare-icon__wrapper i, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:focus span.wp-block-wppool-gshare-icon__wrapper i' => 'color: white',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:hover span.wp-block-wppool-gshare-icon__wrapper svg, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:focus span.wp-block-wppool-gshare-icon__wrapper svg' => 'fill: white',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:hover .wp-block-wppool-gshare__text, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme3:focus .wp-block-wppool-gshare__text' => 'color: white',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme13' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare__button--custom.custom-el.theme13 .wp-block-wppool-gshare-icon__wrapper' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme13 .wp-block-wppool-gshare__text' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme13:hover .wp-block-wppool-gshare__text, {{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme13:focus .wp-block-wppool-gshare__text' => 'color: white',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme13 .wp-block-wppool-gshare__text:before' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme4' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare__button--custom.custom-el.theme4 .wp-block-wppool-gshare-icon__wrapper' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme4 .wp-block-wppool-gshare__text' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .wp-block-wppool-gshare .wp-block-wppool-gshare__button--custom.custom-el.theme4 .wp-block-wppool-gshare__text:before' => 'background-color: {{VALUE}}'
                    ],
                ]
            );
        }

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();

        $class       = get_option( 'style', 'theme1' );
        $custom_color = get_option('custom-color') ? 'custom' : '';

        //  Main Style layout Class
	    $main_layout1 = 'wp-block-wppool-gshare is-style-icon-and-text has-colors';
	    $main_layout2 = 'wp-block-wppool-gshare has-colors';
        $main_layout3 = 'wp-block-wppool-gshare is-style-mask has-colors';
        
        //  Main Style layout Style Class
        $main_style1 = 'has-background has-text-color has-padding';
        $main_style2 = 'has-border-redius theme1';
        $main_style3 = 'has-border-redius__icon theme5';

        if('yes' !== $settings['global_settings']){
            $class = isset(  $settings['theme'] ) ?  $settings['theme'] : 'theme1';
            $custom_color = $settings['gshare_el_custom_color'] ? 'custom custom-el' : '';
        }

        if ( $class == 'theme1' || $class == 'theme2'  || $class == 'theme3' || $class == 'theme4' || $class == 'theme5'  || $class == 'theme7') {
			$layout = $main_layout1;
			$style = $main_style1; 
		}elseif($class == 'theme6' ){
			$layout = $main_layout2;
			$style = $main_style1; 
		}elseif($class == 'theme8' ){
			$layout = $main_layout3;
			$style = $main_style1; 
		}elseif($class == 'theme9' ){
			$layout = $main_layout1;
			$style = $main_style2; 
		}elseif($class == 'theme10'){
			$layout = $main_layout1;
			$style = $main_style3; 
		}elseif($class == 'theme11'){
			$layout = $main_layout2;
			$style = $main_style1; 
		}elseif($class == 'theme12'){
			$layout = $main_layout3;
			$style = $main_style1; 
		}else{
			$layout = $main_layout1;
			$style = $main_style1;
		}

        global $post;
        $link = get_the_permalink();
        $title = get_the_title();

        // Get the featured image.
        if ( has_post_thumbnail() ) {
            $thumbnail_id = get_post_thumbnail_id( $post->ID );
            $thumbnail    = $thumbnail_id ? current( wp_get_attachment_image_src( $thumbnail_id, 'large', true ) ) : '';
        } else {
            $thumbnail = null;
        }
        $image = esc_url( $thumbnail );

        // get the active networks
        $activeNetworks = get_option( 'linksitems', [ 'facebook', 'twitter', 'linkedin' ]);

        // get networks data
        ob_start();
        if(!defined( 'GSHARE_PRO_VERSION' )){
            include plugin_dir_path( __DIR__ ) . 'dist/networks.json';
        } else {
            include GSHARE_PRO_FILE_PATH . 'dist/networks.json';
        }        
        $networks = json_decode( ob_get_clean(), true);

        // filter out active networks to display
        $displayNetworks = array_filter($networks, function($n) use($activeNetworks) {
            return in_array($n['class'], $activeNetworks);
        });
        ?>
        <div class="wp-block-wppool-gshare-view__list <?php echo ('yes' !== $settings['global_settings']) ? 'wp-block-wppool-gshare-local': '' ?>">
            <ul class="social-wrapper-<?php echo esc_attr($class); ?>">
                <?php 
                foreach ( $displayNetworks as $i => $net ) {
                    $params_arr = build_share_params_arr($net['args'], $link, $title, $image);
                    if (array_key_exists('app_id', $net['args'])) {
                        $params_arr['app_id'] = $net['args']['app_id'];
                    }
                    if (array_key_exists('display', $net['args'])) {
                        $params_arr['display'] = $net['args']['display'];
                    }
                    $params = http_build_query( $params_arr ) . "\n";
                    $share_link = $net['link'] . '?' . $params;
                    $share_link  = apply_filters( "gshare_{$net['class']}_share_url", $share_link );
                    ?>
                    <li>
                        <div class="<?php echo esc_attr( $layout ); ?>">
                            <a target="_blank" href="<?php echo esc_url($share_link); ?>" class="wp-block-button__link wp-block-wppool-gshare__button <?php echo esc_attr($style); ?>  wp-block-wppool-gshare__button--<?php echo $custom_color ? $custom_color : strtolower($net['name']); ?> <?php echo esc_attr($class); ?>">
                                <span class="wp-block-wppool-gshare-icon__wrapper">
                                    <?php echo $net['icon']; ?>
                                </span>
                                <span class="wp-block-wppool-gshare__text"><?php echo __($net['name']); ?></span>
                            </a>
                        </div>
                    </li>
                    <?php 
                }
                ?>
            </ul>
        </div>
        <?php 
    }
}
