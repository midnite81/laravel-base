<?php


namespace Midnite81\LaravelBase\Commands\Users;


use Midnite81\LaravelBase\Services\Password\Passworder;

trait PasswordChooser
{
    /**
     * Select type of password
     */
    public function selectTypeOfPassword()
    {
        $choice = null;

        while(! in_array($choice, [1, 2])) {
            $this->info('Please make a selection regarding the password:');
            $this->info('[1] Input your own password');
            $this->info('[2] Have a password generated for you');
            $choice = $this->ask('Please make a selection');

            if ($choice == 1) {
                return $this->askForNewPassword();
            }
            if ($choice == 2) {
                return $this->generatePassword();
            }
        }
    }

    /**
     * Get selection type of generated passwordgit
     */
    public function generatePassword()
    {
        $choice = null;

        while(! in_array($choice, [1, 2])) {
            $this->info('What type of generated password would you like?');
            $this->info('[1] WordBased');
            $this->info('[2] Random');
            $choice = $this->ask('Please make a selection');

            if ($choice == 1) {
                return $this->makeGenerated('wordbased');
            }
            if ($choice == 2) {
                return $this->makeGenerated('random');
            }
        }
    }

    /**
     * Create a generated password
     *
     * @param $type
     */
    public function makeGenerated($type)
    {
        while($this->password == null) {
            $password = ($type == 'wordbased') ? Passworder::createWordBasedPassword() : Passworder::createRandomPassword();

            $this->info('Password: ' . $password);
            $this->info('Nato version: ' . $password->toNato());
            $passwordOk = $this->ask('Is this password ok? [y/n]');

            if (strtolower($passwordOk) == 'y') {
                $this->password = $password;
            }
        }
    }

    /**
     * Set a normal password
     *
     * @return mixed
     */
    protected function askForNewPassword()
    {
        $this->password = $this->ask('What would you like to set the password to?');

        $q = $this->ask('Confirm the password as "' . $this->password . '" [y/n]');

        if (strtolower($q) != 'y') {
            return $this->askForNewPassword();
        }
    }
}