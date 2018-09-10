<?php

namespace Midnite81\LaravelBase\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup 
                           {connection? : The connection you want to backup}
                           {directory? : The directory in the storage folder you want to save to}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backs up the database';

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

        $connectionName = ! empty($this->argument('connection')) && $this->argument('connection') != 'null'
            ? $this->argument('connection') : config('database.default');
        $connection = config('database.connections.' . $connectionName);

        if (empty($connection)) {
            $this->info('No connection details');
            return false;
        }

        if ($connection['driver'] != 'mysql') {
            return $this->notMysql();
        }

        $cmd = $this->makeCommand($connection, $connectionName);

        try {
            exec($cmd);
        } catch (\Exception $e) {
            $this->info('There was an error');
            $this->info('Message: ' . $e->getMessage());
            $this->info('Trace: ' . $e->getTraceAsString());
            return false;
        }

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

    /**
     * Make the database command
     *
     * @param $connection
     * @param $connectionName
     * @return array
     */
    protected function makeCommand($connection, $connectionName)
    {
        $cmd[] = 'mysqldump -u ' . $connection['username'];
        $cmd[] = '--password=' . $connection['password'];
        $cmd[] = $connection['database'];
        $cmd[] = ' -h ' . $connection['host'];
        if ( ! empty($connection['port'])) {
            $cmd[] = '-P ' . $connection['port'];
        }
        $cmd[] = '> ' . $this->filename($connectionName);
        return implode(' ', $cmd);
    }

    /**
     * Filename
     *
     * @param $connectionName
     * @return string
     */
    protected function filename($connectionName)
    {
        $directory = $this->argument('directory');

        if (! empty($directory) &&
            ! is_dir(storage_path($directory))
        ) {
            $dirLoop = '';
            foreach(explode('/', $directory) as $dir) {
                if (! is_dir(storage_path($dirLoop . $dir))) {
                    mkdir(storage_path($dirLoop . $dir));
                }
                $dirLoop .= $dir . DIRECTORY_SEPARATOR;
            }

        }

        $filename = str_slug($connectionName) . '-' . Carbon::now()->format('Y-m-d-H-i-s') . '.sql';

        return storage_path($directory . DIRECTORY_SEPARATOR . $filename);
    }
}
