<?php

/** Step 2 (from text above). */
if ( is_admin() ){ // admin actions
	add_action( 'admin_menu', 'cookiecontrol_menu' );
	add_action( 'admin_init', 'register_cookiesettings' );
} else {
	// non-admin enqueues, actions, and filters
}

function register_cookiesettings() { // whitelist options
	register_setting( 'cookiesettings-group', 'background_color' );
	register_setting( 'cookiesettings-group', 'text_color' );
	register_setting( 'cookiesettings-group', 'button_bg_color' );
	register_setting( 'cookiesettings-group', 'content' );
	register_setting( 'cookiesettings-group', 'dismiss' );
	register_setting( 'cookiesettings-group', 'allow');
	register_setting( 'cookiesettings-group', 'deny');
	register_setting( 'cookiesettings-group', 'link_text' );
	register_setting( 'cookiesettings-group', 'link' );
	register_setting( 'cookiesettings-group', 'show_revoke' );
	register_setting( 'cookiesettings-group', 'position');
	register_setting( 'cookiesettings-group', 'compliance');
}

/** Step 1. */
function cookiecontrol_menu() {
	add_options_page( 'Cookie control options', 'Cookie control', 'manage_options', 'cookie-control-identifier', 'cookiecontrol_options' );
}



/** Step 3. */
function cookiecontrol_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$complianceOptions = [
		'info' => 'Info',
		'opt-in' => 'Opt in',
		'opt-out' => 'Opt out'
	];

	$enabledOptions = [
		'0' => 'No',
		'1' => 'Yes'
	];

	$positionOptions = [
		'top' => 'Top',
		'bottom' => 'Bottom'
	];

	$showRevokeOptions = [
		'1' => 'Yes',
		'0' => 'No'
	];
	?>

	<div class="wrap">
	<h1>Cookie control options</h1>
	<p>Change your settings below:</p>
	<form method="post" action="options.php">
		<?php
			settings_fields( 'cookiesettings-group');
			do_settings_sections( 'cookiesettings-group');
		?>
		<label>
			<strong>Background color:</strong><br/>
			<input type="text" name="background_color" value="<?php echo esc_attr( get_option('background_color') ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Text color:</strong><br/>
			<input type="text" name="text_color" value="<?php echo esc_attr( get_option('text_color') ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Button background color:</strong><br/>
			<input type="text" name="button_bg_color" value="<?php echo esc_attr( get_option('button_bg_color') ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Content:</strong><br/>
			<textarea name="content" style="width:400px;height:210px;resize:none;"><?php echo esc_attr( get_option('content') ); ?></textarea>
		</label>
		<br/>
		<br/>
		<label>
			<strong>Dismiss button text:</strong><br/>
			<input type="text" name="dismiss" value="<?php echo esc_attr( get_option('dismiss') ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Allow button text:</strong><br/>
			<input type="text" name="allow" value="<?php echo esc_attr( get_option('allow') ?: 'Allow cookies' ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Deny button text:</strong><br/>
			<input type="text" name="deny" value="<?php echo esc_attr( get_option('deny') ?: 'Decline' ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Link text:</strong><br/>
			<input type="text" name="link_text" value="<?php echo esc_attr( get_option('link_text') ); ?>" />
		</label>
		<br/>
		<br/>
		<label>
			<strong>Link:</strong><br/>
			<input type="url" name="link" value="<?php echo esc_attr( get_option('link') ); ?>" />
		</label>
		<br/>
		<br/>
		<label for="compliance"><strong>Compliance</strong></label><br>
		<select name="compliance" id="compliance">
			<?php
			$compliance = get_option('compliance');
			foreach ( $complianceOptions as $value => $label)
			{
				printf('<option value="%s" %s>%s</option>', $value, $compliance == $value ? 'selected' : '', $label);
			}?>
		</select>
		<br/>
		<br/>
		<label for="position"><strong>Position</strong></label><br>
		<select name="position" id="position">
			<?php
			$position = get_option('position');
			foreach ( $positionOptions as $value => $label)
			{
				printf('<option value="%s" %s>%s</option>', $value, $position == $value ? 'selected' : '', $label);
			}?>
		</select>
		<br/>
		<br/>
		<label for="show_revoke"><strong>Show revoke tab</strong></label><br>
		<select name="show_revoke" id="show_revoke">
			<?php
			$showRevoke = get_option('show_revoke', 1);
			foreach ( $showRevokeOptions as $value => $label)
			{
				printf('<option value="%s" %s>%s</option>', $value, $showRevoke == $value ? 'selected' : '', $label);
			}?>
		</select>
		<?php submit_button(); ?>
	</form>
	</div>
	<?php
}