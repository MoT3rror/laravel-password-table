<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class HashTableChecker extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'HashTable:checker';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This commands checks the user table hashs with generated hashes';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $hash = HashDB::where('hash_string', $user->password)->first();
                if ($hash) {
                    $user->cracked = 1;
                    $user->save();
                }
            }
        });
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
