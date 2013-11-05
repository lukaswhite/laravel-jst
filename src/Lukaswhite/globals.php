<?php

if ( ! function_exists('jst'))
{
	/**
	 * Generates the necessary HTML for a
	 * link to the JST file.
	 *
	 * @param  string $path
	 * @return string
	 */
	function jst($path = 'styles.min.css')
	{
		$publicDirName = basename(public_path());

		$path = \Config::get('guard-laravel::guard.css_path') . "/$path";
		$path = str_replace($publicDirName, '', $path);

		return "<link rel='stylesheet' href='{$path}'>";
	}
}
