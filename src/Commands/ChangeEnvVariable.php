<?php

namespace Midnite81\LaravelBase\Commands;

use Illuminate\Console\Command;

class ChangeEnvVariable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set 
                            {key} 
                            {value?}
                            { --blank }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes a value in the .env';

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
        if (! $this->proceedWhenInProduction()) {
            return false;
        }

        if (empty($this->getValue()) && ! $this->option('blank')) {
            $this->warn('You cannot set a blank value unless you pass the --blank option');
            return false;
        }

        try {
            $envFile = $this->loadEnvFile();
        } catch(\Exception $e) {
            $this->warn('Something went wrong: ' . $e->getMessage());
        }


        if ($this->keyExists($this->argument('key'), $envFile)) {
            $this->warn('You are changing ' . $this->getKey() .
                ' from ' . $this->getEnvKey() . ' to ' . $this->getValue());
            $env = $this->prepareRevisedEnv($envFile);
        } else {
            $env = $this->addKeyToEnv($envFile);
        }

        try {
            $this->saveEnvFile($env);
        } catch (\Exception $e) {
            $this->warn('Something went wrong: ' . $e->getMessage());
        }

    }


    /**
     * Gets and returns the env file
     *
     * @return bool|string
     */
    protected function loadEnvFile()
    {
        $file = base_path('.env');

        return file_get_contents($file);
    }

    /**
     * Checks to see if the key exists in the passed data
     *
     * @param $argument
     * @param $envFile
     * @return int
     */
    protected function keyExists($argument, $envFile)
    {
        return preg_match("/^" . $argument . "=/mi", $envFile);
    }

    /**
     * Prepare Revised Env File
     * @param $envFile
     * @return mixed
     */
    protected function prepareRevisedEnv($envFile)
    {
        $pattern = '/^' . $this->argument('key') . '=(.*?)(\n??)$/mi';
        $replacement = $this->getKey() . '=' . $this->getValue();

        return preg_replace($pattern, $replacement, $envFile);
    }

    /**
     * Add a key to the Env
     *
     * @param $envFile
     * @return string
     */
    protected function addKeyToEnv($envFile)
    {
        $addition = "\n" . $this->getKey() . '=' . $this->getValue() . "\n";

        return $envFile . $addition;
    }

    /**
     * Saves the env file
     *
     * @param $envFile
     * @return bool|int
     */
    protected function saveEnvFile($envFile)
    {
        return file_put_contents(base_path('.env'), $envFile);
    }

    /**
     * Get the key
     *
     * @return string
     */
    protected function getKey()
    {
        return strtoupper($this->argument('key'));
    }

    /**
     * Get the value
     *
     * @return array|string
     */
    protected function getValue()
    {
        $value = $this->argument('value');

        if (preg_match("/(\s)+/si", $value)) {
            return '"' . $value . '"';
        } else {
            return $value;
        }
    }

    /**
     * Check to see if the application should proceed
     *
     * @return bool
     */
    protected function proceedWhenInProduction()
    {
        if (env('APP_ENV', 'production') == 'production') {
            $this->warn('Application is in production!');
            $proceed = $this->ask('Are you sure you want to continue? (y/n)', 'n');
            if (! empty($proceed) && $proceed == 'y' || $proceed == 'yes') {
                return true;
            } else {
                $this->info('Abandoned change');
                return false;
            }
        }
        return true;

    }

    /**
     * Get Env Key
     *
     * @return mixed|string
     */
    protected function getEnvKey()
    {
        $envKey = env($this->getKey());

        if (is_bool($envKey)) {
            return ($envKey) ? 'true' : 'false';
        }

        return $envKey;
    }

}
