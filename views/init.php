<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// build share params array 
function build_share_params_arr($params, $link, $title, $image){
	if(!is_array($params))
		return;
	$params_formated = [];
	foreach($params as $k => $v){
		switch($k){
			case 'linkParam':
				$params_formated[$v] = $link;
				break;
			case 'titleParam':
				$params_formated[$v] = $title;
				break;
			case 'titleParam':
				$params_formated[$v] = $title;
				break;			
			case 'mediaParam':
				$params_formated[$v] = $image;
				break;
			case 'app_id':
				$params_formated['app_id'] = $params[$k];
				$params_formated['redirect_uri'] = $link;
			default:
				break;
		}
	}
	return $params_formated;
}

/**
 * Renders the block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content.
 */
function wppool_render_gshare_block($attributes){

	// Main style class
	$class       = get_option( 'style', 'theme1' );

	//  Main Style layout Class
	$main_layout1 = 'wp-block-wppool-gshare is-style-icon-and-text has-colors';
	$main_layout2 = 'wp-block-wppool-gshare has-colors';
	$main_layout3 = 'wp-block-wppool-gshare is-style-mask has-colors';

	//  Main Style layout Style Class

	$main_style1 = 'has-background has-text-color has-padding';
	$main_style2 = 'has-border-redius theme1';
	$main_style3 = 'has-border-redius__icon theme5';


	global $post;
	// get the active networks
	$activeNetworks = get_option( 'linksitems', [ 'facebook', 'twitter', 'linkedin' ]);

	// get networks data
	ob_start();
	include plugin_dir_path( __DIR__ ) . 'dist/networks.json';
	$networks = json_decode( ob_get_clean(), true);

	// filter out active networks to display
	$displayNetworks = array_filter($networks, function($n) use($activeNetworks) {
		return in_array($n['class'], $activeNetworks);
	});

	// Get the featured image.
	if ( has_post_thumbnail() ) {
		$thumbnail_id = get_post_thumbnail_id( $post->ID );
		$thumbnail    = $thumbnail_id ? current( wp_get_attachment_image_src( $thumbnail_id, 'large', true ) ) : '';
	} else {
		$thumbnail = null;
	}

	// share data 
	$link = get_the_permalink();
	$title = get_the_title();
	$image = esc_url( $thumbnail );

	// Attributes.
	$global_settings = is_array( $attributes ) && isset( $attributes['globalSetting'] ) ? $attributes['globalSetting'] : true;
	$modifiedTheme = is_array( $attributes ) && isset( $attributes['modifiedTheme'] ) ? $attributes['modifiedTheme'] : false;

	$background_color = is_array( $attributes ) && isset( $attributes['blockBackgroundColor'] ) ? "background-color:{$attributes['blockBackgroundColor']};" : 'transparent';
	$border_color = is_array( $attributes ) && isset( $attributes['blockBorderColor'] ) ? "border-color:{$attributes['blockBorderColor']};" : 'transparent';
	$border_radius    = is_array( $attributes ) && isset( $attributes['borderRadius'] ) ? "border-radius: {$attributes['borderRadius']}px;" : '';
	$has_padding      = is_array( $attributes ) && isset( $attributes['padding'] ) ? 'has-padding' : '';

	$uniqueId = is_array( $attributes ) && isset( $attributes['uniqueId'] ) ? $attributes['uniqueId'] : 'uniqueid';

	if( is_array( $attributes ) && isset( $attributes['itemSpacing'] ) && $global_settings == false ){
		$item_spacing = 'padding:' . ((int)$attributes['itemSpacing'])/2 . 'px';
		$item_wrapper_spacing = 'margin:' . (0 - ((int)$attributes['itemSpacing'])/2) . 'px';
	} else {
		$item_spacing = '';
		$item_wrapper_spacing = '';
	}
	
	if(is_array( $attributes) && isset( $attributes['paddingBox'] )){

		$block_padding = '';

		foreach($attributes['paddingBox'][0] as $key => $value){
			if(!($key == 'linked')){
				$block_padding .= "padding-{$key}: {$value}px;";
			}
		}
	} else {
		$block_padding = 'padding: 0;';
	}

	if(is_array( $attributes) && isset( $attributes['borderBox'] )){

		$block_border = '';

		foreach($attributes['borderBox'][0] as $key => $value){
			if(!($key == 'linked')){
				$block_border .= "border-{$key}-width: {$value}px;";
			}
		}
	} else {
		$block_border = 'border-width: 0;';
	}

	if(is_array( $attributes) && isset( $attributes['marginBox'] )){

		$block_margin = '';

		foreach($attributes['marginBox'][0] as $key => $value){
			if(!($key == 'linked')){
				$block_margin .= "margin-{$key}: {$value}px;";
			}
		}
	} else {
		$block_margin = 'margin: 0;';
	}
	
	$has_background          = '';
	$background_color_class  = '';
	$custom_background_color = '';
	$has_color               = '';
	$text_color_class        = '';
	$custom_text_color       = '';
	$icon_size               = '';
	$padding                 = '';

	
	if(!$global_settings){
		$class = is_array( $attributes ) && isset( $attributes['blockTheme'] ) ? $attributes['blockTheme'] : 'theme1';
	}

	if ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-mask' ) !== false ) {
		$has_background          = is_array( $attributes ) && isset( $attributes['hasColors'] ) && ( isset( $attributes['backgroundColor'] ) || isset( $attributes['customBackgroundColor'] ) ) && ( $attributes['hasColors'] || ( $attributes['backgroundColor'] || $attributes['customBackgroundColor'] ) ) ? 'has-text-color' : '';
		$background_color_class  = is_array( $attributes ) && isset( $attributes['backgroundColor'] ) ? "has-{$attributes['backgroundColor']}-color" : false;
		$custom_background_color = is_array( $attributes ) && isset( $attributes['customBackgroundColor'] ) && isset( $attributes['hasColors'] ) && ( ! $attributes['hasColors'] && ! isset( $attributes['backgroundColor'] ) ) ? "color: {$attributes['customBackgroundColor']};" : '';
	} else {
		$has_background          = is_array( $attributes ) && isset( $attributes['hasColors'] ) && ( isset( $attributes['backgroundColor'] ) || isset( $attributes['customBackgroundColor'] ) ) && ( $attributes['hasColors'] || ( isset( $attributes['backgroundColor'] ) || $attributes['customBackgroundColor'] ) ) ? 'has-background' : '';
		$background_color_class  = is_array( $attributes ) && isset( $attributes['backgroundColor'] ) ? "has-{$attributes['backgroundColor']}-background-color" : false;
		$custom_background_color = is_array( $attributes ) && isset( $attributes['customBackgroundColor'] ) && isset( $attributes['hasColors'] ) && ( ! $attributes['hasColors'] && ! isset( $attributes['backgroundColor'] ) ) ? "background-color: {$attributes['customBackgroundColor']};" : '';

		$has_color         = is_array( $attributes ) && isset( $attributes['hasColors'] ) && ( isset( $attributes['textColor'] ) || isset( $attributes['customTextColor'] ) ) && ( $attributes['hasColors'] || ( isset( $attributes['textColor'] ) || $attributes['customTextColor'] ) ) ? 'has-text-color' : '';
		$text_color_class  = is_array( $attributes ) && isset( $attributes['textColor'] ) ? "has-{$attributes['textColor']}-color" : false;
		$custom_text_color = is_array( $attributes ) && isset( $attributes['customTextColor'] ) && isset( $attributes['hasColors'] ) && ( ! $attributes['hasColors'] && ! isset( $attributes['textColor'] ) ) ? "color: {$attributes['customTextColor']};" : '';
	}

	$icon_size = is_array( $attributes ) && isset( $attributes['iconSize'] ) ? "font-size:{$attributes['iconSize']}px;" : '';
	$icon_size_svg = is_array( $attributes ) && isset( $attributes['iconSize'] ) ? "height:{$attributes['iconSize']}px;" : '';
	$text_size = is_array( $attributes ) && isset( $attributes['textSize'] ) ? "font-size:{$attributes['textSize']}px;" : '';

	if ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-circular' ) !== false ) {
		$padding = is_array( $attributes ) && isset( $attributes['padding'] ) ? "padding:{$attributes['padding']}px;" : '';
	}

	// Start markup.
	$markup = '';
	$modifiedStyle = '';

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
		
		// Apply filters, so that the social URLs can be modified.
		$share_link  = apply_filters( "gshare_{$net['class']}_share_url", $share_link );
		
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

		if($global_settings != false){
			$markup .= '<li>
			<div class="'.  esc_attr( $layout ) .'">
				<a target="_blank" href="'.esc_url($share_link).'" class="wp-block-button__link wp-block-wppool-gshare__button '. $style .'  wp-block-wppool-gshare__button--'.$net['class'].' '. $class .'">
					<span class="wp-block-wppool-gshare-icon__wrapper">'. $net['icon'] .'</span>
					<span class="wp-block-wppool-gshare__text">'.$net['name'].'</span>
				</a>
			</div>
		</li>';
		} else {
			if($modifiedTheme){
				$markup .= '<li style="'.esc_attr($item_spacing).'">
								<div class="'.  esc_attr( $layout ) .'">
									<a target="_blank" href="'.esc_url($share_link).'" class="wp-block-button__link wp-block-wppool-gshare__button '. $style .'  wp-block-wppool-gshare__button--'.$net['class'].' '. $class .'" style="'.$border_radius.'">
										<span class="wp-block-wppool-gshare-icon__wrapper" style="'.$icon_size.'">'. $net['icon'] .'</span>
										<span class="wp-block-wppool-gshare__text" style="'.$text_size.'">'.$net['name'].'</span>
									</a>
								</div>
							</li>';
				$modifiedStyle = '<style>.gshare-' . $uniqueId . ' span.wp-block-wppool-gshare-icon__wrapper svg{'.$icon_size_svg.'}</style>';
			} else {
				$markup .= '<li style="'.esc_attr($item_spacing).'">
							<div class="'.  esc_attr( $layout ) .'">
								<a target="_blank" href="'.esc_url($share_link).'" class="wp-block-button__link wp-block-wppool-gshare__button '. $style .'  wp-block-wppool-gshare__button--'.$net['class'].' '. $class .'">
									<span class="wp-block-wppool-gshare-icon__wrapper">'. $net['icon'] .'</span>
									<span class="wp-block-wppool-gshare__text">'.$net['name'].'</span>
								</a>
							</div>
						</li>';
			}
		}

		
	}

	// Build classes.
	$wrapClass = 'wp-block-wppool-gshare-view__list gshare-' . $uniqueId; 

	// Render block content.
	$block_content = sprintf(
		'<div class="%1$s" style="%2$s%3$s%5$s%6$s%7$s%8$s"><ul class="social-wrapper-%9$s" style="%10$s">%4$s</ul>%11$s</div>',
		esc_attr( $wrapClass ),
		esc_attr( $background_color ),
		esc_attr($border_color),
		$markup,
		esc_attr($block_padding),
		esc_attr($block_border),
		esc_attr($block_margin),
		'border-style: solid;',
		esc_attr($class),
		esc_attr($item_wrapper_spacing),
		$modifiedStyle
	);

	return $block_content;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
if(function_exists('register_block_type')){
	function gshare_assets_load() { 
		wp_register_style(
			'gshare-style-css', 
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), 
			array( 'wp-editor' ),
			null
		);

		// Register block editor script for backend.
		wp_register_script(
			'gshare-block-js', // Handle.
			plugins_url( 'dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), 
			null,
			true 
		);

		// Register block editor styles for backend.
		wp_register_style(
			'gshare-block-editor-css', // Handle.
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), 
			array( 'wp-edit-blocks' ), 
			null 
		);

		// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
		wp_localize_script(
			'gshare-block-js',
			'gshareGlobal',
			[
				'pluginDirPath' => plugin_dir_path( __DIR__ ),
				'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
				'activeNetworks'=> get_option( 'linksitems', [ 'facebook', 'twitter', 'linkedin' ] ),
				'currentStyle' => get_option( 'style', 'theme1' )
			]
		);
		
		// Load attributes from block.json
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../dist/block.json';
		$metadata = json_decode( ob_get_clean(), true);

		/**
		 * Register Gutenberg block on server-side.
		 *
		 * Register the block on server-side to ensure that the block
		 * scripts and styles for both frontend and backend are
		 * enqueued when the editor loads.
		 *
		 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
		 * @since 1.16.0
		 */
		
		register_block_type(
			$metadata['name'], 
			array(
				// Enqueue blocks.style.build.css on both frontend & backend.
				'style'         => 'gshare-style-css',
				// Enqueue blocks.build.js in the editor only.
				'editor_script' => 'gshare-block-js',
				// Enqueue blocks.editor.build.css in the editor only.
				'editor_style'  => 'gshare-block-editor-css',
				'attributes'	=> $metadata['attributes'],
				'render_callback' => 'wppool_render_gshare_block'
			)
		);
	}

	// Hook: Block assets.
	add_action( 'init', 'gshare_assets_load' );
} else {
	function gshare_nogutenberg_load(){
		// Register block styles for both frontend + backend.
		wp_enqueue_style(
			'gshare-style-css',
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
			array(), 
			null 
		);
	}
	add_action( 'wp_enqueue_scripts', 'gshare_nogutenberg_load' );
}

