<?php

class SocialLink {
	public $options;
	public $topBelow;
	public $below;
	public $select;
	public $position;
	public $post_types;

	public function __construct() {
		add_filter( 'the_content', [ $this, 'gshare_social_display' ] );
		add_filter( 'wp_footer', [ $this, 'gshare_social_footer_display' ], 100 );
		add_action( 'wp', array( $this, 'check_front_page' ) );	}


	public function check_front_page() {
		$this->stop = is_front_page();
	}


	/**
	 * Render the display social link
	 *
	 */
	public static function generate_frontend_bar() {
		$class       = get_option( 'style', 'theme1' );
		$socialitems = get_option( 'linksitems', [ 'facebook', 'twitter', 'linkedin' ] );
		$position_class = get_option( 'positionlink', 'bottom' );
		$custom_color = get_option('custom-color'); 

		if($position_class == 'side') {
			$location = 'gshare_sidebar_social';
		} else {
			$location = 'gshare_inline_social';
		}

		$currentURL = get_permalink();
		$currentTitle = str_replace( ' ', '%20', get_the_title());
		$currentPostImage = get_the_post_thumbnail_url( get_the_ID(), 'full' )?get_the_post_thumbnail_url( get_the_ID(), 'full' ): GSHARE_URL . '/assets/images/share-thumb.png';

		// get networks data
		ob_start();
		include plugin_dir_path( __DIR__ ) . 'dist/networks.json';
		$sociallinks = json_decode( ob_get_clean(), true);

		//  Main Style layout Class
		$main_layout1 = 'wp-block-wppool-gshare is-style-icon-and-text has-colors';
		$main_layout2 = 'wp-block-wppool-gshare has-colors';
		$main_layout3 = 'wp-block-wppool-gshare is-style-mask has-colors';

		//  Main Style layout Style Class
		$main_style1 = 'has-background has-text-color has-padding';
		$main_style2 = 'has-border-redius theme1';
		$main_style3 = 'has-border-redius__icon theme5';
		
		$output = '';

		$output .= '<div class="'. $location .'">';

		$output .= '<div class="wp-block-wppool-gshare-view__list">';
		$output .= '<ul class="social-wrapper-' . esc_attr($class) . '">';
		$output .= wp_kses_post( apply_filters( 'gshare_bfore_social_link', '' ) );
		if ( ! empty( $socialitems ) ) :
			foreach ( $socialitems as $item ) :
				
				$socialItem = null;
				foreach($sociallinks as $struct) {
					if ($item == $struct['class']) {
						$socialItem = $struct;
						break;
					}
				}				

				$params_arr = build_share_params_arr($socialItem['args'], $currentURL, $currentTitle, $currentPostImage);
				$params = http_build_query( $params_arr ) . "\n";
				$fullUrl = $socialItem['link'] . '?' . $params;

				if (array_key_exists('mediaParam', $socialItem)) {
					$fullUrl .= '&' . $socialItem['mediaParam'] . '=' . $currentPostImage;
				}

				if (array_key_exists('titleParam', $socialItem)) {
					$fullUrl .= '&' . $socialItem['titleParam'] . '=' . $currentTitle;
				}

				foreach($socialItem['args'] as $key=>$val){
					if($key != 'mediaParam' && $key != 'titleParam' && $key != 'linkParam'){
						$fullUrl .= '&' . $key . '=' . $val;
					}
				}

				$fullUrl  = apply_filters( "gshare_{$socialItem['class']}_share_url", $fullUrl );
				$output .= '<li>';
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

					$itemNameClass = $custom_color ? 'wp-block-wppool-gshare__button--custom' : 'wp-block-wppool-gshare__button--'.strtolower($socialItem['name']);

						$output .= '<div class="'.  esc_attr( $layout ) .'">';
						$output .= '<a target="_blank" href="' . esc_url($fullUrl) . '" class="wp-block-button__link wp-block-wppool-gshare__button '. $style .' '.$itemNameClass.' '. $class .'">';
								$output .= '<span class="wp-block-wppool-gshare-icon__wrapper">
												'.$socialItem['icon'].'
											</span>';
											$output .= '<span class="wp-block-wppool-gshare__text">'. ucfirst($socialItem['name']) .'</span>
										</a>
									</div>
								</li>';
				
			endforeach;
		endif;
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= wp_kses_post( apply_filters( 'kiwi_after_article_bar', '' ) );

		return $output;

	}

	public function gshare_social_display( $content = '' ) {
		$html               = '';
		$position           = get_option( 'positionlink', 'bottom' );
		$diaplay            = get_option( 'display_screen', ['post'] );
		$bar                = $this->generate_frontend_bar();
		$seleted_post_types = array();

		if ( ( ! is_single() && ! is_page() ) || $this->stop ) {
			return $content;
		}


		if ( ! empty( $diaplay ) ) {
			foreach ( $diaplay as $s ) {
				$seleted_post_types[ $s ] = $s;
			}
		}


		$post_type = get_post_type();

		if ( in_array( $post_type, $seleted_post_types ) ) {
			if ( $position == 'bottom' ) {
				$html .= $content . $bar;
			} elseif ( $position == 'top' ) {
				$html .= $bar . $content;
			} elseif ( $position == 'both' ) {
				$html .= $bar . $content . $bar;
			}
		}

		if ( empty( $html ) ) {
			return $content;
		} else {
			return $html;
		}
	}

	public function gshare_social_footer_display() {
		$this->position = get_option( 'positionlink', 'bottom' );


		if ( $this->position == 'side' ) {
			echo $this->generate_frontend_bar();
		}
	}


}

new SocialLink();