<?php

/**
* Localize PHP Variables
*/
$localized_vars = array(
	'ajaxUrl' => admin_url( 'admin-ajax.php' ),
	'isAdmin' => is_admin()
	);


wp_localize_script( 'main_js', 'localizedVars', $localized_vars );

