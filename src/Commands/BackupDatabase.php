<?php

namespace Midnite81\LaravelBase\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backs up the default database';

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
        $default = config('database.default');
        $connection = config('database.connections.' . $default);

        if ($connection['driver'] != 'mysql') {
            return $this->notMysql();
        }

        dd($connection);
    }

    /**
     * End script if not MYSQL
     *
     * @return bool
     */
    protected function notMysql()
    {
        $this->info('Can only backup MYSQL databases');
        return false;
    }
}
