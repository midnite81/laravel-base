<?php

namespace Midnite81\LaravelBase\Commands\Users;

use Illuminate\Console\Command;

class EditUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm81:users:edit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit a user';

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
        //
    }
}
