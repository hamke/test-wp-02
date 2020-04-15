<?php
class StartChina_Admin {

	private $text_domain = 'startchina';
	private $value;
	private $using_google_fonts;
	private $using_gravatar;
	private $default_avatar;
	private $local_avatar;
	private $auto_update_core;
	private $auto_update_plugins;
	private $auto_update_themes;
	private $advanced_speed_up;

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->get_value();
		$this->speed_up();

	} // public function __construct

	/////////////////////////////////////////////////////////

	public function get_value() {

		$this->default_avatar = STARTCHINA_URL . 'images/avatar_256x256.png';
		$this->values = get_option($this->text_domain);
		// var_dump($this->values);die;

		$this->google_font_url = 'googleapis.com';
		$this->google_font = isset($this->values['google-font']) ? $this->values['google-font'] : array();
		$this->google_font_frontend = isset($this->google_font['frontend']) ? $this->google_font['frontend'] : array();
		$this->google_font_frontend_type = isset($this->google_font_frontend['type']) ? $this->google_font_frontend['type'] : 'enabled';
		$this->google_font_frontend_to = isset($this->google_font_frontend['to']) ? $this->google_font_frontend['to'] : 'cat.net';
		$this->google_font_backend = isset($this->google_font['backend']) ? $this->google_font['backend'] : array();
		$this->google_font_backend_type = isset($this->google_font_backend['type']) ? $this->google_font_backend['type'] : 'enabled';
		$this->google_font_backend_to = isset($this->google_font_backend['to']) ? $this->google_font_backend['to'] : 'cat.net';

		$this->using_gravatar = isset($this->values['using-gravatar']) ? $this->values['using-gravatar'] : 'enabled';
		$this->local_avatar = isset($this->values['local-avatar']) && !empty($this->values['local-avatar']) ? $this->values['local-avatar'] : $this->default_avatar;

		$this->disable_emoji = isset($this->values['disable-emoji']) ? $this->values['disable-emoji'] : 'no';
		$this->local_emoji = isset($this->values['local-emoji']) ? $this->values['local-emoji'] : 'no';

		$this->remove_dashbaord_widgets = isset($this->values['remove-dashboard-widgets']) ? $this->values['remove-dashboard-widgets'] : array();

		$this->auto_update_core = isset($this->values['auto-update-core']) ? $this->values['auto-update-core'] : 'disabled';
		$this->auto_update_plugins = isset($this->values['auto-update-plugins']) ? $this->values['auto-update-plugins'] : 'disabled';
		$this->auto_update_themes = isset($this->values['auto-update-themes']) ? $this->values['auto-update-themes'] : 'disabled';
		$this->advanced_speed_up = isset($this->values['advanced-speed-up']) ? $this->values['advanced-speed-up'] : 'disabled';
		$this->update_plugins_ids = isset($this->values['update_plugins_ids']) ? $this->values['update_plugins_ids'] : array();
		$this->update_themes_ids = isset($this->values['update_themes_ids']) ? $this->values['update_themes_ids'] : array();
		$this->update_core_ids = isset($this->values['update_core_ids']) ? $this->values['update_core_ids'] : array();
		$this->update_plugins_roles_ids = isset($this->values['update_plugins_roles_ids']) ? $this->values['update_plugins_roles_ids'] : array();
		$this->update_themes_roles_ids = isset($this->values['update_themes_roles_ids']) ? $this->values['update_themes_roles_ids'] : array();
		$this->update_core_roles_ids = isset($this->values['update_core_roles_ids']) ? $this->values['update_core_roles_ids'] : array();
		$this->extend_the_time_of_the_upgrade = isset($this->values['extend-the-time-of-the-upgrade']) ? $this->values['extend-the-time-of-the-upgrade'] : 'disabled';
	}

	public function speed_up() {
		
		if (is_admin()) {
			if ( in_array($this->google_font_backend_type, array('enabled', 'delete')) ) {
				add_action('init', array($this, 'buffer_start') );
				add_action('shutdown', array($this, 'buffer_end') );
			}
		} else {
			if ( in_array($this->google_font_frontend_type, array('enabled', 'delete')) ) {
				add_action('init', array($this, 'buffer_start') );
				add_action('shutdown', array($this, 'buffer_end') );
			}
		}

		if ($this->using_gravatar == 'disabled') {
			add_filter( 'get_avatar', array($this, 'get_avatar'), 11, 5 );
		} elseif ($this->using_gravatar == 'v2ex') {
			add_filter('get_avatar', array($this, 'getV2exAvatar') );
		}

		if ($this->disable_emoji == 'yes') {
			add_action( 'init', array($this, 'disable_emojis') );
		}

		if ($this->auto_update_core == 'disabled') {
			add_filter( 'pre_site_transient_update_core', array($this, 'return_null') );
			remove_action( 'admin_init', '_maybe_update_core');
			remove_action( 'wp_version_check', 'wp_version_check' );
			remove_action( 'upgrader_process_complete', 'wp_version_check', 10, 0 );
			$this->remove_auto_update();
		}

		if ($this->auto_update_plugins == 'disabled') {
			add_filter( 'pre_site_transient_update_plugins', array($this, 'return_null') );
			remove_action( 'admin_init', '_maybe_update_plugins');
			remove_action( 'load-plugins.php', 'wp_update_plugins' );
			remove_action( 'load-update.php', 'wp_update_plugins' );
			remove_action( 'load-update-core.php', 'wp_update_plugins' );
			remove_action( 'admin_init', '_maybe_update_plugins' );
			remove_action( 'wp_update_plugins', 'wp_update_plugins' );
			remove_action( 'upgrader_process_complete', 'wp_update_plugins' );

			$timestamp = wp_next_scheduled( 'wp_update_plugins' );
			wp_unschedule_event( $timestamp, 'wp_update_plugins');

			$this->remove_auto_update();
		}

		if ($this->auto_update_themes == 'disabled') {
			add_filter( 'pre_site_transient_update_themes', array($this, 'return_null') );
			remove_action( 'admin_init', '_maybe_update_themes');
			remove_action( 'load-themes.php', 'wp_update_themes' );
			remove_action( 'load-update.php', 'wp_update_themes' );
			remove_action( 'load-update-core.php', 'wp_update_themes' );
			remove_action( 'wp_update_themes', 'wp_update_themes' );
			remove_action( 'upgrader_process_complete', 'wp_update_themes' );

			$timestamp = wp_next_scheduled( 'wp_update_themes' );
			wp_unschedule_event( $timestamp, 'wp_update_themes');

			$this->remove_auto_update();
		}

		if ($this->advanced_speed_up == 'enabled') {
			add_filter( 'user_has_cap', array($this, 'user_has_cap') );
			add_filter( 'pre_http_request', array($this, 'pre_http_request'), 10, 3 );
		}

		if ($this->extend_the_time_of_the_upgrade == 'enabled') {
			add_action( 'admin_init', array($this, 'update_no_limit') );
		}

	} // public function speed_up()

	/////////////////////////////////////////////////////////

	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ($screen->id == 'settings_page_startchina') {
			//for 3.5+ uploader
			wp_enqueue_media();
		}
	}

	function cdn_callback($buffer) {
		if (is_admin()) {
			if ($this->google_font_backend_type == 'enabled') return str_replace($this->google_font_url, $this->google_font_backend_to, $buffer);
			else return preg_replace('/<link[^<]*googleapis\.com[^>]*>/', '', $buffer);
		} else {
			if ($this->google_font_frontend_type == 'enabled') return str_replace($this->google_font_url, $this->google_font_frontend_to, $buffer);
			else return preg_replace('/<link[^<]*googleapis\.com[^>]*>/', '', $buffer);
		}
	}
	function buffer_start() {
		ob_start(array($this, "cdn_callback"));
	}
	function buffer_end() {
		@ob_end_flush();
	}

	public function update_no_limit() {
		set_time_limit(0);
	}

	public function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', array($this, 'disable_emojis_tinymce') );
	}

	public function disable_emojis_tinymce( $plugins ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}

	public function user_has_cap($allcaps) {
		if (isset($allcaps['update_plugins'])) unset($allcaps['update_plugins']);
		if (isset($allcaps['update_themes'])) unset($allcaps['update_themes']);
		if (isset($allcaps['update_core'])) unset($allcaps['update_core']);
		return $allcaps;
	}

	public function pre_http_request($pre, $r, $url) {
		if (preg_match('/api\.wordpress\.org|update\-check|subscription/i', $url)) {
			return true;
		} else {
			return false;
		}
	}

	public function get_avatar($avatar, $id_or_email, $size, $default, $alt) {
		$url = is_numeric( $this->local_avatar ) ? wp_get_attachment_url( $this->local_avatar ) : $this->local_avatar;
		return '<img src="'.$url.'" class="avatar avatar-'.$size.' height="'.$size.'" width="'.$size.'" alt="'.$alt.'" />';
	}

	public function getV2exAvatar($avatar) {
		$avatar = str_replace(array("www.gravatar.com/avatar", "0.gravatar.com/avatar", "1.gravatar.com/avatar", "2.gravatar.com/avatar"), "cdn.v2ex.com/gravatar", $avatar);
		return $avatar;
	}

	public function remove_auto_update() {
		remove_action( 'wp_maybe_auto_update', 'wp_maybe_auto_update' );
		remove_action( 'init', 'wp_schedule_update_checks' );
	}

	/////////////////////////////////////////////////////

	public function register_setting() {
    register_setting( 'startchina_setting_group', 'startchina' );
  }

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/startchina-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'startchina-main', plugin_dir_url( __FILE__ ) . 'css/main.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/startchina-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_menu() {
		add_menu_page(
      __( 'StartChina', 'textdomain' ), // Page Title
      __( 'StartChina', 'textdomain' ), // Menu Title
      'manage_options', // Capability
      'startchina', // home_url() . '/wp-admin/?page=welcome'
      array( &$this, 'settings_page' ), // Callback function as below
			'https://hellotblog.files.wordpress.com/2019/06/startchina-logo-00-120x120.png',
			100
    );
	}
	public function settings_page() {
		include( STARTCHINA_DIR . '/admin/partials/startchina-admin-display.php' );
	}

  public function create_settings_link_in_plugin_list( $links ) {
  	$settings_link = "<a href=" . menu_page_url( $this->text_domain, 0 ) . ">" . __( 'Settings Page' ) . '</a>';
		array_unshift( $links, $settings_link );
  	return $links;
  }

	public function load_language() {
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function return_null(){
		return null;
	}

}
