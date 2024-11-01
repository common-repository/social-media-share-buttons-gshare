<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Gshare_Settings {

	public $settings = array();
	public $sections = array();
	public $fields = array();

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'gshare_admin_menu_page' ) );
		add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
	}


	public function gshare_admin_menu_page() {
		add_menu_page(
			'Gshare',
			esc_html__('Gshare', 'gshare'),
			'manage_options',
			'gshare',
			array( $this, 'gshare_manu_page_settings' ),
			GSHARE_URL . '/assets/images/gshare.png',
			'80'
		);
	}

	public function gshare_manu_page_settings() {
		require_once GSHARE_FILE_PATH . 'inc/functions-settings.php';
	}


	public function setSettings( array $settings ) {
		$this->settings = $settings;

		return $this;
	}


	public function setSections( array $sections ) {
		$this->sections = $sections;

		return $this;
	}

	public function setFields( array $fields ) {
		$this->fields = $fields;

		return $this;
	}


	public function registerCustomFields() {
		// Register Settings
		foreach ( $this->settings as $setting ) {
			register_setting( $setting['option_group'], $setting['option_name'], ( isset( $setting['callback'] ) ? $setting['callback'] : '' ) );
		}

		//Register Setting Section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section['id'], $section['title'], ( isset( $section['callback'] ) ? $section['callback'] : '' ), $section['page'] );
		}

		// Settings Field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field['id'], $field['title'], ( isset( $field['callback'] ) ? $field['callback'] : '' ), $field['page'], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}
}

