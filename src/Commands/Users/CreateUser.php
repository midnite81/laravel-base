<?php

namespace Midnite81\LaravelBase\Commands\Users;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Hash;
use Midnite81\LaravelBase\Exceptions\Commands\InvalidModelException;
use Midnite81\LaravelBase\Exceptions\ConfigNotSetUpException;
use Mockery\Exception;

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

    protected $model;

    /**
     * @var DatabaseManager
     */
    protected $db;

    /**
     * Create a new command instance.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct();
        $this->models = config('laravel-base.user-models');
        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws ConfigNotSetUpException
     * @throws InvalidModelException
     */
    public function handle()
    {
        $this->doChecks();

        $this->setModel();

        $this->getInformation();
    }

    protected function doChecks()
    {
        if (empty($this->models) || !is_array($this->models)) {
            throw new ConfigNotSetUpException('The user models section in the Laravel Base config has not been set');
        }
    }

    /**
     * Set the model
     *
     * @throws InvalidModelException
     */
    protected function setModel()
    {
        if (count($this->models) > 1) {
            $this->info('You need to select which model you want to update');
            foreach ($this->models as $key => $value) {
                $this->info("[$key] $value");
            }
            $askModel = $this->ask('Which model would you like to use?', array_keys($this->models)[0]);

            if (!array_key_exists($askModel, $this->models)) {
                throw new InvalidModelException('The input you gave is not valid');
                die();
            }

            $this->model = new $this->models[$askModel];
        } else {
            $this->model = new $this->models[array_keys($this->models)[0]];
        }
    }

    /**
     * Get information to create the user
     */
    protected function getInformation()
    {
        $ignoredColumns = [
            'id',
            'identifier',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
        $columns = [];

        $dbColumns = $this->model->getConnection()->select('SHOW COLUMNS FROM ' . $this->model->getTable());

        foreach ($dbColumns as $key => $value) {
            if (! in_array($value->Field, $ignoredColumns)) {
                $columns[$value->Field] = null;
            }
        }

        foreach($columns as $key => $value) {
            $ask = $this->ask('Enter value for ' . ucwords(str_replace('_', '', $key)));
            if ($ask == 'null') {
                $ask = null;
            }
            $columns[$key] = $ask;
        }

        $columns['password'] = Hash::make($columns['password']);

        $this->checkAndConfirm($columns);

        $this->persist($columns);
    }

    /**
     * Persist the user
     *
     * @param $columns
     * @throws \Exception
     */
    protected function persist($columns)
    {
        $this->db->beginTransaction();

        try {
            $createdUser = $this->model->create($columns);
        } catch (Exception $e) {
            $this->db->rollBack();
            $this->warn('Could not persist to the database: ' . $e->getMessage());
        }

        $this->db->commit();
        $this->info('User persisted');
        dump($createdUser);
    }

    /**
     * Check and confirm
     *
     * @param $columns
     * @return bool
     */
    protected function checkAndConfirm($columns)
    {
        $this->info('Please check the details below');
        dump($columns);
        $ask = $this->ask('OK to proceed? y/n');

        if (strtolower($ask) == 'y') {
            return true;
        } else {
            $this->info('Cancelled');
            die();
        }
    }
}
