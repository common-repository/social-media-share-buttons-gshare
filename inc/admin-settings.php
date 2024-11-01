<?php

if (!defined('ABSPATH')) {
	exit;
}

class Gshare_Admin_Settings
{

	public $settings;
	public $callbacks;
	protected $has_pro;

	public function __construct()
	{
		
		include_once GSHARE_FILE_PATH . 'inc/gshare-admin.php';
		include_once GSHARE_FILE_PATH . 'inc/mannage-callback.php';

		$this->settings  = new Gshare_Settings();
		$this->callbacks = new Mannage_Callback();

		// Fields
		$this->setSettings();
		$this->setSections();
		$this->setFields();
	}

	public static function key()
	{
		return 'gshare';
	}

	public function setSettings()
	{
		$args = array();

		$args[] = array(
			'option_group' => 'gshare_settings',
			'option_name'  => 'style',
		);
		$args[] = array(
			'option_group' => 'gshare_settings',
			'option_name'  => 'custom-color',
		);
		$args[] = array(
			'option_group' => 'gshare_settings',
			'option_name'  => 'gshare-custom-font',
		);
		$args[] = array(
			'option_group' => 'gshare_settings',
			'option_name'  => 'positionlink',
		);
		$args[] = array(
			'option_group' => 'gshare_settings',
			'option_name'  => 'linksitems',
		);

		$args[] = array(
			'option_group' => 'gshare_settings',
			'option_name'  => 'display_screen',
		);
		if (! Gshare_Social::is_pro_installed() ) {
			$args[] = array(
				'option_group' => 'gshare_settings',
				'option_name'  => 'extra_pro_feature',
			);
		}


		$this->settings->setSettings($args);
	}

	public function setSections()
	{

		$args = array(
			array(
				'id'    => 'gshare_field_section',
				'title' => null,
				'page' => 'gshare'
			),

		);

		$this->settings->setSections($args);
	}

	public function setFields()
	{

		$args = array();

		$args[] = [
			'id'       => 'style',
			'title'    => __('Style', 'gshare') . '<span class="description">' . __('Select default styles', 'gshare') . '</span>',
			'callback' => [$this->callbacks, 'radio_field_style'],
			'page'     => 'gshare',
			'section'  => 'gshare_field_section',
			'args'     => [
				'label_for' => 'style',
				'class'     => 'image-radio'
			]
		];

		$args[] = [
			'id'       => 'custom-color',
			'title'    => __('Custom Color', 'gshare') . '<span class="description">' . __('For all socials', 'gshare') . '</span>',
			'callback' => [$this->callbacks, 'color_field_style'],
			'page'     => 'gshare',
			'section'  => 'gshare_field_section',
			'args'     => [
				'label_for' => 'custom-color',
				'class'     => 'color-selection'
			]
		];

		$args[] = [
			'id'       => 'gshare-custom-font',
			'title'    => __('Font', 'gshare') . '<span class="description">' . __('For all social', 'gshare') . '</span>',
			'callback' => [$this->callbacks, 'font_field_style'],
			'page'     => 'gshare',
			'section'  => 'gshare_field_section',
			'args'     => [
				'label_for' => 'gshare-custom-font',
				'class'     => 'font-selection'
			]
		];

		$args[] = [
			'id'       => 'positionlink',
			'title'    => __('Position', 'gshare') . '<span class="description">' . __('Where to show', 'gshare') . '</span>',
			'callback' => [$this->callbacks, 'radio_field_position'],
			'page'     => 'gshare',
			'section'  => 'gshare_field_section',
			'args'     => [
				'label_for' => 'positionlink',
				'class'     => 'keen-radio'
			]
		];

		$args[] = array(
			'id'       => 'linksitems',
			'title'    => __('All Social List', 'gshare') . '<span class="description">' . __('Select/Decelect icons', 'gshare') . '</span>',
			'callback' => array($this->callbacks, 'check_box_multiple'),
			'page'     => 'gshare',
			'section'  => 'gshare_field_section',
			'args'     => array(
				'label_for' => 'linksitems',
				'class'     => 'keen-radio'
			)
		);
		$args[] = array(
			'id'       => 'display_screen',
			'title'    => __('Display On', 'gshare') . '<span class="description">' . __('Specific Screens', 'gshare') . '</span>',
			'callback' => array($this->callbacks, 'display_screen'),
			'page'     => 'gshare',
			'section'  => 'gshare_field_section',
			'args'     => array(
				'label_for' => 'display_screen',
				'class'     => 'keen-radio'
			)

		);
		if (! Gshare_Social::is_pro_installed() ) {
			$args[] = array(
				'id'		=> 'extra_pro_feature',
				'title'		=> __('Advance Settings', 'gshare') . '<span class="description">' . __('Unlock on pro', 'gshare') . '</span>',
				'callback'	=> array($this->callbacks, 'extra_pro_feature'),
				'page'		=> 'gshare',
				'section'	=> 'gshare_field_section',
				'args'		=> array(
					'label_for' => 'extra_pro_feature',
					'class'     => 'keen-radio'
				)
			);
		}

		$this->settings->setFields($args);
	}
}

new Gshare_Admin_Settings();
