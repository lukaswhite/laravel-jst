<?php namespace Lukaswhite\Jst;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class JstGenerateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'jst:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a JST fire';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		//$this->error('test');
		try {
			JstGenerator::run();
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

}