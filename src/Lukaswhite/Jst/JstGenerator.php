<?php namespace Lukaswhite\Jst;

use Config;
use Symfony\Component\Finder\Finder;


/**
 * JST Generator class.
 *
 * Generates a JST file from separate template files.  Designed for use with Backbone.
 */
class JstGenerator {

	/**
	 * Run the generate process.
	 */
	public static function run()
	{
		$finder = new Finder;

		$dir = base_path() . Config::get('jst::source_dir');

		if (!file_exists($dir)) {
			throw new \Exception('The source directory does not exist. Please check your configuration.');
		}

		$jst = array();

		$files = iterator_to_array($finder->files()->in($dir), false);
		
		$template_func = '_.template';
 
		$js = '';
		$js .= "var JST = JST || {};\n";

		if (count($files)) {
			foreach ($files as $file) {
				$contents = str_replace(array("\n","'"), array('\n',"\'"), $file->getContents());
					
				$js .= sprintf("JST['%s/%s'] = %s('%s');\n", Config::get('jst::source_prefix'), $file->getRelativePathname(), $template_func, $contents);		

			}
		}

		$output_filename = base_path() . Config::get('jst::dest_dir') . '/' . Config::get('jst::output_filename');
		
		if (!file_put_contents($output_filename, $js)) {
			throw new \Exception("Could not write JST file to $output_filename. Check the permissions, perhaps?");
		}

	}

}