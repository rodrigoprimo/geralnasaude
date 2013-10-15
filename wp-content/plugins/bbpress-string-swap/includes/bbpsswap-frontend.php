<?php
/**
 * Filter functions and display logic for the frontend display of changed strings.
 *
 * @package    bbPress String Swap
 * @subpackage Frontend
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.0.0
 */

/**
 * Display the Forums Archive title.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_forums_title
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_forum_archive_title( $bbpsswap_forums_title ) {

	/** Get our option */
	$bbpsswap_forums_title = get_option( 'ddw_bbpress_forums_archive_title' );

	$bbpsswap_forums_title = esc_html( $bbpsswap_forums_title );

	/** Check for empty string */
	if ( empty( $bbpsswap_forums_title ) ) {

		$bbpsswap_forums_title = __( 'Forums', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_forum_archive_title', $bbpsswap_forums_title );

}  // end of function ddw_bbpsswap_display_bbpress_forum_archive_title


/**
 * Display the Breadcrumb Home Text.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_breadcrumb_args
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_breadcrumb_home_text( $bbpsswap_breadcrumb_args ) {

	/** Get our option */
	$bbpsswap_breadcrumb_args['home_text'] = get_option( 'ddw_bbpress_breadcrumb_args_home_text' );

	$bbpsswap_breadcrumb_args['home_text'] = esc_html( $bbpsswap_breadcrumb_args['home_text'] );

	/** Check for empty string */
	if ( empty( $bbpsswap_breadcrumb_args['home_text'] ) ) {

		$bbpsswap_breadcrumb_args['home_text'] = esc_attr__( 'Home', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_breadcrumb_home_text', $bbpsswap_breadcrumb_args );

}  // end of function ddw_bbpsswap_display_bbpress_breadcrumb_home_text


/**
 * Display the Breadcrumb Root Text.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_breadcrumb_args
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_breadcrumb_root_text( $bbpsswap_breadcrumb_args ) {

	/** Get our option */
	$bbpsswap_breadcrumb_args['root_text'] = get_option( 'ddw_bbpress_breadcrumb_args_root_text' );

	$bbpsswap_breadcrumb_args['root_text'] = esc_html( $bbpsswap_breadcrumb_args['root_text'] );

	/** Check for empty string */
	if ( empty( $bbpsswap_breadcrumb_args['root_text'] ) ) {

		$bbpsswap_breadcrumb_args['root_text'] = esc_attr__( 'Forums', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_breadcrumb_root_text', $bbpsswap_breadcrumb_args );

}  // end of function ddw_bbpsswap_display_bbpress_breadcrumb_root_text


/**
 * Display the Breadcrumb Separator String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_breadcrumb_args_sep
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_breadcrumb_sep( $bbpsswap_breadcrumb_args_sep ) {

	/** Get our option */
	$bbpsswap_breadcrumb_args_sep['sep'] = get_option( 'ddw_bbpress_breadcrumb_args_separator' );

	/** Check for empty string */
	if ( empty( $bbpsswap_breadcrumb_args_sep['sep'] ) ) {

		$bbpsswap_breadcrumb_args_sep['sep'] = esc_attr__( '&rsaquo;', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_breadcrumb_sep', $bbpsswap_breadcrumb_args_sep );

}  // end of function ddw_bbpsswap_display_bbpress_breadcrumb_sep


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_key_master_gettext', 10, 4 );
/**
 * Search for 'Key Master'/ 'Keymaster' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_key_master
 *
 * @return string For 'Key Master' user role
 */
function ddw_bbpsswap_display_user_role_key_master_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	$bbpsswap_user_display_key_master = get_option( 'ddw_bbpress_user_display_key_master' );

	/** Display 'Key Master' user role (before bbPress v2.2) */
	if ( is_bbpress() && $text == 'Key Master' ) {

		if ( empty( $bbpsswap_user_display_key_master ) ) {

			return $translations->translate( 'Key Master' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_key_master ) );

	}  // end-if key master check

	/** Display 'Keymaster' user role (bbPress 2.2+) */
	if ( is_bbpress() && $text == 'Keymaster' ) {

		if ( empty( $bbpsswap_user_display_key_master ) ) {

			return $translations->translate( 'Keymaster' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_key_master ) );

	}  // end-if keymaster check

	return apply_filters( 'bbpsswap_filter_user_role_key_master_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_key_master_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_moderator_gettext', 10, 4 );
/**
 * Search for 'Moderator' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_moderator
 *
 * @return string For 'Moderator' user role
 */
function ddw_bbpsswap_display_user_role_moderator_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	$bbpsswap_user_display_moderator = get_option( 'ddw_bbpress_user_display_moderator' );

	/** Display Moderator user role */
	if ( ( function_exists( 'bbp_get_moderator_role' ) && bbp_get_moderator_role() ) && $text == 'Moderator' ) {

		if ( empty( $bbpsswap_user_display_moderator ) ) {

			return $translations->translate( 'Moderator' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_moderator ) );

	}  // end-if moderator check

	return apply_filters( 'bbpsswap_filter_user_role_moderator_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_moderator_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_participant_gettext', 10, 4 );
/**
 * Search for 'Member'/ 'Participant' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_member
 * @param  string $bbpsswap_user_display_participant
 *
 * @return string For 'Member'/ 'Participant' user role
 */
function ddw_bbpsswap_display_user_role_participant_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display Member user role */
	if ( ( function_exists( 'bbp_get_participant_role' ) && bbp_get_participant_role() ) && $text == 'Member' ) {

		$bbpsswap_user_display_member = get_option( 'ddw_bbpress_user_display_member' );

		if ( empty( $bbpsswap_user_display_member ) ) {

			return $translations->translate( 'Member' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_member ) );

	}  // end-if member check

	/** Display 'Participant' user role */
	if ( ( function_exists( 'bbp_get_participant_role' ) && bbp_get_participant_role() ) && $text == 'Participant' ) {

		$bbpsswap_user_display_participant = get_option( 'ddw_bbpress_user_display_participant' );

		if ( empty( $bbpsswap_user_display_participant ) ) {

			return $translations->translate( 'Participant' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_participant ) );

	}  // end-if member check

	return apply_filters( 'bbpsswap_filter_user_role_participant_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_participant_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_spectator_gettext', 10, 4 );
/**
 * Search for 'Spectator' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.2.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_spectator
 *
 * @return string For 'Spectator' user role
 */
function ddw_bbpsswap_display_user_role_spectator_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	$bbpsswap_user_display_spectator = get_option( 'ddw_bbpress_user_display_spectator' );

	/** Display 'Spectator' user role */
	if ( ( function_exists( 'bbp_get_spectator_role' ) && bbp_get_spectator_role() ) && $text == 'Spectator' ) {

		if ( empty( $bbpsswap_user_display_spectator ) ) {

			return $translations->translate( 'Spectator' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_spectator ) );

	}  // end-if spectator check

	return apply_filters( 'bbpsswap_filter_user_role_spectator_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_spectator_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_visitor_gettext', 10, 4 );
/**
 * Search for 'Visitor' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.2.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_visitor
 *
 * @return string For 'Visitor' user role
 */
function ddw_bbpsswap_display_user_role_visitor_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	$bbpsswap_user_display_visitor = get_option( 'ddw_bbpress_user_display_visitor' );

	/** Display 'Visitor' user role */
	if ( ( function_exists( 'bbp_get_visitor_role' ) && bbp_get_visitor_role() ) && $text == 'Visitor' ) {

		if ( empty( $bbpsswap_user_display_visitor ) ) {

			return $translations->translate( 'Visitor' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_visitor ) );

	}  // end-if visitor check

	return apply_filters( 'bbpsswap_filter_user_role_visitor_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_visitor_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_blocked_gettext', 10, 4 );
/**
 * Search for 'Blocked' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.2.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_blocked
 *
 * @return string For 'Blocked' user role
 */
function ddw_bbpsswap_display_user_role_blocked_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	$bbpsswap_user_display_blocked = get_option( 'ddw_bbpress_user_display_blocked' );

	/** Display 'Blocked' user role */
	if ( ( function_exists( 'bbp_get_blocked_role' ) && bbp_get_blocked_role() ) && $text == 'Blocked' ) {

		if ( empty( $bbpsswap_user_display_blocked ) ) {

			return $translations->translate( 'Blocked' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_blocked ) );

	}  // end-if blocked check

	return apply_filters( 'bbpsswap_filter_user_role_blocked_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_blocked_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_user_role_guest_gettext', 10, 4 );
/**
 * Search for 'Guest' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_user_display_guest
 *
 * @return string For 'Guest' (Anonymous) user role
 */
function ddw_bbpsswap_display_user_role_guest_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display 'Guest' (anonymous) user role */
	if ( ( bbp_is_anonymous() || ( function_exists( 'bbp_get_anonymous_role' ) && bbp_get_anonymous_role() ) ) && $text == 'Guest' ) {

		$bbpsswap_user_display_guest = get_option( 'ddw_bbpress_user_display_guest' );

		if ( empty( $bbpsswap_user_display_guest ) ) {

			return $translations->translate( 'Guest' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_user_display_guest ) );

	}  // end-if guest check

	return apply_filters( 'bbpsswap_filter_user_role_guest_display', $translation );

}  // end of function ddw_bbpsswap_display_user_role_guest_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_posts_gettext', 10, 4 );
/**
 * Search for 'Posts' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_posts_display
 *
 * @return string For 'Posts' string
 */
function ddw_bbpsswap_display_posts_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display Posts string */
	if ( is_bbpress() && $text == 'Posts' ) {

		$bbpsswap_posts_display = get_option( 'ddw_bbpress_display_posts' );

		if ( empty( $bbpsswap_posts_display ) ) {

			return $translations->translate( 'Posts' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_posts_display ) );

	}  // end-if posts check

	return apply_filters( 'bbpsswap_filter_posts_display', $translation );

}  // end of function ddw_bbpsswap_display_posts_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_startedby_gettext', 10, 4 );
/**
 * Search for 'Started by: %1$s' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_startedby_display
 *
 * @return string For 'Started by: %1$s' string
 */
function ddw_bbpsswap_display_startedby_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display Posts string */
	if ( is_bbpress() && $text == 'Started by: %1$s' ) {

		$bbpsswap_startedby_display = get_option( 'ddw_bbpress_display_startedby' );

		if ( empty( $bbpsswap_startedby_display ) ) {

			return $translations->translate( 'Started by: %1$s' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_startedby_display ) );

	}  // end-if posts check

	return apply_filters( 'bbpsswap_filter_startedby_display', $translation );

}  // end of function ddw_bbpsswap_display_startedby_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_freshness_gettext', 10, 4 );
/**
 * Search for 'Freshness' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_freshness_display
 *
 * @return string For 'Freshness' string
 */
function ddw_bbpsswap_display_freshness_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display Freshness string */
	if ( is_bbpress() && $text == 'Freshness' ) {

		$bbpsswap_freshness_display = get_option( 'ddw_bbpress_display_freshness' );

		if ( empty( $bbpsswap_freshness_display ) ) {

			return $translations->translate( 'Freshness' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_freshness_display ) );

	}  // end-if freshness check

	return apply_filters( 'bbpsswap_filter_freshness_display', $translation );

}  // end of function ddw_bbpsswap_display_freshness_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_voices_gettext', 10, 4 );
/**
 * Search for 'Voices' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_voices_display
 *
 * @return string For 'Voices' string
 */
function ddw_bbpsswap_display_voices_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display Voices string */
	if ( is_bbpress() && $text == 'Voices' ) {

		$bbpsswap_voices_display = get_option( 'ddw_bbpress_display_voices' );

		if ( empty( $bbpsswap_voices_display ) ) {

			return $translations->translate( 'Voices' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_voices_display ) );

	}  // end-if voices check

	return apply_filters( 'bbpsswap_filter_voices_display', $translation );

}  // end of function ddw_bbpsswap_display_voices_gettext


add_filter( 'gettext', 'ddw_bbpsswap_display_submit_gettext', 10, 4 );
/**
 * Search for 'Submit' Gettext string and add changed text.
 *
 * Provides fallback to default value if option is empty.
 *
 * @since  1.0.0
 *
 * @param  string $translation
 * @param  string $text
 * @param  string $domain
 * @param  string $translations
 * @param  string $bbpsswap_submit_display
 *
 * @return string For 'Submit' string
 */
function ddw_bbpsswap_display_submit_gettext( $translation, $text, $domain ) {

	$translations = &get_translations_for_domain( 'bbpress' );

	/** Display Submit string */
	if ( is_bbpress() && $text == 'Submit' ) {

		$bbpsswap_submit_display = get_option( 'ddw_bbpress_display_submit' );

		if ( empty( $bbpsswap_submit_display ) ) {

			return $translations->translate( 'Submit' );

		}  // end-if

		return $translations->translate( esc_html( $bbpsswap_submit_display ) );

	}  // end-if submit check

	return apply_filters( 'bbpsswap_filter_submit_display', $translation );

}  // end of function ddw_bbpsswap_display_submit_gettext


/**
 * Display the Topic Pagination Prev String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_topic_pagination_prev
 *
 * @return string
 */
function ddw_bbpsswap_display_topic_pagination_prev( $bbpsswap_topic_pagination_prev ) {

	/** Get our option */
	$bbpsswap_topic_pagination_prev['prev_text'] = get_option( 'ddw_bbpress_topic_pagination_prev_text' );

	/** Check for empty string */
	if ( empty( $bbpsswap_topic_pagination_prev['prev_text'] ) ) {

		$bbpsswap_topic_pagination_prev['prev_text'] = esc_attr__( '&larr;', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_topic_pagination_prev', $bbpsswap_topic_pagination_prev );

}  // end of function ddw_bbpsswap_display_topic_pagination_prev


/**
 * Display the Topic Pagination Next String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_topic_pagination_next
 *
 * @return string
 */
function ddw_bbpsswap_display_topic_pagination_next( $bbpsswap_topic_pagination_next ) {

	/** Get our option */
	$bbpsswap_topic_pagination_next['next_text'] = get_option( 'ddw_bbpress_topic_pagination_next_text' );

	/** Check for empty string */
	if ( empty( $bbpsswap_topic_pagination_next['next_text'] ) ) {

		$bbpsswap_topic_pagination_next['next_text'] = esc_attr__( '&rarr;', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_topic_pagination_next', $bbpsswap_topic_pagination_next );

}  // end of function ddw_bbpsswap_display_topic_pagination_next


/**
 * Display the Reply Pagination Prev String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_reply_pagination_prev
 *
 * @return string
 */
function ddw_bbpsswap_display_reply_pagination_prev( $bbpsswap_reply_pagination_prev ) {

	/** Get our option */
	$bbpsswap_reply_pagination_prev['prev_text'] = get_option( 'ddw_bbpress_reply_pagination_prev_text' );

	/** Check for empty string */
	if ( empty( $bbpsswap_reply_pagination_prev['prev_text'] ) ) {

		$bbpsswap_reply_pagination_prev['prev_text'] = esc_attr__( '&larr;', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_reply_pagination_prev', $bbpsswap_reply_pagination_prev );

}  // end of function ddw_bbpsswap_display_reply_pagination_prev


/**
 * Display the Reply Pagination Next String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_reply_pagination_next
 *
 * @return string
 */
function ddw_bbpsswap_display_reply_pagination_next( $bbpsswap_reply_pagination_next ) {

	/** Get our option */
	$bbpsswap_reply_pagination_next['next_text'] = get_option( 'ddw_bbpress_reply_pagination_next_text' );

	/** Check for empty string */
	if ( empty( $bbpsswap_reply_pagination_next['next_text'] ) ) {

		$bbpsswap_reply_pagination_next['next_text'] = esc_attr__( '&rarr;', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_reply_pagination_next', $bbpsswap_reply_pagination_next );

}  // end of function ddw_bbpsswap_display_reply_pagination_next