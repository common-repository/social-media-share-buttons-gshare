<?php

class Mannage_Callback
{

	public function checkboxsanitize($input)
	{
		return (isset($input) ? true : false);
	}

	public function gshare_settings_callback($input)
	{
		return $input;
	}

	public function adminSectionManeger()
	{
		echo 'Section Description';
	}

	public function checkboxField($args)
	{
		$name    = $args['label_for'];
		$image   = $args['img'];
		$class   = $args['class'];
		$checked = get_option($name);

?>
		<div class="gshare-field">
			<div class="gshare-checkbox" data-image="true">
				<label>
					<input type="checkbox" class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($name); ?>" value="1" <?php echo $checked ? 'checked' : '' ?> />
					<img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr($name); ?>">
				</label>
			</div>
		</div>
	<?php

	}

	// Style Radio Field
	public function radio_field_style($args)
	{
		$name   = $args['label_for'];
		$class  = $args['class'];
		$option = get_option($name, 'theme1');

		$themes = array(
			'theme1',
			'theme5',
			'theme6',
			'theme7',
			'theme8',
			'theme11',
			'theme12',
			'theme2',
			'theme3',
			'theme10',
			'theme9',
			'theme13',
			'theme4',
			'theme14',
		);

		$i = 1;
	?>
		<div class="keen-style-selector">
			<?php foreach ($themes as $key => $theme) :
				$checked = '';
				if ($option == $theme) {
					$checked = 'checked';
				}

				if ($i == 1 && ($theme == 'theme1')) {
					$checked = 'checked';
				}

				if($i >= 5 && !Gshare_Social::is_pro_installed()){
					?>
					<div class="keen-style-item pro-design-disable">
						<a class="<?php echo esc_attr($class . '-' . $name); ?> image-radio-style-disable" href="#gshareProTab">
							<input type="radio" disabled>
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/layout/' . $theme) ?>.png" alt="<?php echo $name ?>">
							<i class="fa fa-check hidden"></i>
						</a>
					</div>
					<?php 
				} else {
					?>
					<div class="keen-style-item">
						<label data-check="checked" for="<?php echo esc_attr($theme); ?>" class="<?php echo esc_attr($class . '-' . $name); ?>">
							<input type="radio" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($theme); ?>" value="<?php echo esc_attr($theme); ?>" <?php echo $checked; ?>>
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/layout/' . $theme) ?>.png" alt="<?php echo $name ?>">
							<i class="fa fa-check hidden"></i>
						</label>
					</div>
					<?php 
				}
			?>
				

			<?php
				$i++;
			endforeach;
			?>
		</div>
	<?php
	}

	//Style color field
	public function color_field_style($args)
	{
		$name   = $args['label_for'];
		$class  = $args['class'];
		$option = get_option($name);

	?>
		<div class="keen-color-selector">
			<?php if (!Gshare_Social::is_pro_installed()) { ?>
				<span class="pro-design-disable"></span>
			<?php } else { ?>
				<input type="text" id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo $option; ?>" class="gshare-color-picker" />
			<?php } ?>
		</div>
	<?php
	}

	//Style font field
	public function font_field_style($args)
	{
		$name   = $args['label_for'];
		$class  = $args['class'];
		$option = get_option($name);

	?>
		<div class="keen-font-selector">
			<?php if (!Gshare_Social::is_pro_installed()) { ?>
				<span class="pro-design-disable"><?php _e('Poppins', 'gshare'); ?></span>
			<?php } else { 	
				$response = get_transient('gshare_google_font_obj');
				if(false == $response){
					$request = wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyC-FCJYVYO5jaKAVq-hXN5qylQxCL-_pS8' );
					$response = json_decode( $request['body'], true );
					if( !empty( $response['items'] ) ) {
						set_transient( 'gshare_google_font_obj', $response, 604800 );
					}
				}					
				?>
				<input id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="gshare-font-picker" list="brow" value="<?php echo esc_attr($option); ?>">
				<datalist id="brow">
					<?php 
						foreach($response['items'] as $font){
							$isSelected = ($font['family'] == $option) ? 'selected' : '';
							echo '<option value="'.$font['family'].'" '.$isSelected.'>'.$font['family'].'</option>';
						} 
					?>
				</datalist>
			<?php } ?>
		</div>
	<?php
	}

	//Radio Field Position
	public function radio_field_position($args)
	{
		$name   = $args['label_for'];
		$class  = $args['class'];
		$option = get_option($name, 'bottom');

		$positions = array(
			'side',
			'bottom',
			'top',
			'both',
		);


		$i = 1;

	?>
		<div class="gshare-position-selector">
			<?php foreach ($positions as $key => $position) :
				$checked = '';
				if ($option == $position) {
					$checked = 'checked';
				}

				if ($i == 1 && ($position == 'bottom')) {
					$checked = 'checked';
				}

			?>
				<div class="gshare-position-item">
					<label data-check="checked" for="<?php echo esc_attr($position); ?>" class="<?php echo esc_attr($class . '-' . $name); ?>">
						<input type="radio" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($position); ?>" value="<?php echo esc_attr($position); ?>" <?php echo $checked; ?>>
						<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/position/' . $position) ?>.png" alt="<?php echo $name ?>">
						<i class="fa fa-check hidden"></i>
						<span class="check-input-title"><?php echo esc_attr($position); ?></span>
					</label>
				</div>
			<?php
				$i++;
			endforeach; ?>
		</div>
		<?php
	}

	// Selected Social Link
	public function check_box_multiple()
	{

		echo '<div class="gshare-field-social-wrap">';

		// get networks data
		ob_start();
		if(Gshare_Social::is_pro_installed()){
			include GSHARE_PRO_FILE_PATH . 'dist/networks.json';
		} else {
			include plugin_dir_path(__DIR__) . 'dist/networks.json';
		}		
		$socialfield = json_decode(ob_get_clean(), true);
		
		if (is_array($socialfield)) {
			foreach ($socialfield as $key => $field) {
				$options       = get_option('linksitems', ['facebook', 'twitter', 'linkedin']);
				$groupcheckbox = isset($options) ? (array) $options : [];

				if($field['link'] == '#'){
					?>
					<div class="gshare-field is-pro-field">
						<div class="gshare-checkbox" data-image="true">
							<label data-check="checked">
								<?php echo $field['icon']; ?>
							</label>
						</div>
					</div>
					<?php 
				} else {
					?>
					<div class="gshare-field">
						<div class="gshare-checkbox" data-image="true">
							<label data-check="checked">
								<?php echo $field['icon']; ?>
								<input type='checkbox' name="linksitems[]" <?php checked(in_array($field['class'], $groupcheckbox)); ?> value='<?php echo $field['class'] ?>'>
								<i class="fa fa-plus"></i>
							</label>
						</div>
					</div>
					<?php 
				}
			}
		} ?>

		<?php
		echo '</div>';
	}


	public function display_screen($arge)
	{

		$display = [
			'post',
			'page'
		];

		foreach ($display as $key => $field) {
			$options = get_option('display_screen', ['post']);
			$scren   = isset($options) ? (array) $options : [];
		?>

			<div class="gshare-field">
				<div class="gshare-checkbox display-checkbox" data-image="true">
					<label data-check="checked">
						<input type='checkbox' name="display_screen[]" <?php checked(in_array($field, $scren)); ?> value='<?php echo $field ?>'>
						<span class="dashicons check-input-icon dashicons-admin-<?php echo $field ?>"></span>
						<span class="check-input-title"><?php _e(ucfirst($field)) ?></span>
					</label>
				</div>
			</div>
			<!-- /.input-group -->
		<?php } ?>
		<div class="gshare-field">
			<div class="gshare-checkbox display-checkbox" data-image="true">
				<label data-check="checked">
					<input type="checkbox" name="display_screen[]" <?php checked(!in_array('post', $scren) && !in_array('page', $scren)); ?> value="none" />
					<span class="dashicons check-input-icon dashicons-no"></span>
					<span class="check-input-title"><?php esc_html_e('None', 'gshare'); ?></span>
				</label>
			</div>
		</div>

		<?php
	}

	public function extra_pro_feature($arge)
	{

		$features_pro = [
			'media_share' => __('Media Share', 'gshare'),
			'mobile_share' => __('Mobile Share', 'gshare'),
			'popup_share' => __('Auto Popup', 'gshare'),
			'open_graph' => __('Open Graph', 'gshare'),
		];

		foreach ($features_pro as $key => $field) {
			$options = get_option('extra_pro_feature', []);
			$feature = isset($options) ? (array) $options : [];
		?>

			<div class="gshare-field gshare-extra-feature-item">
				<div class="gshare-checkbox gshare-checkbox-big" data-image="true">
					<label data-check="checked">
						<input type='checkbox' name="extra_pro_feature[]" <?php checked(in_array($key, $feature)); ?> value='<?php echo $key ?>'>
						<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/extra-features/' . $key) ?>.png" alt="<?php echo $field ?>">
						<span class="check-input-title"><?php _e(ucfirst($field)) ?></span>
					</label>
				</div>
			</div>
			<!-- /.input-group -->
		<?php } ?>
<?php
	}
}
