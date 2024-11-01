<?php

/**
 * Update Settings
 */
?>

<div class="wrap">
	<?php settings_errors(); ?>
	<h3 class="title">
		<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/gshare_admin.png') ?>" alt="<?php echo esc_attr(get_admin_page_title()); ?>">
		<?php echo esc_html__('Social Media Share Buttons - Gshare', 'gshare') ?>
	</h3>
	<div class="option-form-field-wrap">
		<div class="gshare-setting-tab-links">
			<a class="gshare-tab-link active" href="#gshareSettingsTab"><?php echo __('Settings', 'gshare'); ?></a>
			<a class="gshare-tab-link" href="#gshareGeneralTab"><?php echo __('Get Started', 'gshare'); ?></a>
			<?php if (!Gshare_Social::is_pro_installed()) { ?><a class="gshare-tab-link get_pro" href="#gshareProTab"><?php echo __('Get Pro', 'gshare'); ?></a><?php } ?>
			<?php do_action('gshare_add_settings_tab'); ?>
		</div>
		<div class="gshare-setting-tabs">
			<div class="gshare-setting-tab active" id="gshareSettingsTab">
				<form method="post" action="options.php" class="gshare-option-form" id="gshareOptionForm">
					<?php
					echo '<div class="gshare-option-box">';
					settings_fields('gshare_settings');
					do_settings_sections('gshare');
					submit_button('Save Changes');
					echo '<div id="gshareSaveResult" class="gshare-save-result"></div>';
					echo '</div>';
					?>
				</form>
			</div>
			<div class="gshare-setting-tab" id="gshareGeneralTab">
				<div class="gshare-setting-linkboxes">
					<div class="gshare-setting-linkbox">
						<div class="gshare-setting-linkbox-inner">
							<div class="gshare-setting-linkbox-icon">
								<i class="fa fa-pencil-square-o"></i>
							</div>
							<div class="gshare-setting-linkbox-content">
								<h5 class="gshare-setting-linkbox-title"><?php echo __('Documentation', 'gshare'); ?></h5>
								<p class="gshare-setting-linkbox-text"><?php echo __('Get started by spending some time with the documentation to get familiar with Gshare to know it\'s advance functionality and usage case.', 'gshare'); ?></p>
								<a target="_blank" class="gshare-setting-linkbox-btn" href="<?php echo esc_url('https://wppool.dev/social-media-share-button/') ?>"><?php echo __('Documentation', 'gshare'); ?></a>
							</div>
						</div>
					</div>
					<?php if ( ! Gshare_Social::is_pro_installed() ) { ?>
						<div class="gshare-setting-linkbox colorful-linkbox">
							<div class="gshare-setting-linkbox-inner">
								<div class="gshare-setting-linkbox-icon">
									<i class="fa fa-unlock-alt"></i>
								</div>
								<div class="gshare-setting-linkbox-content">
									<h5 class="gshare-setting-linkbox-title"><?php echo __('Upgrade to pro', 'gshare'); ?></h5>
									<p class="gshare-setting-linkbox-text"><?php echo __('Unlock pro features to get full access to unlimimited styles and extraordinary settings. Pro feature settings includes mobile share bar, popup, open graph and many more.', 'gshare'); ?></p>
									<a target="_blank" class="gshare-setting-linkbox-btn" href="<?php echo esc_url('https://wppool.dev/social-media-share-button/') ?>"><?php echo __('Unlock Pro', 'gshare') ?></a>
								</div>
							</div>
						</div>
					<?php } ?>
					<div class="gshare-setting-linkbox">
						<div class="gshare-setting-linkbox-inner">
							<div class="gshare-setting-linkbox-icon">
								<i class="fa fa-support"></i>
							</div>
							<div class="gshare-setting-linkbox-content">
								<h5 class="gshare-setting-linkbox-title"><?php echo __('Get Support?', 'gshare'); ?></h5>
								<p class="gshare-setting-linkbox-text"><?php echo __('Stuck with something? Get help from the community on WPPool Forum or Facebook Community. In case of emergency, initiate a live chat at gshare website.', 'gshare'); ?></p>
								<a target="_blank" class="gshare-setting-linkbox-btn" href="<?php echo esc_url('https://wppool.dev/social-media-share-button/') ?>"><?php echo __('Get Support', 'gshare'); ?></a>
							</div>
						</div>
					</div>
					<div class="gshare-setting-linkbox">
						<div class="gshare-setting-linkbox-inner">
							<div class="gshare-setting-linkbox-icon">
								<i class="fa fa-question-circle-o"></i>
							</div>
							<div class="gshare-setting-linkbox-content">
								<h5 class="gshare-setting-linkbox-title"><?php echo __('Missing Any Feature?', 'gshare'); ?></h5>
								<p class="gshare-setting-linkbox-text"><?php echo __('Are you missing a feature related to social share on our plugin. Let\'s make it greate together by making a feature request on our forum.', 'gshare'); ?></p>
								<a target="_blank" class="gshare-setting-linkbox-btn" href="<?php echo esc_url('https://wppool.dev/social-media-share-button/') ?>"><?php echo __('Request Feature', 'gshare'); ?></a>
							</div>
						</div>
					</div>
					<div class="gshare-setting-linkbox">
						<div class="gshare-setting-linkbox-inner">
							<div class="gshare-setting-linkbox-icon">
								<i class="fa fa-heart-o"></i>
							</div>
							<div class="gshare-setting-linkbox-content">
								<h5 class="gshare-setting-linkbox-title"><?php echo __('Show your Love', 'gshare'); ?></h5>
								<p class="gshare-setting-linkbox-text"><?php echo __('We are making it more awesome everyday. Take your 2 minutes to review the plugin and spread the love to encourage us to keep it going.', 'gshare'); ?></p>
								<a target="_blank" class="gshare-setting-linkbox-btn" href="<?php echo esc_url('https://wppool.dev/social-media-share-button/') ?>"><?php echo __('Leave a Review', 'gshare'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if ( ! Gshare_Social::is_pro_installed() ) { ?>
				<div class="gshare-setting-tab" id="gshareProTab">
					<h3 class="gshare-why-pro"><?php echo __('Why upgrade to pro?', 'gshare'); ?></h3>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/pro-section/addon-for-all.png') ?>" alt="<?php echo __('Gshare Addon for all', 'gshare'); ?>" />
						</div>
						<div class="gshare-profeature-left">
							<h4><?php echo __('Addon for all', 'gshare'); ?></h4>
							<p><?php echo __('Currently have customizable Gutenberg Block and Elementor Widget, Divi and more are coming. Can be use on post and page editor as Gutenberg block. Where besides global style and settings it can also be fully customizable. Elements and widgets are also coming for Elementor, Divi and so on', 'gshare'); ?></p>
						</div>
					</div>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-left">
							<h4><?php echo __('Premium style collection', 'gshare') ?></h4>
							<p><?php echo __('More creative and site suitable way to show social share icons with gshare.', 'gshare'); ?></p>
						</div>
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/pro-section/style-with-cursor.gif') ?>" alt="<?php echo __('Gshare Pro styles', 'gshare'); ?>" />
						</div>
					</div>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/pro-section/custom-color.png') ?>" alt="<?php echo __('Gshare Same color', 'gshare'); ?>" />
						</div>
						<div class="gshare-profeature-left">
							<h4><?php echo __('Custom color on all', 'gshare') ?></h4>
							<p><?php echo __('To make your site more stunning and user friendly our pro feature also included all active social icons on same color scheme.', 'gshare'); ?></p>
						</div>
					</div>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-left">
							<h4><?php echo __('Mobile Share Bar', 'gshare'); ?></h4>
							<p><?php echo __('For best usability for mobile user unlock the feature to show social share like a sweet and stunning tab collection.', 'gshare'); ?></p>
						</div>
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/pro-section/easy-share.svg') ?>" alt="<?php echo __('Gshare Mobile Share Bar', 'gshare'); ?>" />
						</div>
					</div>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/extra-features/media_share.png') ?>" alt="<?php echo __('Gshare Pro styles', 'gshare'); ?>" />
						</div>
						<div class="gshare-profeature-left">
							<h4><?php echo __('Media Share', 'gshare'); ?></h4>
							<p><?php echo __('Unlock seperate share option for media to directly share picture and videos.', 'gshare'); ?></p>
						</div>
					</div>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-left">
							<h4><?php echo __('Pop & Fly', 'gshare'); ?></h4>
							<p><?php echo __('On pro multi event triggering popup and fly option are available. The feature is highly customizable with lot of popup trigger option. Trigger includes Timed Delay, Post scroll to %, Bottom of post, Timed inactivity, Click etc.', 'gshare'); ?></p>
						</div>
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/extra-features/popup_share.png') ?>" alt="<?php echo __('Gshare Pro styles', 'gshare'); ?>" />
						</div>
					</div>
					<div class="gshare-profeature-shot">
						<div class="gshare-profeature-right">
							<img src="<?php echo esc_url(GSHARE_URL . '/assets/images/pro-section/open_graph.jpg') ?>" alt="<?php echo __('Gshare Pro styles', 'gshare'); ?>" />
						</div>
						<div class="gshare-profeature-left">
							<h4><?php echo __('Open Graph', 'gshare'); ?></h4>
							<p><?php echo __('Open Graph Protocol allow you to control what content is shown when your site or pages are linked on Facebook or another social media platform.', 'gshare'); ?></p>
						</div>
					</div>
					<div class="gshare-pro-footer">
						<h4><?php echo __('And many more...', 'gshare'); ?></h4>
						<a class="btn-premium" target="_blank" href="<?php echo esc_url('https://wppool.dev/social-media-share-button/'); ?>"><?php echo __('Upgrade to Pro', 'gshare'); ?></a>
					</div>
				</div>
			<?php } ?>
			<?php do_action('gshare_add_settings_tab_content'); ?>
		</div>
	</div>
</div>