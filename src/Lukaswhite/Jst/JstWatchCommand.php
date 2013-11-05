<?php namespace Lukaswhite\Jst;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class JstWatchCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'jst:watch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Watch for template changes and re-compile JST';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{		
		try {
			JstWatcher::run();
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

}