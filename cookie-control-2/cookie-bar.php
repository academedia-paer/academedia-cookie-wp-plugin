<?php

	//switch to main blog
	switch_to_blog(1);

	$bg_colors = get_option( 'background_color');
	$text_color = get_option('text_color');
	$button_bg = get_option('button_bg_color');
	$content = get_option('content');
	$dismiss = get_option('dismiss');
	$link_text = get_option('link_text');
	$link = get_option('link');
	$compliance = get_option('compliance') ?: 'info';
	
	$jsonData = [
		'palette' => [
			'popup' => [
				'background' => $bg_colors,
				'text' => $text_color
			],
			'button' => [
				'background' => $button_bg
			]
		],
		'content' => [
			'message' => $content,
			'allow' => get_option('allow'),
			'deny' => get_option('deny', 'Decline'),
			'dismiss' => $dismiss,
			'link' => $link_text,
			'href' => $link
		],
		'revokable' => false,
		'position' => get_option('position'),
		'type' => $compliance
	];

	$whiteList = get_option('whitelist', '');
	$whiteList = explode("\n", $whiteList);
	$whiteList = array_map('trim', $whiteList);
	$whiteList = array_filter($whiteList);

	$whiteList[] = parse_url(home_url(), PHP_URL_HOST);

	$whiteList = array_map(function ($domain) {
		$domain = str_replace('.', '\\.', $domain);
		return sprintf('/%s/', $domain);
	}, $whiteList);

	$whiteList = implode(', ', $whiteList);

	//switch back to current blog
	restore_current_blog();

if ( $compliance != 'info' ): ?>
<script>
	window.YETT_BLACKLIST = [
		/.*/
	];

	window.YETT_WHITELIST = [
		<?= $whiteList; ?>
	];
</script>
<!-- <script src="https://unpkg.com/yett"></script> -->
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?= plugins_url('css/cookieconsent.min.css', __FILE__); ?>" />
<script src="<?= plugins_url('js/cookieconsent.min.js', __FILE__); ?>"></script>

<script>

	var data = <?= json_encode($jsonData); ?>;

	function unblockCookies()
	{
		if (window.yett && window.yett.unblock)
		{
			window.yett.unblock();
		}
	}
	

	/*
	data['onStatusChange'] = function () {
		if ( this.hasConsented() )
		{
			unblockCookies()
		}
	};

	data['onInitialise'] = function (status) {
		if (this.hasConsented())
		{
			unblockCookies()
		}
	}

	data['onPopupOpen'] = function () {
		if ( this.options.type == 'opt-out')
		{
			unblockCookies()
		}
	}

	data['onRevokeChoice'] = function () {
		if ( this.hasConsented() )
		{
			unblockCookies();
		}
		else
		{
			window.location.reload();
		}
	}
	*/



document.addEventListener('DOMContentLoaded', function() {
	window.cookieconsent.initialise(data);
});
</script>