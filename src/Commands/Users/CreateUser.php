<?php

namespace Midnite81\LaravelBase\Commands\Users;

use Illuminate\Console\Command;
use Midnite81\LaravelBase\Exceptions\ConfigNotSetUpException;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm81:users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user on the users table';

    protected $models = [];

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->models = config('laravel-base.user-models');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws ConfigNotSetUpException
     */
    public function handle()
    {
        $this->doChecks();

        $this->setModel();
    }

    protected function doChecks()
    {
        if (empty($this->models) || ! is_array($this->models)) {
            throw new ConfigNotSetUpException('The user models section in the Laravel Base config has not been set');
        }
    }

    protected function setModel()
    {
        if (count($this->models) > 1) {
            $this->info('You need to select which model you want to update');
//            foreach($this->models as $key => $value) {
//                $this->info("[$key] $value");
//            }
            $this->askWithCompletion('Which model would you like to use?', $this->models, 0);
        }
    }
}
