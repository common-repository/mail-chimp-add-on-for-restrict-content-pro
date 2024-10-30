<?php
/**
 * Plugin Name: Restrict Content Pro - MailChimp
 * Plugin URL: https://restrictcontentpro.com/downloads/mailchimp/
 * Description: Include a MailChimp signup option with your Restrict Content Pro registration form
 * Version: 1.3.4
 * Author: Sandhills Development, LLC
 * Author URI: https://sandhillsdev.com
 * Contributors: Pippin Williamson, nosegraze, mindctrl
 * Text Domain: restrict-content-pro-mailchimp
 */

/**
 * Create settings page
 *
 * @since  1.0
 * @return void
 */
function rcp_mailchimp_settings_menu() {
	add_submenu_page( 'rcp-members', __( 'Restrict Content Pro MailChimp Settings', 'restrict-content-pro-mailchimp' ), __( 'MailChimp', 'restrict-content-pro-mailchimp' ), 'manage_options', 'rcp-mailchimp', 'rcp_mailchimp_settings_page' );
}
add_action( 'admin_menu', 'rcp_mailchimp_settings_menu', 100 );

/**
 * Register plugin settings
 *
 * @since  1.0
 * @return void
 */
function rcp_mailchimp_register_settings() {
	register_setting( 'rcp_mailchimp_settings_group', 'rcp_mailchimp_settings' );
}
add_action( 'admin_init', 'rcp_mailchimp_register_settings', 100 );

/**
 * Show notice for Pro version on the MailChimp settings page
 *
 * @since 1.3.1
 * @return void
 */
function rcp_mailchimp_pro_upgrade_notice() {

	$current_page = get_current_screen();

	// Only show the notice on the MailChimp settings page.
	if ( 'restrict_page_rcp-mailchimp' != $current_page->id ) {
		return;
	}

	?>
	<div class="notice notice-info">
		<p><?php printf( __( 'Note: a dramatically improved <a href="%s">Pro version</a> of this plugin is available. The pro version includes level-specific subscriptions, eCommerce tracking, automatic subscriptions, status tracking, and more.', 'restrict-content-pro-mailchimp' ), 'https://restrictcontentpro.com/downloads/mailchimp-pro/' ); ?></p>
	</div>
	<?php

}
add_action( 'admin_notices', 'rcp_mailchimp_pro_upgrade_notice' );

/**
 * Render settings page
 *
 * @since  1.0
 * @return void
 */
function rcp_mailchimp_settings_page() {

	$rcp_mc_options = get_option( 'rcp_mailchimp_settings' );
	$saved_list     = isset( $rcp_mc_options['mailchimp_list'] ) ? $rcp_mc_options['mailchimp_list'] : false;

	if ( empty( $rcp_mc_options['default_checkbox_state'] ) ) {
		$rcp_mc_options['default_checkbox_state'] = 'checked';
	}

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<?php
		if ( ! isset( $_REQUEST['updated'] ) )
			$_REQUEST['updated'] = false;
		?>
		<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'restrict-content-pro-mailchimp' ); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php" class="rcp_options_form">

			<?php settings_fields( 'rcp_mailchimp_settings_group' ); ?>
			<?php $lists = rcp_get_mailchimp_lists(); ?>

			<table class="form-table">

				<tr>
					<th>
						<label for="rcp_mailchimp_settings[mailchimp_api]"><?php _e( 'MailChimp API Key', 'restrict-content-pro-mailchimp' ); ?></label>
					</th>
					<td>
						<input class="regular-text" type="text" id="rcp_mailchimp_settings[mailchimp_api]" name="rcp_mailchimp_settings[mailchimp_api]" value="<?php echo isset( $rcp_mc_options['mailchimp_api'] ) ? esc_attr( $rcp_mc_options['mailchimp_api'] ) : ''; ?>"/>
						<div class="description"><?php _e( 'Enter your MailChimp API key to enable a newsletter signup option with the registration form.', 'restrict-content-pro-mailchimp' ); ?></div>
					</td>
				</tr>
				<tr>
					<th>
						<label for="rcp_mailchimp_settings[mailchimp_list]"><?php _e( 'Newsletter List', 'restrict-content-pro-mailchimp' ); ?></label>
					</th>
					<td>
						<select id="rcp_mailchimp_settings[mailchimp_list]" name="rcp_mailchimp_settings[mailchimp_list]">
							<?php
							if ( is_array( $lists ) && ! empty( $lists ) ) :
								foreach ( $lists as $list ) :
									echo '<option value="' . esc_attr( $list['id'] ) . '"' . selected( $saved_list, $list['id'], false ) . '>' . esc_html( $list['name'] ) . '</option>';
								endforeach;
							else :
								?>
								<option value="no list"><?php _e( 'no lists', 'restrict-content-pro-mailchimp' ); ?></option>
							<?php endif; ?>
						</select>
						<div class="description"><?php _e( 'Choose the list to subscribe users to', 'restrict-content-pro-mailchimp' ); ?></div>
					</td>
				</tr>
				<tr>
					<th>
						<label for="rcp_mailchimp_settings[signup_label]"><?php _e( 'Form Label', 'restrict-content-pro-mailchimp' ); ?></label>
					</th>
					<td>
						<input class="regular-text" type="text" id="rcp_mailchimp_settings[signup_label]" name="rcp_mailchimp_settings[signup_label]" value="<?php echo isset( $rcp_mc_options['signup_label'] ) ? esc_attr( $rcp_mc_options['signup_label'] ) : ''; ?>"/>
						<div class="description"><?php _e( 'Enter the label to be shown on the "Sign up for Newsletter" checkbox', 'restrict-content-pro-mailchimp' ); ?></div>
					</td>
				</tr>
				<tr>
					<th>
						<label for="rcp_mailchimp_settings[default_checkbox_state]"><?php _e( 'Opt-In Checkbox Default State', 'restrict-content-pro-mailchimp' ); ?></label>
					</th>
					<td>
						<select id="rcp_mailchimp_settings[default_checkbox_state]" name="rcp_mailchimp_settings[default_checkbox_state]">
							<option value="checked" <?php selected( $rcp_mc_options['default_checkbox_state'], 'checked' ); ?>><?php _e( 'Checked', 'restrict-content-pro-mailchimp' ); ?></option>
							<option value="unchecked" <?php selected( $rcp_mc_options['default_checkbox_state'], 'unchecked' ); ?>><?php _e( 'Unchecked', 'restrict-content-pro-mailchimp' ); ?></option>
						</select>
						<div class="description"><?php _e( 'Choose whether you want the opt-in on the registration form checked or unchecked by default.', 'restrict-content-pro-mailchimp' ); ?></div>
					</td>
				</tr>
			</table>
			<!-- save the options -->
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Options', 'restrict-content-pro-mailchimp' ); ?>" />
			</p>

		</form>
	</div><!--end .wrap-->
	<?php
}

/**
 * Get an array of all MailChimp subscription lists
 *
 * @since  1.0
 * @return array|bool
 */
function rcp_get_mailchimp_lists() {

	$rcp_mc_options = get_option( 'rcp_mailchimp_settings' );

	if ( ! empty( $rcp_mc_options['mailchimp_api'] ) ) {

		$api_key = trim( $rcp_mc_options['mailchimp_api'] );

		$data_center = explode( '-', $api_key );
		$data_center = $data_center[1];

		$request_url = 'https://' . urlencode( $data_center ) . '.api.mailchimp.com/3.0/lists/?count=150';

		$args = array(
			'headers' => array(
				'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key )
			)
		);

		$response = wp_remote_get( $request_url, $args );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
			if ( function_exists( 'rcp_log' ) ) {
				$response_code = is_wp_error( $response ) ? 'Unknown' : wp_remote_retrieve_response_code( $response );
				$response      = is_wp_error( $response ) ? $response->get_error_message() : wp_remote_retrieve_body( $response );
				rcp_log( sprintf( 'MailChimp: Failed to retrieve list data. Response code: %s. Response: %s.', $response_code, $response ) );
			}

			return false;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $data['lists'] ) || ! is_array( $data['lists'] ) ) {
			if ( function_exists( 'rcp_log' ) ) {
				rcp_log( sprintf( 'MailChimp: No lists found. Response code: %d. Response: %s.', wp_remote_retrieve_response_code( $response ), wp_remote_retrieve_body( $response ) ) );
			}

			return false;
		}

		$lists = array();

		foreach ( $data['lists'] as $list_info ) {
			$lists[] = array(
				'id'   => $list_info['id'],
				'name' => $list_info['name']
			);
		}

		return $lists;
	}

	if ( function_exists( 'rcp_log' ) ) {
		rcp_log( 'MailChimp: Failed to retrieve list data. Missing API key.' );
	}

	return false;
}

/**
 * Adds an email to the MailChimp subscription list
 *
 * @param string $email Email address to subscribe.
 * @param array  $args  {
 *     Array of optional arguments.
 *     @type string first_name Optional. User's first name.
 *     @type string last_name  Optional. User's last name.
 * }
 *
 * @since  1.0
 * @return bool
 */
function rcp_subscribe_email( $email = '', $args = array() ) {

	$default_args = array(
		'first_name' => '',
		'last_name'  => ''
	);

	$args = wp_parse_args( $args, $default_args );

	$rcp_mc_options = get_option( 'rcp_mailchimp_settings' );

	// Bail if API key isn't set.
	if ( empty( $rcp_mc_options['mailchimp_api'] ) ) {
		if ( function_exists( 'rcp_log' ) ) {
			rcp_log( 'MailChimp: Failed to subscribe user. Missing API key.' );
		}

		return false;
	}

	$api_key = trim( $rcp_mc_options['mailchimp_api'] );
	$list_id = trim( $rcp_mc_options['mailchimp_list'] );

	$data_center = explode( '-', $api_key );
	$data_center = $data_center[1];

	$request_url = 'https://' . urlencode( $data_center ) . '.api.mailchimp.com/3.0/lists/' . urlencode( $list_id ) . '/members';

	/**
	 * Allows merge vars to be filtered.
	 *
	 * @param array  $merge_vars Default merge vars.
	 * @param string $email      Email address being subscribed.
	 * @param string $list_id    ID of the list the user is being subscribed to.
	 */
	$merge_vars = apply_filters( 'rcp_mailchimp_merge_vars', array(
		'FNAME' => sanitize_text_field( $args['first_name'] ),
		'LNAME' => sanitize_text_field( $args['last_name'] )
	), $email, $list_id );

	/**
	 * Allows the API request arguments to be filtered.
	 *
	 * @param array  $request_body Default request args.
	 * @param string $list_id      ID of the list the user is being subscribed to.
	 *
	 * @since 1.3
	 */
	$request_body = apply_filters( 'rcp_mailchimp_subscribe_args', array(
		'email_address' => sanitize_email( $email ),
		'status'        => 'pending',
		'merge_fields'  => $merge_vars
	), $list_id );

	// Request arguments.
	$args = array(
		'headers' => array(
			'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key )
		),
		'body'    => json_encode( $request_body )
	);

	$response = wp_remote_post( $request_url, $args );

	if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
		if ( function_exists( 'rcp_log' ) ) {
			$response_code = is_wp_error( $response ) ? 'Unknown' : wp_remote_retrieve_response_code( $response );
			$response      = is_wp_error( $response ) ? $response->get_error_message() : wp_remote_retrieve_body( $response );
			rcp_log( sprintf( 'MailChimp: Failed adding user to list %s. Response code: %d. Response: %s.', $list_id, $response_code, $response ) );
		}

		return false;
	}

	if ( function_exists( 'rcp_log' ) ) {
		rcp_log( sprintf( 'MailChimp: Successfully added user to list %s.', $list_id ) );
	}

	return true;
}

/**
 * Display the MailChimp signup checkbox on the registration form
 *
 * @since  1.0
 * @return void
 */
function rcp_mailchimp_fields() {
	$rcp_mc_options = get_option('rcp_mailchimp_settings');
	$checked        = empty( $rcp_mc_options['default_checkbox_state'] ) || 'checked' == $rcp_mc_options['default_checkbox_state'];
	ob_start();
	if ( ! empty( $rcp_mc_options['mailchimp_api'] ) ) { ?>
		<p>
			<input name="rcp_mailchimp_signup" id="rcp_mailchimp_signup" type="checkbox" <?php checked( $checked ); ?>/>
			<label for="rcp_mailchimp_signup"><?php echo isset( $rcp_mc_options['signup_label'] ) ? $rcp_mc_options['signup_label'] : __( 'Sign up for our newsletter', 'restrict-content-pro-mailchimp' ); ?></label>
		</p>
		<?php
	}
	echo ob_get_clean();
}
add_action( 'rcp_before_registration_submit_field', 'rcp_mailchimp_fields', 100 );

/**
 * Checks whether a user should be signed up for the MailChimp list
 *
 * @param array $posted  Array of data submitted through the form.
 * @param int   $user_id ID of the user.
 *
 * @since  1.0
 * @return void
 */
function rcp_mailchimp_check_for_email_signup( $posted, $user_id ) {
	if ( isset( $posted['rcp_mailchimp_signup'] ) ) {
		// Set a flag so we know to add them to the list after account activation.
		update_user_meta( $user_id, 'rcp_pending_mailchimp_signup', true );
	}
}
add_action( 'rcp_form_processing', 'rcp_mailchimp_check_for_email_signup', 10, 2 );

/**
 * Add member to the MailChimp list when their account is activated
 *
 * @param string     $status     New status.
 * @param int        $user_id    ID of the user.
 * @param string     $old_status Previous status.
 * @param RCP_Member $member     Member object.
 *
 * @since  1.3
 * @return void
 */
function rcp_mailchimp_add_to_list( $status, $user_id, $old_status, $member ) {

	if ( ! in_array( $status, array( 'active', 'free' ) ) ) {
		return;
	}

	if ( ! get_user_meta( $user_id, 'rcp_pending_mailchimp_signup', true ) ) {
		if ( function_exists( 'rcp_log' ) ) {
			rcp_log( sprintf( 'MailChimp: Not adding user #%d to list - missing rcp_pending_mailchimp_signup user meta.', $user_id ) );
		}

		return;
	}

	$args = array(
		'first_name' => $member->first_name,
		'last_name'  => $member->last_name
	);

	$subscribed = rcp_subscribe_email( $member->user_email, $args );

	if ( $subscribed ) {
		update_user_meta( $user_id, 'rcp_subscribed_to_mailchimp', 'yes' );
		delete_user_meta( $user_id, 'rcp_pending_mailchimp_signup' );
	}

}
add_action( 'rcp_set_status', 'rcp_mailchimp_add_to_list', 10, 4 );

/**
 * Display note on Edit Customer page indicating if the user signed up for the mailing list
 *
 * @param int $user_id
 *
 * @since  1.2
 * @return void
 */
function rcp_add_mc_signup_notice( $user_id ) {
	$signed_up = get_user_meta( $user_id, 'rcp_subscribed_to_mailchimp', true );
	?>
	<tr>
		<th scope="row" class="row-title">
			<label for="tablecell"><?php _e( 'MailChimp:', 'restrict-content-pro-mailchimp' ); ?></label>
		</th>
		<td>
			<?php echo $signed_up ? __( 'Yes', 'restrict-content-pro-mailchimp' ) : __( 'No', 'restrict-content-pro-mailchimp' ); ?>
		</td>
	</tr>
	<?php
}
add_action('rcp_edit_member_after', 'rcp_add_mc_signup_notice');

/**
 * Load plugin text domain for translations
 *
 * @since 1.3
 * @return void
 */
function rcp_mailchimp_load_textdomain() {

	// Set filter for plugin's languages directory
	$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$lang_dir = apply_filters( 'rcp_mailchimp_languages_directory', $lang_dir );

	// Load the translations
	load_plugin_textdomain( 'restrict-content-pro-mailchimp', false, $lang_dir );

}
add_action( 'init', 'rcp_mailchimp_load_textdomain' );