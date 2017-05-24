<?php
/**
 * Created by PhpStorm.
 * User: wikid
 * Date: 23.05.2017
 * Time: 20:50
 */
require_once '../vendor/autoload.php';
set_time_limit( 30000 );
$generator = new \Controller\Generator();

if ( php_sapi_name() == 'cli' ) {
	$shortopts = "";

	$longopts = array(
		"numberOfCodes:",     // Required value
		"lenghtOfCode:",     // Required value
		"file:",     // Required value
		"percentage_of_fill::",    // Optional value
		"custom_characters::",    // Optional value
		"help"
	);
	$options  = getopt( $shortopts, $longopts );

	if ( isset( $options['help'] ) ) {
		print_r( "Opcje które można zastosować to:
		--numberOfCodes liczba
		--lenghtOfCode liczba
		--file ścieżka
		--percentage_of_fill=\"liczba <1-99>\"
		--custom_characters\"ciąg znaków\"
		--help" );

		return 0;
	}

	if ( isset( $options['numberOfCodes'] ) && is_numeric( $options['numberOfCodes'] ) && $options['numberOfCodes'] !== '' ) {
		$how_many = (int) $options['numberOfCodes'];
	} else {
		var_dump( 'Brak sprecyzowanej ilości kodów lub podany ciąg nie jest w formacie numerycznym' );

		return - 1;
	}
	if ( isset( $options['lenghtOfCode'] ) && is_numeric( $options['lenghtOfCode'] ) && $options['lenghtOfCode'] !== '' ) {
		$length = (int) $options['lenghtOfCode'];
	} else {
		var_dump( 'Brak sprecyzowanej długości kodu lub podany ciąg nie jest w formacie numerycznym' );

		return - 1;
	}
	if ( isset( $options['percentage_of_fill'] ) && $options['percentage_of_fill'] !== '' ) {
		if ( is_numeric( $options['percentage_of_fill'] ) && ( (int) $options['percentage_of_fill'] ) >= 1 && ( (int) $options['percentage_of_fill'] ) <= 99 ) {
			$percentage_of_fill = (int) $options['percentage_of_fill'];
		} else {
			var_dump( 'Podany procent wypełnienia nie jest w formacie numerycznym' );

			return - 1;
		}
	} else {
		$percentage_of_fill = 70;
	}

	if ( isset( $options['custom_characters'] ) && $options['custom_characters'] !== '' ) {
		$custom_characters = $options['custom_characters'];
	} else {
		$custom_characters = null;
	}

	if ( isset( $options['file'] ) ) {
		$file_path = $options['file'];
	} else {
		$file_path = null;
	}
	$result = $generator->download_generated_discount_codes( $how_many, $length, $percentage_of_fill, $custom_characters, $file_path );
	if ( ! is_array( $result ) ) {
		print_r( $result );
	}
}
