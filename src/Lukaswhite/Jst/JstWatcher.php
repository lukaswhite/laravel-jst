<?php namespace Lukaswhite\Jst;

use Config;
use Symfony\Component\Finder\Finder;


/**
 * JST Watcher class.
 *
 * Watches the filesystem for template changes, re-compiling JST as appropriate.
 */
class JstWatcher {

	/**
	 * Run the generate process.
	 */
	public static function run()
	{
		$dir = base_path() . Config::get('jst::source_dir');

		$files = new \Illuminate\Filesystem\Filesystem;
		$tracker = new \JasonLewis\ResourceWatcher\Tracker;

		$watcher = new \JasonLewis\ResourceWatcher\ResourceWatcher($tracker, $files);

		$listener = $watcher->watch($dir);

		$listener->onModify(function($resource)
		{
		    print "{$resource->getPath()} has been modified...".PHP_EOL;
		    JstWatcher::regenerate();
		});

		$listener->onCreate(function($resource)
		{
		    echo "{$resource->getPath()} has been created...".PHP_EOL;
		    JstWatcher::regenerate();
		});

		$listener->onDelete(function($resource)
		{
		    echo "{$resource->getPath()} has been deleted...".PHP_EOL;
		    JstWatcher::regenerate();
		});

		print "Watching for JST changes...".PHP_EOL;

		$watcher->startWatch();

	}

	/**
	 * Re-generate.
	 */
	public static function regenerate()
	{		
		print "...re-generating JST".PHP_EOL;
		JstGenerator::run();
		print "...done.".PHP_EOL;
	}

	/**
	 * Notify user that something haschanged
	 */
	public static function notify($message)
	{
		// is Growl installed?
		$growlnotifyinstalled = shell_exec("command -v /usr/local/bin/growlnotify >/dev/null 2>&1 || { echo 'nogrowlnotify'; exit 1; }");

		// ..great, use that
		if ($growlnotifyinstalled) {
			//shell_exec("/usr/local/bin/growlnotify --image \"$icon\" -m \"by $artist\n\n$timestamp\" -t \"$ql$song$qr\"");
			
			$cmd[] = "growlnotify";
			$cms[] = "-n Laravel JST";
			$cmd[] = "=m '$message'";
			//$cms[] = "-I '$icon'";			
			//$cmd[] = "-t '$other'";
			$cmd[] = ";";
			
			$shell = implode(' ', $cmd);
			
			system($shell);
		} else {
			// Oh well. screen instead.
			echo $message.PHP_EOL;
		}
	
	}
}