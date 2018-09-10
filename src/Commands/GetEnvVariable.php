<?php

namespace Midnite81\LaravelBase\Commands;

use Illuminate\Console\Command;

class GetEnvVariable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:get 
                            {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a value in the .env';

    /**
     * Create a new command instance.
     *
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
    public function handle()
    {
        $this->info(env($this->argument('key')));
    }
}
