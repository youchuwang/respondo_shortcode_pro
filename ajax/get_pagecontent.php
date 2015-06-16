<?php
	$filename = isset( $_POST['filename'] ) ? $_POST['filename'] : '';
	
	if( file_exists( "content/" . $filename . ".txt" ) ) {
		echo file_get_contents("content/" . $filename . ".txt");
	} else {
		echo file_get_contents( dirname(dirname(dirname(__FILE__))) . "/respondo-shortcode-pro-pages/content/" . $filename . ".txt");
	}
?>