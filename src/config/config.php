<?php
/**
 * JST Configuration file
 */
return array(
	/**
	 * The source directory - this is where you place your template files.  Note that it's relative to the application directory.
	 */
	'source_dir' 				=>	'/public/app/templates',

	'source_prefix'			=>	'app/templates',

	/**
	 * The destination directory; where to save the resultant JS file to.
	 */
	'dest_dir'					=>	'/public/app/',

	/**
	 * The filename for the compiled JST file.
	 */
	'output_filename'		=>	'jst.js',

	/**
	 * Whether to watch the filesystem for changes, and compile on demand. Useful in development.
	 */
	'watch'							=>	TRUE,
);