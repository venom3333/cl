<?php
/**
 * настройки БД
 */

if ( stristr( $_SERVER ['DOCUMENT_ROOT'], 'localhost' ) ) {
	define( 'DB_USER', 'venom' );
	define( 'DB_NAME', 'custom_light' );
	define( 'DB_HOST', 'localhost' );
	define( 'DB_PASS', '666666' );
} else {
	define( 'DB_USER', 'customligh_venom' );
	define( 'DB_NAME', 'customligh_db' );
	define( 'DB_HOST', 'customligh.mysql' );
	define( 'DB_PASS', '9/MBHXML' );
}
