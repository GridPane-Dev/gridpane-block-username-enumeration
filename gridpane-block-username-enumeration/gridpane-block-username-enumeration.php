<?php
if (! is_admin()) {
	// default URL format
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		if ( preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'] ) ) {
			die();
		}
		add_filter('redirect_canonical', 'check_permalink_user_enumeration', 10, 2);
	}
}

function check_permalink_user_enumeration($redirect, $request)
{
	// permalink URL format
	if ( preg_match('/\?author=([0-9]*)(\/*)/i', $request) ) {
		die();
	}
	return $redirect;
}

function disable_users_rest_if_not_logged_in()
{
	// If request is not from logged in user, then disable users rest endpoint
	if (! is_user_logged_in() )
	{
		add_filter('rest_endpoints', 'disable_users_rest_endpoints');
	}
}
add_action('init', 'disable_users_rest_if_not_logged_in');

function disable_users_rest_endpoints ( $endpoints )
{
	if ( isset( $endpoints['/wp/v2/users'] ) ) {
		unset( $endpoints['/wp/v2/users'] );
	}

	if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
		unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}

