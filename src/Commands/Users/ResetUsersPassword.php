<?php

namespace Midnite81\LaravelBase\Commands\Users;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;

class ResetUsersPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm81:users:change-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change a user password';

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
        $dbColumns = $this->model->getConnection()->select('SHOW COLUMNS FROM ' . $this->model->getTable());
        $availableColumns = [];
        $askColumn = null;
        $availableComparators = ['=', '<', '>', '<=', '>=', 'LIKE', 'like'];
        $comparator = null;

        $this->info("Columns available to search user against");
        foreach ($dbColumns as $value) {
            $availableColumns[] = $value->Field;
            $this->info($value->Field);
        }

        while(! in_array($askColumn, $availableColumns)) {
            $askColumn = $this->ask('Which column do you want to search against?');
        }

        while(! in_array($comparator, $availableComparators)) {
            $comparator = $this->ask('Which sql operator do you want to use? e.g. =, LIKE etc');
        }

        $search = $this->ask('Value of Search term');

        $results = $this->model->where($askColumn, $comparator, $search)->get();

        $this->info($results->count() . ' result(s) were returned');

        dump($results->toArray());
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
