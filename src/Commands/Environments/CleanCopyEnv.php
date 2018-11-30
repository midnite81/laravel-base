<?php

namespace Midnite81\LaravelBase\Commands\Environments;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class CleanCopyEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:copy {--fileName=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a blank copy of the live env';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    protected $copyName = '.env.blank';

    /**
     * Create a new command instance.
     *
     * @param Application $application
     * @param Filesystem  $filesystem
     */
    public function __construct(Application $application, Filesystem $filesystem)
    {
        parent::__construct();
        $this->app = $application;
        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if ($file = $this->option('fileName')) {
            $this->copyName = $file;
        }

        $envFilePath = $this->app->environmentFilePath();

        if ($this->files->exists($envFilePath)) {
            $env = $this->files->get($envFilePath);
            $saveLocation = $this->app->environmentPath() . DIRECTORY_SEPARATOR . $this->copyName;

            $freshCopy = preg_replace('/=.*?[\n$]/', "=\n", $env);

            $this->files->put($saveLocation, $freshCopy);
            $this->info('Blank env stored at: ' . $saveLocation);
        } else {
            $this->warn('Cannot find the env file: ' . $this->app->environmentFilePath());
        }
    }
}
