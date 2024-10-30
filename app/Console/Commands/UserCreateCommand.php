<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $input['first_name'] = $this->ask('FirstName : ');
        $input['last_name'] = $this->ask('LastName : ');
        $input['email'] = $this->ask('E-mail : ');
        $input['password'] = $this->secret('Password : ');

        try {
            $user = User::create($input);
            $user->assignRole(User::ROLE_USER);
        } catch (\Throwable $exception) {
            $this->error('Could not create user :: ' . $exception->getMessage());

            return Command::FAILURE;
        }

        $this->info('User added successfully');

        return Command::SUCCESS;
    }
}
