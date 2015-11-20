<?php
add_action( 'admin_init', 'tgm_settings_init' );
add_action( 'admin_menu', 'tgm_add_admin_menu' );

function tgm_add_admin_menu(  ) { 

	add_options_page( 'Twitter Google Maps', 'Twitter Google Maps', 'manage_options', 'twitter_google_maps', 'tgm_options_page' );

}


function tgm_settings_init(  ) { 

	register_setting( 'pluginPage', 'tgm_settings' );

	add_settings_section(
		'tgm_pluginPage_section', 
		__( '', 'wordpress' ), 
		'tgm_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'apikey', 
		__( 'Consumer Key (API Key)', 'wordpress' ), 
		'apikey_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'tsecapi', 
		__( 'Consumer Secret (API Secret)', 'wordpress' ), 
		'secapi_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'accestok', 
		__( 'Access Token', 'wordpress' ), 
		'accestok_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'accesstoksec', 
		__( 'Access Token Secret', 'wordpress' ), 
		'accesstoksec_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'usname', 
		__( 'Username', 'wordpress' ), 
		'usname_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'usid', 
		__( 'User Id', 'wordpress' ), 
		'usid_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'hashtaglookup', 
		__( 'Hash Tag Google Map Look Up', 'wordpress' ), 
		'hash_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'mapmarker', 
		__( 'Map Marker URL', 'wordpress' ), 
		'mapmarker_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'amount', 
		__( 'How Many Tweets Should Be Shown In The Twitter Stream?', 'wordpress' ), 
		'amount_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'rLONG', 
		__( 'Defualt Longitude', 'wordpress' ), 
		'restingLONG_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'rLAT', 
		__( 'Defualt Latitude', 'wordpress' ), 
		'restingLAT_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);
	add_settings_field( 
		'rMark', 
		__( 'Defualt Mapmarker', 'wordpress' ), 
		'restingMark_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);

	add_settings_field( 
		'styles', 
		__( 'Google Map Style', 'wordpress' ), 
		'styles_render', 
		'pluginPage', 
		'tgm_pluginPage_section' 
	);


}
function restingLAT_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[rLAT]' value='<?php if(isset( $options['rLAT'])){ echo $options['rLAT'];}else{ echo "";} ?>'>
	<?php

}
function restingLONG_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[rLONG]' value='<?php if(isset( $options['rLONG'])){ echo $options['rLONG'];}else{ echo "";} ?>'>
	<?php

}

function restingMark_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[rMark]' value='<?php if(isset( $options['rMark'])){ echo $options['rMark'];}else{ echo "";} ?>'>
	<?php

}

function amount_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[amount]' value='<?php if(isset( $options['amount'])){ echo $options['amount'];}else{ echo "5";} ?>'>
	<?php

}

function mapmarker_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[mapmarker]' value='<?php if(isset( $options['mapmarker'] )){  echo $options['mapmarker'];  } else{ echo "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png"; } ?>'>
	<?php

}


function hash_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[hashtaglookup]' value='<?php echo $options['hashtaglookup']; ?>'>
	<?php

}

function apikey_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[apikey]' value='<?php echo $options['apikey']; ?>'>
	<?php

}

function styles_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<textarea rows="10" cols="50" name='tgm_settings[styles]'><?php echo $options['styles']; ?></textarea>
	<?php

}




function secapi_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[secapi]' value='<?php echo $options['secapi']; ?>'>
	<?php

}


function accestok_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[accestok]' value='<?php echo $options['accestok']; ?>'>
	<?php

}


function accesstoksec_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[accesstoksec]' value='<?php echo $options['accesstoksec']; ?>'>
	<?php

}


function usname_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[usname]' value='<?php echo $options['usname']; ?>'>
	<?php

}

function usid_render(  ) { 

	$options = get_option( 'tgm_settings' );
	?>
	<input required type='text' name='tgm_settings[usid]' value='<?php echo $options['usid']; ?>'>
	<?php

}


function tgm_settings_section_callback(  ) { 

	echo __( '<h2>Information</h2>
		<ul>
			<li>
				Go to <a href="https://dev.twitter.com/" target="_blank">dev.twitter.com</a> to set up your app, and go to the Manage Your Apps link. If you need a style for your map, check out <a href="https://snazzymaps.com/" target="_blank">Snazzy Maps</a>.
			</li>
			<li>
				Don\'t have a map marker, check out <a href="https://mapicons.mapsmarker.com/" target="_blank">https://mapicons.mapsmarker.com/</a>.
			</li>
			<li>
				If you want a tweet to show up in the map, you have to turn on the <strong>geolocation</strong> and use the hashtag you assigned in "Hash Tag Google Map Look Up." For more information check out <a href="https://support.twitter.com/articles/122236-adding-your-location-to-a-tweet" target="_blank">https://support.twitter.com/articles/122236-adding-your-location-to-a-tweet</a>
			</li>
			<li>
				If you are not sure how long in between locations, then I highly suggest in putting a defualt Long, Lat, and Map Marker. This way the map will always load, and the defualt map marker does have to be a marker. It could just be an image that says, "Check Back Later."
			</li>
			<li>
				After a week your tweet will not show up in the API. If you would like to see more on Twitter\'s limitations then check out <a href="https://dev.twitter.com/rest/public/search" target="_blank">The Search API</a>.
			</li>
			<li>
				The Twitter Feed caches every 30mins in order to save on the amount of calls you are allowed in a given time.
			</li>
		</ul>
		<h2>Settings</h2>		

			', 'wordpress' );

}


function tgm_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
	<h1>Twitter Google Map Plugin Settings</h1>

		
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
		
	</form>
	<?php

}

?>