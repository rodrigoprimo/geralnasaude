<?php
/**
 * Main plugin file.
 * In bbPress 2.1+, change Forums Archive Title (forums main page), some
 *   Breadcrumbs arguments, User Role display names plus a few other
 *   Forums Strings.
 *
 * @package   bbPress String Swap
 * @author    David Decker
 * @link      http://deckerweb.de/twitter
 * @copyright Copyright (c) 2012-2013, David Decker - DECKERWEB
 *
 * Plugin Name: bbPress String Swap
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/
 * Description: In bbPress 2.1+, change Forums Archive Title (forums main page), some Breadcrumbs arguments, User Role display names plus a few other Forums Strings.
 * Version: 1.3.0
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: bbpress-string-swap
 * Domain Path: /languages/
 *
 * Copyright (c) 2012-2013 David Decker - DECKERWEB
 *
 *     This file is part of bbPress String Swap,
 *     a plugin for WordPress.
 *
 *     bbPress String Swap is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     bbPress String Swap is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Exit if accessed directly.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin directory */
define( 'BBPSSWAP_PLUGIN_DIR', dirname( __FILE__ ) );

/** Plugin base directory */
define( 'BBPSSWAP_PLUGIN_BASEDIR', dirname( plugin_basename( __FILE__ ) ) );


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since 1.0.0
 *
 * @uses  get_plugins()
 *
 * @param $bbpsswap_plugin_value
 * @param $bbpsswap_plugin_folder
 * @param $bbpsswap_plugin_file
 *
 * @return string Plugin version
 */
function ddw_bbpsswap_plugin_get_data( $bbpsswap_plugin_value ) {

	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$bbpsswap_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$bbpsswap_plugin_file = basename( ( __FILE__ ) );

	return $bbpsswap_plugin_folder[ $bbpsswap_plugin_file ][ $bbpsswap_plugin_value ];

}  // end of function ddw_bbpsswap_plugin_get_data


/**
 * Plugin's main class.
 *
 * @since 1.0.0
 */
class DDW_bbPress_String_Swap {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $_this;


	/**
	 * Constructor. Hooks all interactions into correct areas to start the class.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		/**
		 * Disallowing a Second Instantiation of our class.
		 *
		 * @link  http://hardcorewp.com/2013/using-singleton-classes-for-wordpress-plugins/
		 *
		 * @since 1.3.0
		 *
		 * @uses  wp_die()
		 */
	    if ( isset( self::$_this ) ) {

	    	$bbpsswap_notice = sprintf( __( '%s is a singleton class and you cannot create a second instance.', 'bbpress-string-swap' ), get_class( $this ) );

	    	wp_die( $bbpsswap_notice );

	    }

		/** Store the object in a static property */
		self::$_this = $this;
		
		/** Load admin area stuff */
		add_action( 'admin_init', array( $this, 'admin_settings' ), 15 );

		/** Load further plugin init methods */
		add_action( 'init', array( $this, 'bbpsswap_init' ) );

		/**
		 * Triggers our string swap filters for bbPress
		 *
		 * Note: Not using class methods here, to have non-anonymous filter callbacks
		 *   in order to let them still be removable by other plugins etc.
		 * Note: The Gettext filters are loaded seperately for proper priorities and display.
		 *   (see plugin file '/includes/bbpsswap-frontend.php')
		 */
		add_filter( 'bbp_get_forum_archive_title',			'ddw_bbpsswap_display_bbpress_forum_archive_title'	);
		add_filter( 'bbp_before_get_breadcrumb_parse_args',	'ddw_bbpsswap_display_bbpress_breadcrumb_home_text'	);
		add_filter( 'bbp_before_get_breadcrumb_parse_args',	'ddw_bbpsswap_display_bbpress_breadcrumb_root_text'	);
		add_filter( 'bbp_before_get_breadcrumb_parse_args',	'ddw_bbpsswap_display_bbpress_breadcrumb_sep',		1 );
		add_filter( 'bbp_topic_pagination',					'ddw_bbpsswap_display_topic_pagination_prev'		);
		add_filter( 'bbp_topic_pagination',					'ddw_bbpsswap_display_topic_pagination_next'		);
		add_filter( 'bbp_replies_pagination',				'ddw_bbpsswap_display_reply_pagination_prev'		);
		add_filter( 'bbp_replies_pagination',				'ddw_bbpsswap_display_reply_pagination_next'		);

		/** Triggers plugin activation check */
		register_activation_hook( __FILE__, array( $this, 'activation_hook' ) );

	}  // end of method __construct


	/**
	 * Returns the value of "self::$_this".
	 *    This function will be public by default
	 *    providing read-only access to the single instance used by the plugin's class.
	 *
	 * @link   http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 *
	 * @since  1.3.0
	 *
	 * @return the value of self::$_this.
	 */
	static function this() {

		return $_this;

	}  // end of method this


	/**
	 * Plugin class activation
	 *
	 * Check to see if bbPress is activated, if not display error message.
	 *   If bbPress is already active setup default values for our options.
	 *
	 * @since 1.0.0
	 */
	function activation_hook() {

		/** Obviously, this wouldn't work to well without bbPress 2.x */
        	if ( ! class_exists( 'bbPress' ) ) {

			/** Deactivate ourself */
			deactivate_plugins( plugin_basename( __FILE__ ) );

			/** WordPress error message output */
			wp_die( sprintf( __( 'Sorry, you need to install and/or activate %s plugin version first.', 'bbpress-string-swap' ), '<a href="http://wordpress.org/extend/plugins/bbpress/" target="_new" title="bbPress 2.x">bbPress 2.x</a>' ) );

		}  // end-if bbPress check
		
		/** Define default values */
		$bbpsswap_forum_archive_title			= __( 'Forums', 'bbpress-string-swap' );
		$bbpsswap_breadcrumb_args_home_text		= __( 'Home', 'bbpress-string-swap' );
		$bbpsswap_breadcrumb_args_root_text		= __( 'Forums', 'bbpress-string-swap' );
		$bbpsswap_breadcrumb_args_sep			= __( '&rsaquo;', 'bbpress-string-swap' );
		$bbpsswap_user_display_key_master		= __( 'Key Master', 'bbpress-string-swap' );
		$bbpsswap_user_display_moderator		= __( 'Moderator', 'bbpress-string-swap' );
		$bbpsswap_user_display_participant		= __( 'Participant', 'bbpress-string-swap' );	// bbPress 2.2+
		$bbpsswap_user_display_spectator		= __( 'Spectator', 'bbpress-string-swap' );		// bbPress 2.2+
		$bbpsswap_user_display_visitor			= __( 'Visitor', 'bbpress-string-swap' );		// bbPress 2.2+
		$bbpsswap_user_display_blocked			= __( 'Blocked', 'bbpress-string-swap' );		// bbPress 2.2+
		$bbpsswap_user_display_member			= __( 'Member', 'bbpress-string-swap' );
		$bbpsswap_user_display_guest			= __( 'Guest', 'bbpress-string-swap' );
		$bbpsswap_display_posts					= __( 'Posts', 'bbpress-string-swap' );
		$bbpsswap_display_startedby				= __( 'Started by: %1$s', 'bbpress-string-swap' );
		$bbpsswap_display_freshness				= __( 'Freshness', 'bbpress-string-swap' );
		$bbpsswap_display_voices				= __( 'Voices', 'bbpress-string-swap' );
		$bbpsswap_display_submit				= __( 'Submit', 'bbpress-string-swap' );
		$bbpsswap_topic_pagination_prev_text	= __( '&larr;', 'bbpress-string-swap' );
		$bbpsswap_topic_pagination_next_text	= __( '&rarr;', 'bbpress-string-swap' );
		$bbpsswap_reply_pagination_prev_text	= __( '&larr;', 'bbpress-string-swap' );
		$bbpsswap_reply_pagination_next_text	= __( '&rarr;', 'bbpress-string-swap' );
		
		/** Set the default values on activation */
			// Forum Archive Title:
		if ( ! get_option( 'ddw_bbpress_forums_archive_title' ) ) {
			update_option( 'ddw_bbpress_forums_archive_title', esc_attr__( $bbpsswap_forum_archive_title ) );
		}

			// Breadcrumb parameters:
		if ( ! get_option( 'ddw_bbpress_breadcrumb_args_home_text' ) ) {
			update_option( 'ddw_bbpress_breadcrumb_args_home_text', esc_attr__( $bbpsswap_breadcrumb_args_home_text ) );
		}

		if ( ! get_option( 'ddw_bbpress_breadcrumb_args_root_text' ) ) {
			update_option( 'ddw_bbpress_breadcrumb_args_root_text', esc_attr__( $bbpsswap_breadcrumb_args_root_text ) );
		}

		if ( ! get_option( 'ddw_bbpress_breadcrumb_args_separator' ) ) {
			update_option( 'ddw_bbpress_breadcrumb_args_separator', esc_attr__( $bbpsswap_breadcrumb_args_sep ) );
		}

			// User display names:
		if ( ! get_option( 'ddw_bbpress_user_display_key_master' ) ) {
			update_option( 'ddw_bbpress_user_display_key_master', esc_attr__( $bbpsswap_user_display_key_master ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_moderator' ) ) {
			update_option( 'ddw_bbpress_user_display_moderator', esc_attr__( $bbpsswap_user_display_moderator ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_participant' ) && function_exists( 'bbp_get_dynamic_roles' ) ) {
			update_option( 'ddw_bbpress_user_display_participant', esc_attr__( $bbpsswap_user_display_participant ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_spectator' ) && function_exists( 'bbp_get_dynamic_roles' ) ) {
			update_option( 'ddw_bbpress_user_display_spectator', esc_attr__( $bbpsswap_user_display_spectator ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_visitor' ) && function_exists( 'bbp_get_dynamic_roles' ) ) {
			update_option( 'ddw_bbpress_user_display_visitor', esc_attr__( $bbpsswap_user_display_visitor ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_blocked' ) && function_exists( 'bbp_get_dynamic_roles' ) ) {
			update_option( 'ddw_bbpress_user_display_blocked', esc_attr__( $bbpsswap_user_display_blocked ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_member' ) && ! function_exists( 'bbp_get_dynamic_roles' ) ) {
			update_option( 'ddw_bbpress_user_display_member', esc_attr__( $bbpsswap_user_display_member ) );
		}

		if ( ! get_option( 'ddw_bbpress_user_display_guest' ) && ! function_exists( 'bbp_get_dynamic_roles' ) ) {
			update_option( 'ddw_bbpress_user_display_guest', esc_attr__( $bbpsswap_user_display_guest ) );
		}

			// Misc. forums strings:
		if ( ! get_option( 'ddw_bbpress_display_posts' ) ) {
			update_option( 'ddw_bbpress_display_posts', esc_attr__( $bbpsswap_display_posts ) );
		}

		if ( ! get_option( 'ddw_bbpress_display_startedby' ) ) {
			update_option( 'ddw_bbpress_display_startedby', esc_attr__( $bbpsswap_display_startedby ) );
		}

		if ( ! get_option( 'ddw_bbpress_display_freshness' ) ) {
			update_option( 'ddw_bbpress_display_freshness', esc_attr__( $bbpsswap_display_freshness ) );
		}

		if ( ! get_option( 'ddw_bbpress_display_voices' ) ) {
			update_option( 'ddw_bbpress_display_voices', esc_attr__( $bbpsswap_display_voices ) );
		}

		if ( ! get_option( 'ddw_bbpress_display_submit' ) ) {
			update_option( 'ddw_bbpress_display_submit', esc_attr__( $bbpsswap_display_submit ) );
		}

			// Topic & Reply pagination parameters:
		if ( ! get_option( 'ddw_bbpress_topic_pagination_prev_text' ) ) {
			update_option( 'ddw_bbpress_topic_pagination_prev_text', esc_attr__( $bbpsswap_topic_pagination_prev_text ) );
		}

		if ( ! get_option( 'ddw_bbpress_topic_pagination_next_text' ) ) {
			update_option( 'ddw_bbpress_topic_pagination_next_text', esc_attr__( $bbpsswap_topic_pagination_next_text ) );
		}

		if ( ! get_option( 'ddw_bbpress_reply_pagination_prev_text' ) ) {
			update_option( 'ddw_bbpress_reply_pagination_prev_text', esc_attr__( $bbpsswap_reply_pagination_prev_text ) );
		}

		if ( ! get_option( 'ddw_bbpress_reply_pagination_next_text' ) ) {
			update_option( 'ddw_bbpress_reply_pagination_next_text', esc_attr__( $bbpsswap_reply_pagination_next_text ) );
		}

	}  // end of method activation_hook


	/**
	 * Plugin init functions.
	 *
	 * Load Translations and plugin settings links.
	 *
	 * @since 1.0.0
	 *
	 * @uses  apply_filters() For filtering translations file directories
	 * @uses  load_plugin_textdomain() For loading the translations
	 * @uses  is_admin()
	 * @uses  current_user_can()
	 *
	 * @param string $bbpsswap_wp_lang_dir
	 * @param string $bbpsswap_lang_dir
	 */
	function bbpsswap_init() {

		/** Set filter for WordPress languages directory */
		$bbpsswap_wp_lang_dir = BBPSSWAP_PLUGIN_BASEDIR . '/../../languages/bbpress-string-swap/';
		$bbpsswap_wp_lang_dir = apply_filters( 'bbpsswap_filter_wp_lang_dir', $bbpsswap_wp_lang_dir );

		/** Set filter for plugin's languages directory */
		$bbpsswap_lang_dir = BBPSSWAP_PLUGIN_BASEDIR . '/languages/';
		$bbpsswap_lang_dir = apply_filters( 'bbpsswap_filter_lang_dir', $bbpsswap_lang_dir );

		/** First look in WordPress' "languages" folder = custom & update-secure! */
		load_plugin_textdomain( 'bbpress-string-swap', false, $bbpsswap_wp_lang_dir );

		/** Then look in plugin's "languages" folder = default */
		load_plugin_textdomain( 'bbpress-string-swap', false, $bbpsswap_lang_dir );

		/** Load the admin and frontend functions only when needed */
		if ( is_admin() ) {

			require_once( BBPSSWAP_PLUGIN_DIR . '/includes/bbpsswap-admin-extras.php' );

		} else {

			require_once( BBPSSWAP_PLUGIN_DIR . '/includes/bbpsswap-frontend.php' );

		}  // end-if is_admin() check

		/** Add "Settings Page" link to plugin page */
		if ( is_admin() && current_user_can( 'manage_options' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_settings_link' ), 10, 2 );
		}

	}  // end of method bbpsswap_init


	/**
	 * Add "Settings Page" link to plugin page
	 *
	 * @since  1.0.0
	 *
	 * @param  $bbpsswap_links
	 * @param  $bbpsswap_settings_link
	 *
	 * @return strings Settings link
	 */
	function add_settings_link( $bbpsswap_links ) {

		$bbpsswap_settings_link = sprintf( '<a href="%s" title="%s">%s</a>' , admin_url( 'options-general.php?page=bbpress#bbpress-string-swap' ) , __( 'Go to the bbPress settings page', 'bbpress-string-swap' ) , __( 'Settings', 'bbpress-string-swap' ) );
	
		array_unshift( $bbpsswap_links, $bbpsswap_settings_link );

		return apply_filters( 'bbpsswap_filter_settings_page_link', $bbpsswap_links );

	}  // end of method add_settings_link


	/**
	 * Setup and register Admin Settings
	 *
	 * Setup all the settings on the main bbPress forum settings page.
	 * Hooking in our own section.
	 *
	 * @since 1.0.0
	 */
	function admin_settings() {

		/** Add the section to primary bbPress options */
		$bbpsswap_settings_header =
				'<div id="bbpress-string-swap"><br />' .
				'<em>' . __( 'Plugin', 'bbpress-string-swap' ) . ':</em> ' . __( 'bbPress String Swap', 'bbpress-string-swap' ) . ' <small>v' . ddw_bbpsswap_plugin_get_data( 'Version' ) . '</small>' .
				'<br />&rarr; ' . __( 'Change Forums Archive Title, some Breadcrumb Arguments, User Role display names, some Topics & Replies pagination parameters, some other Forums Strings', 'bbpress-string-swap' ) . '</div>';

		add_settings_section(
					'ddw_bbpress_string_swap_options',
					$bbpsswap_settings_header,
					array( $this, 'section_heading' ),
					'bbpress'
		);

		/** Add Forums Archive Title settings field */
		add_settings_field(
					'ddw_bbpress_forums_archive_title',
					__( 'Forums Archive Title', 'bbpress-string-swap' ),
					array( $this, 'forums_archive_title_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add Breadcrumb Home Text settings field */
		add_settings_field(
					'ddw_bbpress_breadcrumb_args_home_text',
					__( 'Breadcrumb: Home Text', 'bbpress-string-swap' ),
					array( $this, 'breadcrumb_args_home_text_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add Breadcrumb Root Text settings field */
		add_settings_field(
					'ddw_bbpress_breadcrumb_args_root_text',
					__( 'Breadcrumb: Root Text', 'bbpress-string-swap' ),
					array( $this, 'breadcrumb_args_root_text_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add Breadcrumb Separator String settings field */
		add_settings_field(
					'ddw_bbpress_breadcrumb_args_separator',
					__( 'Breadcrumb: Separator String', 'bbpress-string-swap' ),
					array( $this, 'breadcrumb_args_sep_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add User Display 'Key Master' settings field */
		add_settings_field(
					'ddw_bbpress_user_display_key_master',
					__( 'User Role Display: Key Master', 'bbpress-string-swap' ),
					array( $this, 'user_display_key_master_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add User Display 'Moderator' settings field */
		add_settings_field(
					'ddw_bbpress_user_display_moderator',
					__( 'User Role Display: Moderator', 'bbpress-string-swap' ),
					array( $this, 'user_display_moderator_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Check for bbPress v2.2 / v2.1 functions */
		if ( function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {

			/** Add User Display 'Participant' settings field */
			add_settings_field(
						'ddw_bbpress_user_display_participant',
						__( 'User Role Display: Participant', 'bbpress-string-swap' ),
						array( $this, 'user_display_participant_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);

		} elseif ( ! function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {

			/** Add User Display 'Member' settings field */
			add_settings_field(
						'ddw_bbpress_user_display_member',
						__( 'User Role Display: Member', 'bbpress-string-swap' ),
						array( $this, 'user_display_member_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);

		}  // end-if bbPress versions check

		/** Add User Display 'Spectator' settings field */
		if ( function_exists( 'bbp_get_spectator_role' ) ) {
			add_settings_field(
						'ddw_bbpress_user_display_spectator',
						__( 'User Role Display: Spectator', 'bbpress-string-swap' ),
						array( $this, 'user_display_spectator_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);
		}

		/** Add User Display 'Visitor' settings field */
		if ( function_exists( 'bbp_get_visitor_role' ) ) {
			add_settings_field(
						'ddw_bbpress_user_display_visitor',
						__( 'User Role Display: Visitor', 'bbpress-string-swap' ),
						array( $this, 'user_display_visitor_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);
		}

		/** Add User Display 'Blocked' settings field */
		if ( function_exists( 'bbp_get_blocked_role' ) ) {
			add_settings_field(
						'ddw_bbpress_user_display_blocked',
						__( 'User Role Display: Blocked', 'bbpress-string-swap' ),
						array( $this, 'user_display_blocked_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);
		}

		/** Add User Display 'Guest' settings field */
		if ( function_exists( 'bbp_get_anonymous_role' ) ) {
			add_settings_field(
						'ddw_bbpress_user_display_guest',
						__( 'User Role Display: Guest', 'bbpress-string-swap' ),
						array( $this, 'user_display_guest_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);
		}

		/** Add 'Posts' String settings field */
		add_settings_field(
					'ddw_bbpress_display_posts',
					__( 'Forum String: Posts', 'bbpress-string-swap' ),
					array( $this, 'forum_display_posts_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Started by' String settings field */
		add_settings_field(
					'ddw_bbpress_display_startedby',
					__( 'Forum String: Started by (user)', 'bbpress-string-swap' ),
					array( $this, 'forum_display_startedby_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Freshness' String settings field */
		//if ( function_exists( 'bbp_get_anonymous_role' ) ) {
			add_settings_field(
						'ddw_bbpress_display_freshness',
						__( 'Forum String: Freshness', 'bbpress-string-swap' ),
						array( $this, 'forum_display_freshness_input' ),
						'bbpress',
						'ddw_bbpress_string_swap_options'
			);
		//}

		/** Add 'Voices' String settings field */
		add_settings_field(
					'ddw_bbpress_display_voices',
					__( 'Forum String: Voices', 'bbpress-string-swap' ),
					array( $this, 'forum_display_voices_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Submit' String settings field */
		add_settings_field(
					'ddw_bbpress_display_submit',
					__( 'Forum String: Submit', 'bbpress-string-swap' ),
					array( $this, 'forum_display_submit_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Topic Pagination Prev' string settings field */
		add_settings_field(
					'ddw_bbpress_topic_pagination_prev_text',
					__( 'Topic Pagination: Prev String/Text', 'bbpress-string-swap' ),
					array( $this, 'topic_pagination_prev_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Topic Pagination Next' string settings field */
		add_settings_field(
					'ddw_bbpress_topic_pagination_next_text',
					__( 'Topic Pagination: Next String/Text', 'bbpress-string-swap' ),
					array( $this, 'topic_pagination_next_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Reply Pagination Prev' string settings field */
		add_settings_field(
					'ddw_bbpress_reply_pagination_prev_text',
					__( 'Reply Pagination: Prev String/Text', 'bbpress-string-swap' ),
					array( $this, 'reply_pagination_prev_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Add 'Reply Pagination Next' string settings field */
		add_settings_field(
					'ddw_bbpress_reply_pagination_next_text',
					__( 'Reply Pagination: Next String/Text', 'bbpress-string-swap' ),
					array( $this, 'reply_pagination_next_input' ),
					'bbpress',
					'ddw_bbpress_string_swap_options'
		);

		/** Register our settings with the bbPress forum settings page */
		register_setting( 'bbpress', 'ddw_bbpress_forums_archive_title', array( $this, 'validate_forums_archive_title' ) );
		register_setting( 'bbpress', 'ddw_bbpress_breadcrumb_args_home_text', array( $this, 'validate_breadcrumb_args_home_text' ) );
		register_setting( 'bbpress', 'ddw_bbpress_breadcrumb_args_root_text', array( $this, 'validate_breadcrumb_args_root_text' ) );
		register_setting( 'bbpress', 'ddw_bbpress_breadcrumb_args_separator', /* 'strval' */ array( $this, 'validate_breadcrumb_args_sep' ) );


		register_setting( 'bbpress', 'ddw_bbpress_user_display_key_master', array( $this, 'validate_user_display_key_master' ) );
		register_setting( 'bbpress', 'ddw_bbpress_user_display_moderator', array( $this, 'validate_user_display_moderator' ) );

		if ( function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {
			register_setting( 'bbpress', 'ddw_bbpress_user_display_participant', array( $this, 'validate_user_display_participant' ) );
		} elseif ( ! function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {
			register_setting( 'bbpress', 'ddw_bbpress_user_display_member', array( $this, 'validate_user_display_member' ) );
		}

		if ( function_exists( 'bbp_get_spectator_role' ) ) {
			register_setting( 'bbpress', 'ddw_bbpress_user_display_spectator', array( $this, 'validate_user_display_spectator' ) );
		}

		if ( function_exists( 'bbp_get_visitor_role' ) ) {
			register_setting( 'bbpress', 'ddw_bbpress_user_display_visitor', array( $this, 'validate_user_display_visitor' ) );
		}

		if ( function_exists( 'bbp_get_visitor_role' ) ) {
			register_setting( 'bbpress', 'ddw_bbpress_user_display_blocked', array( $this, 'validate_user_display_blocked' ) );
		}

		if ( function_exists( 'bbp_get_anonymous_role' ) ) {
			register_setting( 'bbpress', 'ddw_bbpress_user_display_guest', array( $this, 'validate_user_display_guest' ) );
		}

		register_setting( 'bbpress', 'ddw_bbpress_display_posts', array( $this, 'validate_display_posts' ) );
		register_setting( 'bbpress', 'ddw_bbpress_display_startedby', array( $this, 'validate_display_startedby' ) );
		register_setting( 'bbpress', 'ddw_bbpress_display_freshness', array( $this, 'validate_display_freshness' ) );
		register_setting( 'bbpress', 'ddw_bbpress_display_voices', array( $this, 'validate_display_voices' ) );
		register_setting( 'bbpress', 'ddw_bbpress_display_submit', array( $this, 'validate_display_submit' ) );//
		register_setting( 'bbpress', 'ddw_bbpress_topic_pagination_prev_text', array( $this, 'validate_topic_pagination_prev' ) );
		register_setting( 'bbpress', 'ddw_bbpress_topic_pagination_next_text', array( $this, 'validate_topic_pagination_next' ) );
		register_setting( 'bbpress', 'ddw_bbpress_reply_pagination_prev_text', array( $this, 'validate_reply_pagination_prev' ) );
		register_setting( 'bbpress', 'ddw_bbpress_reply_pagination_next_text', array( $this, 'validate_reply_pagination_next' ) );

	}  // end of method admin_settings


	/**
	 * Section heading information
	 *
	 * Output description and hints for this settings area within the bbPress Main Settings page.
	 *
	 * @since 1.0.0
	 */
	function section_heading() {

		echo '<p id="bbpress-string-swap-info">' . __( 'Set the the Forums Archive title for the forums main page. Change some important Breadcrumb values within the bbPress Breadcrumb display. Change displayed User Role names. Change a few important other Forum strings. Change some Pagination parameters for Topics &amp; Replies.', 'bbpress-string-swap' ) .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Leave any field blank to display the default value.', 'bbpress-string-swap' ) . '</small></p>';

	}  // end of method section_heading

	
	/**
	 * Forums Archive Title input field.
	 *
	 * @since 1.0.0
	 *
	 * @param string $bbpsswap_forums_title_input
	 */
	function forums_archive_title_input() {

		$bbpsswap_forums_title_input = get_option( 'ddw_bbpress_forums_archive_title' );

		echo '<input id="ddw_bbpress_forums_archive_title" name="ddw_bbpress_forums_archive_title" value="' . $bbpsswap_forums_title_input . '" type="text" class="text" />';

		echo ' <label>' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Forums', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method forums_archive_title_input


	/**
	 * Breadcrumb: Home Text input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_breadcrumb_args_home_text
	 */
	function breadcrumb_args_home_text_input() {

		$bbpsswap_breadcrumb_args_home_text = get_option( 'ddw_bbpress_breadcrumb_args_home_text' );

		echo '<input id="ddw_bbpress_breadcrumb_args_home_text" name="ddw_bbpress_breadcrumb_args_home_text" value="' . $bbpsswap_breadcrumb_args_home_text . '" type="text" class="text" />';

		echo ' <label>' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Home', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method breadcrumb_args_home_text_input


	/**
	 * Breadcrumb: Root Text input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_breadcrumb_args_root_text
	 */
	function breadcrumb_args_root_text_input() {

		$bbpsswap_breadcrumb_args_root_text = get_option( 'ddw_bbpress_breadcrumb_args_root_text' );

		echo '<input id="ddw_bbpress_breadcrumb_args_root_text" name="ddw_bbpress_breadcrumb_args_root_text" value="' . $bbpsswap_breadcrumb_args_root_text . '" type="text" class="text" />';

		echo ' <label>' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Forums', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method breadcrumb_args_root_text_input


	/**
	 * Breadcrumb: Separator String input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_breadcrumb_args_sep
	 */
	function breadcrumb_args_sep_input() {

		$bbpsswap_breadcrumb_args_sep = get_option( 'ddw_bbpress_breadcrumb_args_separator' );

		echo '<input id="ddw_bbpress_breadcrumb_args_separator" name="ddw_bbpress_breadcrumb_args_separator" value="' . $bbpsswap_breadcrumb_args_sep . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_breadcrumb_args_separator">' . __( 'Recommeded to enter string value like one of the following:', 'bbpress-string-swap' ). ' <code>&gt;</code>, <code>&raquo;</code>, <code>&rarr;</code>, <code>|</code> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>&rsaquo;</code></label>';

	}  // end of method breadcrumb_args_sep_input


	/**
	 * User Display: 'Key Master' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_user_display_key_master
	 */
	function user_display_key_master_input() {

		$bbpsswap_user_display_key_master = get_option( 'ddw_bbpress_user_display_key_master' );

		echo '<input id="ddw_bbpress_user_display_key_master" name="ddw_bbpress_user_display_key_master" value="' . $bbpsswap_user_display_key_master . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_key_master">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Key Master', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_key_master_input


	/**
	 * User Display: 'Moderator' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_user_display_moderator
	 */
	function user_display_moderator_input() {

		$bbpsswap_user_display_moderator = get_option( 'ddw_bbpress_user_display_moderator' );

		echo '<input id="ddw_bbpress_user_display_moderator" name="ddw_bbpress_user_display_moderator" value="' . $bbpsswap_user_display_moderator . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_moderator">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Moderator', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_moderator_input


	/**
	 * User Display: 'Participant' input field.
	 *
	 * @since 1.2.0
	 *
	 * @param $bbpsswap_user_display_participant
	 */
	function user_display_participant_input() {

		$bbpsswap_user_display_participant = get_option( 'ddw_bbpress_user_display_participant' );

		echo '<input id="ddw_bbpress_user_display_participant" name="ddw_bbpress_user_display_participant" value="' . $bbpsswap_user_display_participant . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_participant">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Participant', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_participant_input


	/**
	 * User Display: 'Spectator' input field.
	 *
	 * @since 1.2.0
	 *
	 * @param $bbpsswap_user_display_spectator
	 */
	function user_display_spectator_input() {

		$bbpsswap_user_display_spectator = get_option( 'ddw_bbpress_user_display_spectator' );

		echo '<input id="ddw_bbpress_user_display_spectator" name="ddw_bbpress_user_display_spectator" value="' . $bbpsswap_user_display_spectator . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_spectator">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Spectator', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_spectator_input


	/**
	 * User Display: 'Visitor' input field.
	 *
	 * @since 1.2.0
	 *
	 * @param $bbpsswap_user_display_visitor
	 */
	function user_display_visitor_input() {

		$bbpsswap_user_display_spectator = get_option( 'ddw_bbpress_user_display_visitor' );

		echo '<input id="ddw_bbpress_user_display_visitor" name="ddw_bbpress_user_display_visitor" value="' . $bbpsswap_user_display_visitor . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_visitor">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Visitor', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_visitor_input


	/**
	 * User Display: 'Blocked' input field.
	 *
	 * @since 1.2.0
	 *
	 * @param $bbpsswap_user_display_blocked
	 */
	function user_display_blocked_input() {

		$bbpsswap_user_display_blocked = get_option( 'ddw_bbpress_user_display_blocked' );

		echo '<input id="ddw_bbpress_user_display_blocked" name="ddw_bbpress_user_display_blocked" value="' . $bbpsswap_user_display_blocked . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_blocked">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Blocked', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_blocked_input


	/**
	 * User Display: 'Member' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_user_display_member
	 */
	function user_display_member_input() {

		$bbpsswap_user_display_member = get_option( 'ddw_bbpress_user_display_member' );

		echo '<input id="ddw_bbpress_user_display_member" name="ddw_bbpress_user_display_member" value="' . $bbpsswap_user_display_member . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_member">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Member', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_member_input


	/**
	 * User Display: 'Guest' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_user_display_guest
	 */
	function user_display_guest_input() {

		$bbpsswap_user_display_guest = get_option( 'ddw_bbpress_user_display_guest' );

		echo '<input id="ddw_bbpress_user_display_guest" name="ddw_bbpress_user_display_guest" value="' . $bbpsswap_user_display_guest . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_user_display_guest">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Guest', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_guest_input


	/**
	 * Forum Display: 'Posts' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_display_posts
	 */
	function forum_display_posts_input() {

		$bbpsswap_display_posts = get_option( 'ddw_bbpress_display_posts' );

		echo '<input id="ddw_bbpress_display_posts" name="ddw_bbpress_display_posts" value="' . $bbpsswap_display_posts . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_display_posts">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Posts', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used as the overall count of posts in a Topic. That means the initial starting Topic plus all its Replies.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_posts_input


	/**
	 * Forum Display: 'Started by: %1$s' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_display_startedby
	 */
	function forum_display_startedby_input() {

		$bbpsswap_display_startedby = get_option( 'ddw_bbpress_display_startedby' );

		echo '<input id="ddw_bbpress_display_startedby" name="ddw_bbpress_display_startedby" value="' . $bbpsswap_display_startedby . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_display_startedby">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Started by: %1$s', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in a single Forum presentation of all its Topics to represent the user who posted the initial starting Topic.', 'bbpress-string-swap' ) .
			'<br />' . sprintf( __( 'It\'s very important to include the Gettext placeholder string %s here. Otherwise the the actual user name cannot be displayed!', 'bbpress-string-swap' ), '<code>%1$s</code>' ) . '</small>';

	}  // end of method forum_display_startedby_input


	/**
	 * Forum Display: 'Freshness' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_display_freshness
	 */
	function forum_display_freshness_input() {

		$bbpsswap_display_freshness = get_option( 'ddw_bbpress_display_freshness' );

		echo '<input id="ddw_bbpress_display_freshness" name="ddw_bbpress_display_freshness" value="' . $bbpsswap_display_freshness . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_display_freshness">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Freshness', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in several overview presentions of Forums and Topics.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_freshness_input


	/**
	 * Forum Display: 'Voices' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_display_voices
	 */
	function forum_display_voices_input() {

		$bbpsswap_display_voices = get_option( 'ddw_bbpress_display_voices' );

		echo '<input id="ddw_bbpress_display_voices" name="ddw_bbpress_display_voices" value="' . $bbpsswap_display_voices . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_display_voices">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Voices', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in several overview presentions of Forums and Topics.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_voices_input


	/**
	 * Forum Display: 'Submit' input field.
	 *
	 * @since 1.0.0
	 *
	 * @param $bbpsswap_display_submit
	 */
	function forum_display_submit_input() {

		$bbpsswap_display_submit = get_option( 'ddw_bbpress_display_submit' );

		echo '<input id="ddw_bbpress_display_submit" name="ddw_bbpress_display_submit" value="' . $bbpsswap_display_submit . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_display_submit">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Submit', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used as the submit button string in Topics and Replies.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_submit_input


	/**
	 * Topic Pagination: 'Prev Text' input field.
	 *
	 * @since 1.1.0
	 *
	 * @param $bbpsswap_topic_pagination_prev
	 */
	function topic_pagination_prev_input() {

		$bbpsswap_topic_pagination_prev = get_option( 'ddw_bbpress_topic_pagination_prev_text' );

		echo '<input id="ddw_bbpress_topic_pagination_prev_text" name="ddw_bbpress_topic_pagination_prev_text" value="' . $bbpsswap_topic_pagination_prev . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_topic_pagination_prev_text">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&larr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_prev_input


	/**
	 * Topic Pagination: 'Next Text' input field.
	 *
	 * @since 1.1.0
	 *
	 * @param $bbpsswap_topic_pagination_next
	 */
	function topic_pagination_next_input() {

		$bbpsswap_topic_pagination_next = get_option( 'ddw_bbpress_topic_pagination_next_text' );

		echo '<input id="ddw_bbpress_topic_pagination_next_text" name="ddw_bbpress_topic_pagination_next_text" value="' . $bbpsswap_topic_pagination_next . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_topic_pagination_next_text">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&rarr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_next_input


	/**
	 * Reply Pagination: 'Prev Text' input field.
	 *
	 * @since 1.1.0
	 *
	 * @param $bbpsswap_reply_pagination_prev
	 */
	function reply_pagination_prev_input() {

		$bbpsswap_reply_pagination_prev = get_option( 'ddw_bbpress_reply_pagination_prev_text' );

		echo '<input id="ddw_bbpress_reply_pagination_prev_text" name="ddw_bbpress_reply_pagination_prev_text" value="' . $bbpsswap_reply_pagination_prev . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_reply_pagination_prev_text">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&larr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_reply_input


	/**
	 * Reply Pagination: 'Next Text' input field.
	 *
	 * @since 1.1.0
	 *
	 * @param $bbpsswap_reply_pagination_next
	 */
	function reply_pagination_next_input() {

		$bbpsswap_reply_pagination_next = get_option( 'ddw_bbpress_reply_pagination_next_text' );

		echo '<input id="ddw_bbpress_reply_pagination_next_text" name="ddw_bbpress_reply_pagination_next_text" value="' . $bbpsswap_reply_pagination_next . '" type="text" class="text" />';

		echo ' <label for="ddw_bbpress_reply_pagination_next_text">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&rarr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_reply_input


	/**
	 * Validate Forums Archive Title
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 * 
	 * @param  string $bbpsswap_forums_title
	 *
	 * @return string
	 */
	function validate_forums_archive_title( $bbpsswap_forums_title ) {

		$bbpsswap_forums_title = esc_html( $bbpsswap_forums_title );

		return $bbpsswap_forums_title;

	}  // end of method validate_forums_archive_title


	/**
	 * Validate Breadcrumb Home Text
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_breadrumb_args_home_text
	 *
	 * @return string
	 */
	function validate_breadcrumb_args_home_text( $bbpsswap_breadrumb_args_home_text ) {

		$bbpsswap_breadrumb_args_home_text = esc_html( $bbpsswap_breadrumb_args_home_text );

		return $bbpsswap_breadrumb_args_home_text;

	}  // end of method validate_breadcrumb_args_home_text


	/**
	 * Validate Breadcrumb Root Text
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_breadrumb_args_root_text
	 *
	 * @return string
	 */
	function validate_breadcrumb_args_root_text( $bbpsswap_breadrumb_args_root_text ) {

		$bbpsswap_breadrumb_args_root_text = esc_html( $bbpsswap_breadrumb_args_root_text );

		return $bbpsswap_breadrumb_args_root_text;

	}  // end of method validate_breadcrumb_args_root_text


	/**
	 * Validate Breadcrumb Separator String
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_breadrumb_args_sep
	 *
	 * @return string
	 */
	function validate_breadcrumb_args_sep( $bbpsswap_breadrumb_args_sep ) {

		$bbpsswap_breadrumb_args_sep = esc_html( $bbpsswap_breadrumb_args_sep );

		return $bbpsswap_breadrumb_args_sep;

	}  // end of method validate_breadcrumb_args_sep


	/**
	 * Validate User Display 'Key Master'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_user_display_key_master
	 *
	 * @return string
	 */
	function validate_user_display_key_master( $bbpsswap_user_display_key_master ) {

		$bbpsswap_user_display_key_master = esc_html( $bbpsswap_user_display_key_master );

		return $bbpsswap_user_display_key_master;

	}  // end of method validate_user_display_key_master


	/**
	 * Validate User Display 'Moderator'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_user_display_moderator
	 *
	 * @return string
	 */
	function validate_user_display_moderator( $bbpsswap_user_display_moderator ) {

		$bbpsswap_user_display_moderator = esc_html( $bbpsswap_user_display_moderator );

		return $bbpsswap_user_display_moderator;

	}  // end of method validate_user_display_moderator


	/**
	 * Validate User Display 'Participant'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.2.0
	 *
	 * @param  string $bbpsswap_user_display_participant
	 *
	 * @return string
	 */
	function validate_user_display_participant( $bbpsswap_user_display_participant ) {

		$bbpsswap_user_display_participant = esc_html( $bbpsswap_user_display_participant );

		return $bbpsswap_user_display_participant;

	}  // end of method validate_user_display_participant


	/**
	 * Validate User Display 'Spectator'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.2.0
	 *
	 * @param  string $bbpsswap_user_display_spectator
	 *
	 * @return string
	 */
	function validate_user_display_spectator( $bbpsswap_user_display_spectator ) {

		$bbpsswap_user_display_spectator = esc_html( $bbpsswap_user_display_spectator );

		return $bbpsswap_user_display_spectator;

	}  // end of method validate_user_display_spectator


	/**
	 * Validate User Display 'Visitor'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.2.0
	 *
	 * @param  string $bbpsswap_user_display_visitor
	 *
	 * @return string
	 */
	function validate_user_display_visitor( $bbpsswap_user_display_visitor ) {

		$bbpsswap_user_display_visitor = esc_html( $bbpsswap_user_display_visitor );

		return $bbpsswap_user_display_visitor;

	}  // end of method validate_user_display_visitor


	/**
	 * Validate User Display 'Blocked'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.2.0
	 *
	 * @param  string $bbpsswap_user_display_blocked
	 *
	 * @return string
	 */
	function validate_user_display_blocked( $bbpsswap_user_display_blocked ) {

		$bbpsswap_user_display_blocked = esc_html( $bbpsswap_user_display_blocked );

		return $bbpsswap_user_display_blocked;

	}  // end of method validate_user_display_blocked


	/**
	 * Validate User Display 'Member'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_user_display_member
	 *
	 * @return string
	 */
	function validate_user_display_member( $bbpsswap_user_display_member ) {

		$bbpsswap_user_display_member = esc_html( $bbpsswap_user_display_member );

		return $bbpsswap_user_display_member;

	}  // end of method validate_user_display_member


	/**
	 * Validate User Display 'Guest'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_user_display_guest
	 *
	 * @return string
	 */
	function validate_user_display_guest( $bbpsswap_user_display_guest ) {

		$bbpsswap_user_display_guest = esc_html( $bbpsswap_user_display_guest );

		return $bbpsswap_user_display_guest;

	}  // end of method validate_user_display_guest


	/**
	 * Validate Forum String 'Posts'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_display_posts
	 *
	 * @return string
	 */
	function validate_display_posts( $bbpsswap_display_posts ) {

		$bbpsswap_display_posts = esc_html( $bbpsswap_display_posts );

		return $bbpsswap_display_posts;

	}  // end of method validate_display_posts


	/**
	 * Validate Forum String 'Started by'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_display_startedby
	 *
	 * @return string
	 */
	function validate_display_startedby( $bbpsswap_display_startedby ) {

		$bbpsswap_display_startedby = esc_html( $bbpsswap_display_startedby );

		return $bbpsswap_display_startedby;

	}  // end of method validate_display_startedby


	/**
	 * Validate Forum String 'Freshness'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_display_freshness
	 *
	 * @return string
	 */
	function validate_display_freshness( $bbpsswap_display_freshness ) {

		$bbpsswap_display_freshness = esc_html( $bbpsswap_display_freshness );

		return $bbpsswap_display_freshness;

	}  // end of method validate_display_freshness


	/**
	 * Validate Forum String 'Voices'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_display_voices
	 *
	 * @return string
	 */
	function validate_display_voices( $bbpsswap_display_voices ) {

		$bbpsswap_display_voices = esc_html( $bbpsswap_display_voices );

		return $bbpsswap_display_voices;

	}  // end of method validate_display_voices


	/**
	 * Validate Forum String 'Submit'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.0.0
	 *
	 * @param  string $bbpsswap_display_submit
	 *
	 * @return string
	 */
	function validate_display_submit( $bbpsswap_display_submit ) {

		$bbpsswap_display_submit = esc_html( $bbpsswap_display_submit );

		return $bbpsswap_display_submit;

	}  // end of method validate_display_submit


	/**
	 * Validate Topic Pagination String 'Prev'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.1.0
	 *
	 * @param  string $bbpsswap_topic_pagination_prev
	 *
	 * @return string
	 */
	function validate_topic_pagination_prev( $bbpsswap_topic_pagination_prev ) {

		$bbpsswap_topic_pagination_prev = esc_html( $bbpsswap_topic_pagination_prev );

		return $bbpsswap_topic_pagination_prev;

	}  // end of method validate_topic_pagination_prev


	/**
	 * Validate Topic Pagination String 'Next'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.1.0
	 *
	 * @param  string $bbpsswap_topic_pagination_next
	 *
	 * @return string
	 */
	function validate_topic_pagination_next( $bbpsswap_topic_pagination_next ) {

		$bbpsswap_topic_pagination_next = esc_html( $bbpsswap_topic_pagination_next );

		return $bbpsswap_topic_pagination_next;

	}  // end of method validate_topic_pagination_next


	/**
	 * Validate Reply Pagination String 'Prev'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.1.0
	 *
	 * @param  string $bbpsswap_reply_pagination_prev
	 *
	 * @return string
	 */
	function validate_reply_pagination_prev( $bbpsswap_reply_pagination_prev ) {

		$bbpsswap_reply_pagination_prev = esc_html( $bbpsswap_reply_pagination_prev );

		return $bbpsswap_reply_pagination_prev;

	}  // end of method validate_reply_pagination_prev


	/**
	 * Validate Reply Pagination String 'Next'
	 *
	 * Returns sanitized results
	 *
	 * @since  1.1.0
	 *
	 * @param  string $bbpsswap_reply_pagination_next
	 *
	 * @return string
	 */
	function validate_reply_pagination_next( $bbpsswap_reply_pagination_next ) {

		$bbpsswap_reply_pagination_next = esc_html( $bbpsswap_reply_pagination_next );

		return $bbpsswap_reply_pagination_next;

	}  // end of method validate_reply_pagination_next

}  // end of class DDW_bbPress_String_Swap


/** Instantiate the class */
//$bbpsswap_init = new DDW_bbPress_String_Swap;
new DDW_bbPress_String_Swap();