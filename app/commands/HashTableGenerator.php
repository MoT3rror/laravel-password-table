<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class HashTableGenerator extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'HashTable:generator';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generates the hash table from dictonary file.';

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
		$file = base_path() . '/dict-table/' . $this->argument('file');

        if (!file_exists($file)) {
            $this->error('File does not exist in dict_table folder');
        }

        $handle = fopen($file, 'r');
        if (!$handle) {
            $this->error('File handle could not be open.');
        }
        $count = 1;
        while (($buffer = fgets($handle, 4096)) !== false) {
            $hash = new HashDB;
            $hash->password = $buffer;
            $hash->hash_string = Hash::make($buffer);
            $hash->save();
            if (($count % 1000) == 1) {
                $this->info($count . ' hashes been created');
            }
            $count++;
        }
        fclose($handle);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('file', InputArgument::REQUIRED, 'The file to use to get from.'),
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