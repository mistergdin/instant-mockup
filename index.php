<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Instant Mockup</title>

	<meta name="viewport" content="width=device-width">

	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
		}

		body {
			text-align: center;
		}
	</style>
</head>
<body>
	<?php
		/**
		* Scan current directory and prepare
		* array to hold list of files.
		*/
		$filesInCurrentFolder = scandir('.');
		$filteredFiles = array();

		/**
		* Go through all scaned files and see
		* if any of those files has .jpg extension
		* and that it starts with one digit, with
		* leading zero or two digits.
		* Example: 01.jpg 1.jpg 10.jpg
		*/
		foreach ($filesInCurrentFolder as $file) {
			if( preg_match( '/([0-9]|[0-9][0-9]).(?:jpg)/i', $file ) ) {
				$filteredFiles[] = $file;
			}
		}

		/**
		* Sort filtered files so this list:
		* 1, 11, 12, 2, 3
		* becomes this list:
		* * 1, 2, 3, 11, 12
		*/
		sort( $filteredFiles, SORT_NUMERIC );

		// get index of last element in filtered files array
		$indexOfLastFilteredFile = key(array_slice($filteredFiles, -1, 1, TRUE));;

		// var_dump($filteredFiles);

		/**
		* 1. Get URI
		* 2. Get last two characters
		* 3. Remove /
		*
		* TODO: Needs better solution as the following URL
		* will be considered as valid:
		* http://domain.com/XCHNG/some-random-project1/
		*/
		$uri = $_SERVER["REQUEST_URI"];
		$uri = str_replace( '/', '', substr($uri, -2) );

		/**
		* If URI matches one digit, without leading zero,
		* or two digits - continue, else show first image.
		*/
		if( preg_match( '/^([1-9]|[1-9][0-9])$/', $uri ) ) {

			// If requested URI does NOT map to empty array element
			if( $filteredFiles[$uri-1] != '' ) {

				/**
				* Check if requested file is actually last file
				* and if so link last image to first image.
				*/
				if( $indexOfLastFilteredFile == $uri-1 ) {
					echo '<a href="1"><img src="' . $filteredFiles[$uri-1] . '" alt=""></a>';
				} else {
					echo '<a href="' . ($uri + 1) . '"><img src="' . $filteredFiles[$uri-1] . '" alt=""></a>';
				}
			} else {

				// SCREAM BLOODY GORE!
				echo "<h1>OMG</h1>";

			}

		} else {

			echo '<a href="2"><img src="' . $filteredFiles[0] . '" alt=""></a>';

		}
	?>
</body>
</html>