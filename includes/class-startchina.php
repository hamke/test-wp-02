<?php
class Startchina {

	protected $loader;
	protected $plugin_name;
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'STARTCHINA_VERSION' ) ) {
			$this->version = STARTCHINA_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'startchina';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// Plugin Update Checker
    include( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/plugin-update-checker/plugin-update-checker.php' );
    $MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    	'https://app.wp-talk.com/update-server/?action=get_metadata&slug=startchina', //Metadata URL.
    	plugin_dir_path( dirname( __FILE__ ) ) . 'startchina.php', //Full path to the main plugin file.
    	'startchina' //Plugin slug. Usually it's the same as the name of the directory.
    );

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-startchina-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-startchina-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-startchina-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-startchina-public.php';

		$this->loader = new StartChina_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new StartChina_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new StartChina_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'admin_enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_setting' );
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'load_language' );

		$this->loader->add_filter( 'plugin_action_links_startchina/startchina.php', $plugin_admin, 'create_settings_link_in_plugin_list' );

	}

	private function define_public_hooks() {

		$plugin_public = new StartChina_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    StartChina_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
